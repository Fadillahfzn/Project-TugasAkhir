<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
set_time_limit(300); // Set waktu eksekusi maksimal menjadi 300 detik (5 menit)

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
            $this->idf[$i] = log($numDocuments / ($docCount + 1)); // perhitungan idf
        }
    }

    public function transform($vectors) {
        $tfidfVectors = [];
        foreach ($vectors as $vector) {
            $tfidfVector = [];
            foreach ($vector as $index => $termCount) {
                $tf = $termCount / array_sum($vector); // perhitungan tf
                $tfidfVector[] = $tf * $this->idf[$index]; // perhitungan tf-idf
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

    // Latih model dengan data latih
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

    // Latih model untuk predict
    public function predict($vector) {
        $scores = [];
        foreach ($this->classProbabilities as $label => $classProbability) {
            $score = log($classProbability);
            foreach ($vector as $termIndex => $count) {
                $score += $count * log($this->featureProbabilities[$label][$termIndex] ?? 1);
            }
            $scores[$label] = $score;
        }
        return array_search(max($scores), $scores);
    }
}

// Confusion Matrix
class MetricsCalculator {
    public static function calculateMetrics($actualLabels, $predictedLabels) {
        $truePositive = ['positif' => 0, 'negatif' => 0, 'netral' => 0];
        $falsePositive = ['positif' => 0, 'negatif' => 0, 'netral' => 0];
        $falseNegative = ['positif' => 0, 'negatif' => 0, 'netral' => 0];
        $trueNegative = ['positif' => 0, 'negatif' => 0, 'netral' => 0];

        $total = count($actualLabels);

        for ($i = 0; $i < $total; $i++) {
            foreach (['positif', 'negatif', 'netral'] as $class) {
                if ($actualLabels[$i] == $class && $predictedLabels[$i] == $class) {
                    $truePositive[$class]++;
                } elseif ($actualLabels[$i] != $class && $predictedLabels[$i] == $class) {
                    $falsePositive[$class]++;
                } elseif ($actualLabels[$i] == $class && $predictedLabels[$i] != $class) {
                    $falseNegative[$class]++;
                } elseif ($actualLabels[$i] != $class && $predictedLabels[$i] != $class) {
                    $trueNegative[$class]++;
                }
            }
        }

        $precision = [];
        $recall = [];
        $accuracy = [];

        foreach (['positif', 'negatif', 'netral'] as $class) {
            $precision[$class] = $truePositive[$class] / max(1, ($truePositive[$class] + $falsePositive[$class]));
            $recall[$class] = $truePositive[$class] / max(1, ($truePositive[$class] + $falseNegative[$class]));
            $accuracy[$class] = ($truePositive[$class] + $trueNegative[$class]) / $total;
        }

        $overallAccuracy = array_sum($truePositive) / $total;

        return [
            'precision' => $precision,
            'recall' => $recall,
            'accuracy' => $accuracy,
            'overallAccuracy' => $overallAccuracy
        ];
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

// Prediksi dan evaluasi
$predictions = [];
foreach ($tfidfVectors as $vector) {
    $predictions[] = $naiveBayes->predict($vector);
}

$metrics = MetricsCalculator::calculateMetrics($labels, $predictions);
echo "Metrics:\n";
echo "Precision: " . print_r($metrics['precision'], true) . "\n";
echo "Recall: " . print_r($metrics['recall'], true) . "\n";
echo "Accuracy: " . print_r($metrics['accuracy'], true) . "\n";
echo "Overall Accuracy: {$metrics['overallAccuracy']}\n";

// Hitung total label positif dan negatif
$totalPositive = count(array_filter($labels, fn($label) => $label === 'positif'));
$totalNegative = count(array_filter($labels, fn($label) => $label === 'negatif'));
$totalNetral = count(array_filter($labels, fn($label) => $label === 'netral'));


// Simpan model ke file
$modelData = serialize([$vectorizer, $tfidfTransformer, $naiveBayes]);
$modelFile = 'model_' . date('d-m-Y_h-i-s-A') . '.model';
echo $modelFile;
file_put_contents($modelFile, $modelData);

// Simpan informasi model ke database
$query = $pdo->prepare("INSERT INTO data_model (model_name, model_path, positive_label, negative_label, netral_label, created_at) VALUES (:name, :path, :totalPositive, :totalNegative, :totalNetral, NOW())");
$query->execute(['name' => $modelFile, 'path' => $modelFile, 'totalPositive' => $totalPositive, 'totalNegative' => $totalNegative, 'totalNetral' => $totalNetral]);


echo "Model berhasil disimpan.\n";

header("Location: " . $_SERVER['HTTP_REFERER']);    
// // Simpan model ke file
// $dataModel = serialize([$vectorizer, $tfidfTransformer, $naiveBayes]);
// $direktoriModel = __DIR__ . '/models';  // Pastikan direktori ini ada dan memiliki izin tulis
// if (!file_exists($direktoriModel)) {
//     mkdir($direktoriModel, 0777, true);  // Buat direktori jika tidak ada
// }
// $namaFileModel = $direktoriModel . '/model_' . date('d-m-Y_h-i-s-A') . '.model';

// // Periksa apakah data dapat diserialisasi dan tidak kosong
// if ($dataModel) {
//     $hasil = file_put_contents($namaFileModel, $dataModel);
//     if ($hasil === false) {
//         echo "Gagal menyimpan file model.\n";
//     } else {
//         echo "File model berhasil disimpan.\n";
//     }
// } else {
//     echo "Tidak ada data model untuk disimpan.\n";
// }

// Lanjutkan dengan operasi basis data...


?>
