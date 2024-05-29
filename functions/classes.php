<?php

class Tokenizer {
    public function tokenize($text) {
        // Simple whitespace tokenizer
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
                $index = array_search($token, $this->vocabulary);
                if ($index !== false) {
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
            foreach ($counts as $termIndex => $count) {
                $this->featureProbabilities[$label][$termIndex] = ($count + 1) / ($totalTerms + $numTerms);
            }
        }
    }

    public function predict($vector) {
        $scores = [];
        foreach ($this->classProbabilities as $label => $classProbability) {
            $score = log($classProbability);
            foreach ($vector as $termIndex => $count) {
                if ($termIndex < count($this->featureProbabilities[$label])) {
                    $score += $count * log($this->featureProbabilities[$label][$termIndex] ?? 1);
                }
            }
            $scores[$label] = $score;
        }
        return array_search(max($scores), $scores);
    }
}

?>
