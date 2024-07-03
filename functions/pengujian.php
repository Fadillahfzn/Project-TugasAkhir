<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

// Koneksi ke database menggunakan PDO sebelum last update
$dsn = 'mysql:host=localhost;dbname=taproject';
$username = 'root';
$password = '';
$options = [];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit;
}

// Definisikan kelas sebelum deserialisasi
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
            $this->idf[$i] = log10($numDocuments / ($docCount + 1));
        }
    }

    public function transform($vectors) {
        $tfidfVectors = [];
        foreach ($vectors as $vector) {
            $tfidfVector = [];
            foreach ($vector as $index => $termCount) {
                if (isset($this->idf[$index])) { // Memeriksa apakah $index ada di $this->idf
                    $tf = $termCount / array_sum($vector);
                    $tfidfVector[] = $tf * $this->idf[$index];
                } else {
                    // Tindakan jika $index tidak ada di $this->idf, misalnya:
                    $tfidfVector[] = 0; 
                }
            }
            $tfidfVectors[] = $tfidfVector;
        }
        return $tfidfVectors;
    }
    // public function transform($vectors) {
    //     $tfidfVectors = [];
    //     foreach ($vectors as $vector) {
    //         $tfidfVector = [];
    //         foreach ($vector as $index => $termCount) {
    //             if (!isset($this->idf[$index])) {
    //                 continue; // Lewati indeks jika tidak ada di $this->idf
    //             }
    //             $tf = $termCount / array_sum($vector);
    //             $tfidfVector[] = $tf * $this->idf[$index];
    //         }
    //         $tfidfVectors[] = $tfidfVector;
    //     }
    //     return $tfidfVectors;
    // }
    
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
            $this->classProbabilities[$label] = $count / $numDocuments; // Probabilitas prior untuk mengihitung probabilats masing masing kelas
        }

        foreach ($this->featureCounts as $label => $counts) {
            $totalTerms = array_sum($counts);
            $this->featureProbabilities[$label] = array_map(function($count) use ($totalTerms) {
                return ($count + 1) / ($totalTerms + 1); // Likelihood dengan memakai laplace smoothing untuk menghindari probabilitas 0
            }, $counts);
        }
    }

    public function predict($vector) {
        $scores = [];
        foreach ($this->classProbabilities as $label => $classProbability) {
            $score = log10($classProbability);
            foreach ($vector as $termIndex => $count) {
                $score += $count * log10($this->featureProbabilities[$label][$termIndex]); // Posterior untuk perhitungan
            }
            $scores[$label] = $score;
        }
        return array_search(max($scores), $scores);
    }
}


$namaModel = isset($_POST['namaModel']) ? $_POST['namaModel'] : '';
// Muat model dari file
$modelFile = 'model_02-07-2024_05-08-28-PM.model';
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
$positiveNetral = 0;
$falseNegative = 0;
$trueNegative = 0;
$negativeNetral = 0;
$falsePositive = 0;
$trueNetral = 0;
$netralPositive = 0;
$netralNegative = 0;
$predictPositive = 0;
$predictNegative = 0;
$predictNetral = 0;

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

    if ($testing->sentiment == "positif") {
        if ($prediction == "positif") {
            $truePositive++; // True Positive
            $predictPositive++;
        } elseif ($prediction == "netral") {
            $positiveNetral++; // Positive Netral
            $predictNetral++;
        } else {
            $falseNegative++; // False Negative
            $predictNegative++;
        }
    } elseif ($testing->sentiment == "negatif") {
        if ($prediction == "negatif") {
            $trueNegative++; // True Negative
            $predictNegative++;
        } elseif ($prediction == "netral") {
            $negativeNetral++; // Negative Netral
            $predictNetral++;
        } else {
            $falsePositive++; // False Positive
            $predictPositive++;
        }
    } elseif ($testing->sentiment == "netral") {
        if ($prediction == "netral") {
            $trueNetral++; // True Netral
            $predictNetral++;
        } elseif ($prediction == "positif") {
            $netralPositive++; // Netral Positive
            $predictPositive++;
        } elseif ($prediction == "negatif") {
            $netralNegative++; // Netral Negative
            $predictNegative++;
        } else {
            // Handle jika terjadi kesalahan prediksi untuk sentimen netral
        }
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

$jumlahSentimen = isset($_POST['jumlahSentimen']) ? $_POST['jumlahSentimen'] : '';
$trainingPositif = isset($_POST['trainingPositif']) ? $_POST['trainingPositif'] : '';
$trainingNegatif = isset($_POST['trainingNegatif']) ? $_POST['trainingNegatif'] : '';
$trainingNetral = isset($_POST['trainingNetral']) ? $_POST['trainingNetral'] : '';

// $jumlahSentimen = 100;  
// $trainingPositif = 50;  
// $trainingNegatif = 50;  

$data = [
    'created_at' => date('Y-m-d H:i:s'),
    'true_positive' => $truePositive,
    'positive_netral' => $positiveNetral,
    'false_negative' => $falseNegative,
    'true_negative' => $trueNegative,
    'negative_netral' => $negativeNetral,
    'false_positive' => $falsePositive,
    'true_netral' => $trueNetral,
    'netral_positive' => $netralPositive,
    'netral_negative' => $netralNegative,
    'data_testing' => count($testings),
    'data_training' => $jumlahSentimen,
    'data_training_positive' => $trainingPositif,
    'data_training_negative' => $trainingNegatif,
    'data_training_netral' => $trainingNetral,
    'predict_positive' => $predictPositive,
    'predict_negative' => $predictNegative,
    'predict_netral' => $predictNetral,
    'vocabulary' => json_encode($vocab),
    'vocab_weight' => json_encode($weight),
];

// Cek apakah ada riwayat sebelumnya
$query = $pdo->query("SELECT * FROM riwayat");
if ($query->rowCount() == 0) {
    $insertQuery = "INSERT INTO riwayat (created_at, true_positive, positive_netral, false_negative, true_negative, negative_netral, false_positive, true_netral,  netral_positive, netral_negative,  data_testing, data_training, data_training_positive, data_training_negative, data_training_netral, predict_positive, predict_negative, predict_netral, vocabulary, vocab_weight) VALUES (:created_at, :true_positive, :positive_netral, :false_negative, :true_negative, :negative_netral, :false_positive, :true_netral, :netral_positive, :netral_negative,   :data_testing, :data_training, :data_training_positive, :data_training_negative, :data_training_netral, :predict_positive, :predict_negative, :predict_netral, :vocabulary, :vocab_weight)";
    $stmt = $pdo->prepare($insertQuery);
    $stmt->execute($data);
    echo "Berhasil, Sukses Melakukan Pengujian\n";
} else {
    $updateQuery = "UPDATE riwayat SET created_at = :created_at, true_positive = :true_positive, positive_netral = :positive_netral, false_negative = :false_negative, true_negative = :true_negative, negative_netral = :negative_netral, false_positive = :false_positive, true_netral = :true_netral, netral_positive = :netral_positive, netral_negative = :netral_negative, data_testing = :data_testing, data_training = :data_training, data_training_positive = :data_training_positive, data_training_negative = :data_training_negative, data_training_netral = :data_training_netral, predict_positive = :predict_positive, predict_negative = :predict_negative, predict_netral = :predict_netral, vocabulary = :vocabulary, vocab_weight = :vocab_weight";
        $stmt = $pdo->prepare($updateQuery);

    $stmt->execute($data);
    echo "Berhasil, Sukses Melakukan Pengujian\n";
}


header("location: " . $_SERVER['HTTP_REFERER']);

// ?>