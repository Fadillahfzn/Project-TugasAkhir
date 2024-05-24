<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database menggunakan PDO
$dsn = 'mysql:host=localhost;dbname=taproject';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

// Mengambil data training dari database
$query = $pdo->query("SELECT real_text, sentiment FROM data_training");
$dataTraining = $query->fetchAll(PDO::FETCH_OBJ);

// Menyiapkan dokumen dan label
$documents = [];
$labels = [];
foreach ($dataTraining as $data) {
    $documents[] = $data->real_text;
    $labels[] = $data->sentiment;
}

// Implementasi tokenizer, vectorizer, tf-idf transformer, dan naive bayes classifier
class Tokenizer {
    public function tokenize($text) {
        return explode(' ', $text);
    }
}

class Vectorizer {
    private $tokenizer;
    private $vocabulary = [];

    public function __construct($tokenizer) {
        $this->tokenizer = $tokenizer;
    }

    public function fit($documents) {
        foreach ($documents as $document) {
            $tokens = $this->tokenizer->tokenize($document);
            foreach ($tokens as $token) {
                if (!in_array($token, $this->vocabulary)) {
                    $this->vocabulary[] = $token;
                }
            }
        }
    }

    public function transform($documents) {
        $vectors = [];
        foreach ($documents as $document) {
            $tokens = $this->tokenizer->tokenize($document);
            $vector = array_fill(0, count($this->vocabulary), 0);
            foreach ($tokens as $token) {
                if (($index = array_search($token, $this->vocabulary)) !== false) {
                    $vector[$index]++;
                }
            }
            $vectors[] = $vector;
        }
        return $vectors;
    }

    public function getVocabulary() {
        return $this->vocabulary;
    }
}

class TfIdfTransformer {
    private $idf = [];

    public function fit($vectors) {
        $numDocuments = count($vectors);
        $numTerms = count($vectors[0]);
        for ($i = 0; $i < $numTerms; $i++) {
            $docCount = 0;
            foreach ($vectors as $vector) {
                if ($vector[$i] > 0) {
                    $docCount++;
                }
            }
            $this->idf[$i] = log($numDocuments / ($docCount + 1));
        }
    }

    public function transform($vectors) {
        $tfidfVectors = [];
        foreach ($vectors as $vector) {
            $tfidfVector = [];
            foreach ($vector as $index => $termCount) {
                $tf = $termCount / array_sum($vector);
                $tfidfVector[] = $tf * $this->idf[$index];
            }
            $tfidfVectors[] = $tfidfVector;
        }
        return $tfidfVectors;
    }
}

class NaiveBayes {
    private $classCounts = [];
    private $featureCounts = [];
    private $classProbabilities = [];
    private $featureProbabilities = [];

    public function train($vectors, $labels) {
        $numDocuments = count($vectors);
        $numTerms = count($vectors[0]);

        foreach ($labels as $label) {
            if (!isset($this->classCounts[$label])) {
                $this->classCounts[$label] = 0;
            }
            $this->classCounts[$label]++;
        }

        foreach ($labels as $index => $label) {
            if (!isset($this->featureCounts[$label])) {
                $this->featureCounts[$label] = array_fill(0, $numTerms, 0);
            }
            foreach ($vectors[$index] as $termIndex => $count) {
                $this->featureCounts[$label][$termIndex] += $count;
            }
        }

        foreach ($this->classCounts as $label => $count) {
            $this->classProbabilities[$label] = $count / $numDocuments;
        }

        foreach ($this->featureCounts as $label => $counts) {
            $totalTerms = array_sum($counts);
            $this->featureProbabilities[$label] = array_map(function($count) use ($totalTerms) {
                return ($count + 1) / ($totalTerms + 1);
            }, $counts);
        }
    }

    public function predict($vector) {
        $scores = [];
        foreach ($this->classProbabilities as $label => $classProbability) {
            $score = log($classProbability);
            foreach ($vector as $termIndex => $count) {
                $score += $count * log($this->featureProbabilities[$label][$termIndex]);
            }
            $scores[$label] = $score;
        }
        return array_search(max($scores), $scores);
    }
}

// Inisialisasi komponen
$tokenizer = new Tokenizer();
$vectorizer = new Vectorizer($tokenizer);
$tfidfTransformer = new TfIdfTransformer();
$naiveBayes = new NaiveBayes();

// Latih model
$vectorizer->fit($documents);
$vectors = $vectorizer->transform($documents);
$tfidfTransformer->fit($vectors);
$tfidfVectors = $tfidfTransformer->transform($vectors);
$naiveBayes->train($tfidfVectors, $labels);

// Simpan model ke file
$modelData = serialize([$vectorizer, $tfidfTransformer, $naiveBayes]);
$modelFile = 'model_' . date('d-m-Y_h-i-s-A') . '.model';
file_put_contents($modelFile, $modelData);

// Simpan informasi model ke database
$query = $pdo->prepare("INSERT INTO data_model (model_name, model_path, created_at) VALUES (:name, :path, NOW())");
$query->execute(['name' => $modelFile, 'path' => $modelFile]);

