<?php
include "config/koneksi.php";
if($_GET['aksi'] == "proses") {
     // Query untuk menghapus semua data dari tabel
    //  $query = "DELETE FROM raw_data";
    
    //  // Eksekusi query
    //  if (mysqli_query($koneksi, $query)) {
    //      echo "Semua data berhasil dihapus dari tabel.";
    //  } else {
    //      echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    //  }
     
    //  // Redirect kembali ke halaman sebelumnya
    //  header("location: " . $_SERVER['HTTP_REFERER']);
    echo "asd";
    $output = passthru("python ../python/preprocessing.py");
    header("location: " . $_SERVER['HTTP_REFERER']);
} 


?>