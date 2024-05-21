<?php
// ini_set('display_errors', 1);
// error_reporting(E_ALL);

// $host = 'localhost';
// $db   = 'taproject'; // Ganti dengan nama database Anda
// $user = 'root'; // Ganti dengan user database Anda
// $pass = ''; // Ganti dengan password database Anda
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];

// try {
//     $pdo = new PDO($dsn, $user, $pass, $options);
// } catch (PDOException $e) {
//     echo "Koneksi database gagal: " . $e->getMessage();
//     exit;
// }

// function splitData(array $data, $testSize = 0.2) {
//     $n = count($data);
//     $nTest = (int) round($n * $testSize); // menghitung jumlah data uji
//     shuffle($data); // mengacak data

//     $testData = array_slice($data, 0, $nTest); // data testing
//     $trainData = array_slice($data, $nTest); // data training

//     return ['train' => $trainData, 'test' => $testData];
// }

// // mengambil data dari table proses untuk isi data split
// $query = "SELECT * FROM proses";
// $stmt = $pdo->query($query);
// $data = $stmt->fetchAll();

// // memanggil function splitData
// $splitData = splitData($data, 0.2);

// try {
//     $pdo->beginTransaction();
//     $insertQuery = "INSERT INTO data_training (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
//     foreach ($splitData['train'] as $trainData) {
//         $stmt = $pdo->prepare($insertQuery);
//         $stmt->execute([$trainData['username'], $trainData['full_text'], $trainData['processed_text'], $trainData['sentiment']]);
//     }

//     $insertQuery = "INSERT INTO data_testing (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
//     foreach ($splitData['test'] as $testData) {
//         $stmt = $pdo->prepare($insertQuery);
//         $stmt->execute([$testData['username'], $testData['full_text'], $testData['processed_text'], $testData['sentiment']]);
//     }
//     $pdo->commit();
// } catch (PDOException $e) {
//     $pdo->rollBack();
//     echo "Error saat menyimpan data: " . $e->getMessage();
//     exit;
// }

// // hasil output jumlah data
// echo "Jumlah data latih disimpan: " . count($splitData['train']) . "<br>";
// echo "Jumlah data uji disimpan: " . count($splitData['test']) . "<br>";

// if (!empty($_SERVER['HTTP_REFERER'])) {
//     header("Location: " . $_SERVER['HTTP_REFERER']);
// } else {
//     echo "HTTP_REFERER tidak tersedia.";
// }