echo "Model berhasil disimpan.\n";

// Pengujian
$modelFile = 'model_24-05-2024_12-50-39-PM.model';
$modelData = file_get_contents($modelFile);
list($vectorizer, $tfidfTransformer, $naiveBayes) = unserialize($modelData);

// Pastikan model memiliki metode predict
if (!method_exists($naiveBayes, 'predict')) {
    die('Failed to load model or method predict does not exist.');
}

// Mengambil data uji dari database
$query = $pdo->query("SELECT real_text, sentiment FROM data_testing");
$testings = $query->fetchAll(PDO::FETCH_OBJ);

// Inisialisasi variabel untuk True positif, true negatif, false positif, false negatif, prediksi positif, dan prediksi negatif
$truePositive = 0;
$trueNegative = 0;
$falsePositive = 0;
$falseNegative = 0;
$predictPositive = 0;
$predictNegative = 0;

$counter = 1;
$count = count($testings);

foreach ($testings as $testing) {
    // Ubah teks menjadi array
    $newTextArray = [$testing->real_text];

    // Lakukan prediksi menggunakan model yang telah dimuat
    $vector = $vectorizer->transform($newTextArray);
    $tfidfVector = $tfidfTransformer->transform($vector);
    $predictedLabel = $naiveBayes->predict($tfidfVector[0]);

    // Ambil hasil prediksi
    $prediction = $predictedLabel;

    if ($testing->sentiment == "positif" && $prediction == "positif") {
        $truePositive++;
        $predictPositive++;
    } elseif ($testing->sentiment == "positif" && $prediction == "negatif") {
        $falseNegative++;
        $predictNegative++;
    } elseif ($testing->sentiment == "negatif" && $prediction == "negatif") {
        $trueNegative++;
        $predictNegative++;
    } else {
        $falsePositive++;
        $predictPositive++;
    }
    echo "$counter / $count\n";
    $counter++;
}

// Mengambil data uji dari database lagi untuk menghitung vocabulary dan weight
$query = $pdo->query("SELECT real_text FROM data_testing");
$arrayUji = $query->fetchAll(PDO::FETCH_OBJ);
$dataUji = [];
foreach ($arrayUji as $uji) {
    $dataUji[] = $uji->real_text;
}

// Implementasi sederhana dari tokenizer, vectorizer, dan TF-IDF transformer
$tokenizer = new Tokenizer();
$vectorizer = new Vectorizer($tokenizer);
$vectorizer->fit($dataUji);
$vocab = $vectorizer->getVocabulary();

$transformer = new TfIdfTransformer();
$tfidfVectors = $transformer->transform($vectorizer->transform($dataUji));

$weight = [];
foreach ($tfidfVectors as $vector) {
    $weight[] = array_sum($vector);
}

// Menghitung data training
$jumlahSentimen = count($labels);
$trainingPositif = count(array_filter($labels, fn($label) => $label == 'positif'));
$trainingNegatif = count(array_filter($labels, fn($label) => $label == 'negatif'));

$data = [
    'created_at' => date('Y-m-d H:i:s'),
    'true_positive' => $truePositive,
    'false_positive' => $falsePositive,
    'true_negative' => $trueNegative,
    'false_negative' => $falseNegative,
    'data_testing' => count($testings),
    'data_training' => $jumlahSentimen,
    'data_training_positive' => $trainingPositif,
    'data_training_negative' => $trainingNegatif,
    'predict_positive' => $predictPositive,
    'predict_negative' => $predictNegative,
    'vocabulary' => json_encode($vocab),
    'vocab_weight' => json_encode($weight),
];

// Cek apakah ada riwayat sebelumnya
$query = $pdo->query("SELECT * FROM riwayat");
if ($query->rowCount() == 0) {
    $insertQuery = "INSERT INTO riwayat (created_at, true_positive, false_positive, true_negative, false_negative, data_testing, data_training, data_training_positive, data_training_negative, predict_positive, predict_negative, vocabulary, vocab_weight) VALUES (:created_at, :true_positive, :false_positive, :true_negative, :false_negative, :data_testing, :data_training, :data_training_positive, :data_training_negative, :predict_positive, :predict_negative, :vocabulary, :vocab_weight)";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute($data);
    echo "Berhasil, Sukses Melakukan Pengujian\n";
} else {
    $updateQuery = "UPDATE riwayat SET created_at = :created_at, true_positive = :true_positive, false_positive = :false_positive, true_negative = :true_negative, false_negative = :false_negative, data_testing = :data_testing, data_training = :data_training, data_training_positive = :data_training_positive, data_training_negative = :data_training_negative, predict_positive = :predict_positive, predict_negative = :predict_negative, vocabulary = :vocabulary, vocab_weight = :vocab_weight";
    $stmt = $pdo->prepare($updateQuery);
    $stmt->execute($data);
    echo "Berhasil, Sukses Melakukan Pengujian\n";
}

?>