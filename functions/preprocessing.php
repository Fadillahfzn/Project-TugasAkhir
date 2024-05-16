<?php
// include "config/koneksi.php";
// if($_GET['aksi'] == "proses") {
//     echo "asd";
//     $output = passthru("source path/to/venv/bin/activate");
//     $a = passthru("python3 ../preprocessing.py");
//     header("location: " . $_SERVER['HTTP_REFERER']);
// }
// include "config/koneksi.php";
// if (isset($_GET['aksi']) && $_GET['aksi'] == "proses") {
//     ob_start();
//     $output = passthru("source path/to/venv/bin/python3 ../preprocessing.py 2>&1");
//     $output = ob_get_clean();
//     echo "Output: " . $output;
//     header("location: " . $_SERVER['HTTP_REFERER']);
// }  
include "../koneksi.php";

if($_GET['aksi'] == "hapus") {
    $query = "DELETE FROM proses";
    
     // Eksekusi query
     if (mysqli_query($koneksi, $query)) {
         echo "Semua data berhasil dihapus dari tabel.";
     } else {
         echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
     }

    header("location: " . $_SERVER['HTTP_REFERER']);
}
?>