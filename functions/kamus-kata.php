<?php

include "../koneksi.php";

if($_GET['aksi'] == "tambah-positif") {
    $kata = $_POST['kata'];
    
    $query = "INSERT INTO sentiment_positif (kata) VALUES ('$kata')";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['berhasil'] = 'Data berhasil disimpan!';
    } else {
        $_SESSION['gagal'] = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
    }

    // Redirect kembali ke halaman sebelumnya
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else if ($_GET['aksi'] == "tambah-negatif") {
    $kata = $_POST['kata'];
    
    $query = "INSERT INTO sentiment_negatif (kata) VALUES ('$kata')";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['berhasil'] = 'Data berhasil disimpan!';
    } else {
        $_SESSION['gagal'] = 'Gagal menyimpan data: ' . mysqli_error($koneksi);
    }

    // Redirect kembali ke halaman sebelumnya
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}


?>