// $host = 'localhost';
// $db   = 'taproject'; // Ganti dengan nama database Anda
// $user = 'root'; // Ganti dengan user database Anda
// $pass = ''; // Ganti dengan password database Anda
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $options = [
//     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES   => false,
// ];

// try {
//     $pdo = new PDO($dsn, $user, $pass, $options);
// } catch (PDOException $e) {
//     echo "Koneksi database gagal: " . $e->getMessage();
//     exit;
// }

// // fungsi hapus data
// if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
//     try {
//         $pdo->beginTransaction();
//         $pdo->exec("DELETE FROM data_training");
//         $pdo->exec("DELETE FROM data_testing");
//         $pdo->commit();
//         echo "Semua data berhasil dihapus dari tabel data_training dan data_testing.";
//     } catch (PDOException $e) {
//         $pdo->rollBack();
//         echo "Error: " . $e->getMessage();
//     }
//     header("Location: " . $_SERVER['HTTP_REFERER']);
//     exit;
// }

// // fungsi split data
// function splitData(array $data, $testSize = 0.2) {
//     $n = count($data);
//     $nTest = (int) round($n * $testSize); // menghitung jumlah data uji
//     shuffle($data); // mengacak data

//     $testData = array_slice($data, 0, $nTest); // data testing
//     $trainData = array_slice($data, $nTest); // data training

//     return ['train' => $trainData, 'test' => $testData];
// }

// $query = "SELECT * FROM proses";
// $stmt = $pdo->query($query);
// $data = $stmt->fetchAll();

// $splitData = splitData($data, 0.2);

// try {
//     $pdo->beginTransaction();
//     $insertTrain = "INSERT INTO data_training (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
//     $insertTest = "INSERT INTO data_testing (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";

//     foreach ($splitData['train'] as $trainData) {
//         $stmt = $pdo->prepare($insertTrain);
//         $stmt->execute([$trainData['username'], $trainData['full_text'], $trainData['processed_text'], $trainData['sentiment']]);
//     }

//     foreach ($splitData['test'] as $testData) {
//         $stmt = $pdo->prepare($insertTest);
//         $stmt->execute([$testData['username'], $testData['full_text'], $testData['processed_text'], $testData['sentiment']]);
//     }

//     $pdo->commit();

//     echo "Jumlah data latih disimpan: " . count($splitData['train']) . "<br>";
//     echo "Jumlah data uji disimpan: " . count($splitData['test']) . "<br>";
// } catch (PDOException $e) {
//     $pdo->rollBack();
//     echo "Error saat menyimpan data: " . $e->getMessage();
// }

// if (!empty($_SERVER['HTTP_REFERER'])) {
//     header("Location: " . $_SERVER['HTTP_REFERER']);
// } else {
//     echo "HTTP_REFERER tidak tersedia.";
// }

// session_start();  // Mulai session

// $host = 'localhost';
// $db = 'taproject'; // Ganti dengan nama database Anda
// $user = 'root'; // Ganti dengan user database Anda
// $pass = ''; // Ganti dengan password database Anda
// $charset = 'utf8mb4';

// $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
// $options = [
//     PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
//     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
//     PDO::ATTR_EMULATE_PREPARES => false,
// ];

// try {
//     $pdo = new PDO($dsn, $user, $pass, $options);
// } catch (PDOException $e) {
//     echo "Koneksi database gagal: " . $e->getMessage();
//     exit;
// }

// if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
//     // Logika penghapusan
//     $pdo->exec("DELETE FROM data_training");
//     $pdo->exec("DELETE FROM data_testing");
//     unset($_SESSION['data_split_done']);  // Reset session setelah penghapusan data
//     header("Location: " . $_SERVER['HTTP_REFERER']);
//     exit;
// }

// function splitData(array $data, $testSize = 0.2) {
//     $n = count($data);
//     $nTest = (int) round($n * $testSize);
//     shuffle($data);
//     $testData = array_slice($data, 0, $nTest);
//     $trainData = array_slice($data, $nTest);
//     return ['train' => $trainData, 'test' => $testData];
// }

// if (!isset($_SESSION['data_split_done'])) {  // Periksa session untuk mencegah split data berulang kali
//     $query = "SELECT * FROM proses";
//     $stmt = $pdo->query($query);
//     $data = $stmt->fetchAll();
    
//     $splitData = splitData($data, 0.2);

//     try {
//         $pdo->beginTransaction();
//         $insertTrain = "INSERT INTO data_training (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
//         $insertTest = "INSERT INTO data_testing (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
        
//         foreach ($splitData['train'] as $trainData) {
//             $stmt = $pdo->prepare($insertTrain);
//             $stmt->execute([$trainData['username'], $trainData['full_text'], $trainData['processed_text'], $trainData['sentiment']]);
//         }
        
//         foreach ($splitData['test'] as $testData) {
//             $stmt = $pdo->prepare($insertTest);
//             $stmt->execute([$testData['username'], $testData['full_text'], $testData['processed_text'], $testData['sentiment']]);
//         }
        
//         $pdo->commit();
        
//         echo "Jumlah data latih disimpan: " . count($splitData['train']) . "<br>";
//         echo "Jumlah data uji disimpan: " . count($splitData['test']) . "<br>";

//         $_SESSION['data_split_done'] = true;  // Set session untuk menandakan split data sudah dilakukan
        
//     } catch (PDOException $e) {
//         $pdo->rollBack();
//         echo "Error saat menyimpan data: " . $e->getMessage();
//     }
// } else {
//     echo "Data sudah diproses, tidak diperlukan pemrosesan ulang.";
// }

session_start();  // Mulai session

$host = 'localhost';
$db = 'taproject'; // Ganti dengan nama database Anda
$user = 'root'; // Ganti dengan user database Anda
$pass = ''; // Ganti dengan password database Anda
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    echo "Koneksi database gagal: " . $e->getMessage();
    exit;
}

if (isset($_GET['aksi']) && $_GET['aksi'] == "hapus") {
    // Logika penghapusan
    $pdo->exec("DELETE FROM data_training");
    $pdo->exec("DELETE FROM data_testing");
    unset($_SESSION['data_split_done']);  // Reset session setelah penghapusan data
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

function splitData(array $data, $testSize = 0.2) {
    $n = count($data);
    $nTest = (int) round($n * $testSize);
    shuffle($data);
    $testData = array_slice($data, 0, $nTest);
    $trainData = array_slice($data, $nTest);
    return ['train' => $trainData, 'test' => $testData];
}

if (!isset($_SESSION['data_split_done'])) {  // Periksa session untuk mencegah split data berulang kali
    $query = "SELECT * FROM label_lexicon";
    $stmt = $pdo->query($query);
    $data = $stmt->fetchAll();
    
    $splitData = splitData($data, 0.2);

    try {
        $pdo->beginTransaction();
        $insertTrain = "INSERT INTO data_training (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
        $insertTest = "INSERT INTO data_testing (username, real_text, clean_text, sentiment) VALUES (?, ?, ?, ?)";
        
        foreach ($splitData['train'] as $trainData) {
            $stmt = $pdo->prepare($insertTrain);
            $stmt->execute([$trainData['username'], $trainData['full_text'], $trainData['processed_text'], $trainData['sentiment']]);
        }
        
        foreach ($splitData['test'] as $testData) {
            $stmt = $pdo->prepare($insertTest);
            $stmt->execute([$testData['username'], $testData['full_text'], $testData['processed_text'], $testData['sentiment']]);
        }
        
        $pdo->commit();
        
        echo "<script>alert('Data berhasil diproses.'); window.location.href='../splitdata';</script>";

        // echo "Jumlah data latih disimpan: " . count($splitData['train']) . "<br>";
        // echo "Jumlah data uji disimpan: " . count($splitData['test']) . "<br>";

        $_SESSION['data_split_done'] = true;  // Set session untuk menandakan split data sudah dilakukan
        
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error saat menyimpan data: " . $e->getMessage();
    }
} else {
    echo "<script>alert('Data sudah diproses, tidak diperlukan split data ulang.'); window.location.href='../splitdata';</script>";
}

?>
