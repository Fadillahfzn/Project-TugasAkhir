<?php
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
                $score += $count * log($this->featureProbabilities[$label][$termIndex] ?? 1);
            }
            $scores[$label] = $score;
        }
        return array_search(max($scores), $scores);
    }

    // Fungsi untuk mengevaluasi relasi sentimen
    public function evaluateSentimentRelations($vectors, $actualLabels) {
        $predictions = [];
        foreach ($vectors as $vector) {
            $predictions[] = $this->predict($vector);
        }

        $sentimentRelations = [
            'positif' => ['positif' => 0, 'negatif' => 0, 'netral' => 0],
            'negatif' => ['positif' => 0, 'negatif' => 0, 'netral' => 0],
            'netral' => ['positif' => 0, 'negatif' => 0, 'netral' => 0]
        ];

        foreach ($actualLabels as $index => $actual) {
            $predicted = $predictions[$index];
            $sentimentRelations[$actual][$predicted]++;
        }

        return $sentimentRelations;
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

// Evaluasi hubungan sentimen
$relations = $naiveBayes->evaluateSentimentRelations($tfidfVectors, $labels);
foreach ($relations as $actual => $predictedCounts) {
    foreach ($predictedCounts as $predicted => $count) {
        echo "$actual = $predicted: $count\n";
    }
}

// Simpan model ke file
$modelData = serialize([$vectorizer, $tfidfTransformer, $naiveBayes]);
$modelFile = 'model_' . date('d-m-Y_h-i-s-A') . '.model';
file_put_contents($modelFile, $modelData);

// Simpan informasi model ke database
$query = $pdo->prepare("INSERT INTO data_model (model_name, model_path, created_at) VALUES (:name, :path, NOW())");
$query->execute(['name' => $modelFile, 'path' => $modelFile]);

echo "Model berhasil disimpan.\n";
?>
