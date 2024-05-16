<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

$host = 'localhost';
$db   = 'taproject'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan user database Anda
$pass = ''; // Ganti dengan password database Anda
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    exit;
}

function splitData(array $data, $testSize = 0.2) {
    $n = count($data);
    $nTest = (int) round($n * $testSize); // menghitung jumlah data uji
    shuffle($data); // mengacak data

    $testData = array_slice($data, 0, $nTest); // data testing
    $trainData = array_slice($data, $nTest); // data training

    return ['train' => $trainData, 'test' => $testData];
}

// mengambil data dari table proses untuk isi data split
$query = "SELECT * FROM proses";
$stmt = $pdo->query($query);
$data = $stmt->fetchAll();

// memanggil function splitData
$splitData = splitData($data, 0.2);

try {
    $pdo->beginTransaction();
    $insertQuery = "INSERT INTO data_training (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
    foreach ($splitData['train'] as $trainData) {
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([$trainData['username'], $trainData['full_text'], $trainData['processed_text'], $trainData['sentiment']]);
    }

    $insertQuery = "INSERT INTO data_testing (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
    foreach ($splitData['test'] as $testData) {
        $stmt = $pdo->prepare($insertQuery);
        $stmt->execute([$testData['username'], $testData['full_text'], $testData['processed_text'], $testData['sentiment']]);
    }
    $pdo->commit();
} catch (PDOException $e) {
    $pdo->rollBack();
    echo "Error saat menyimpan data: " . $e->getMessage();
    exit;
}

// hasil output jumlah data
echo "Jumlah data latih disimpan: " . count($splitData['train']) . "<br>";
echo "Jumlah data uji disimpan: " . count($splitData['test']) . "<br>";

if (!empty($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "HTTP_REFERER tidak tersedia.";
}
?>
