<?php

include "../koneksi.php";

if($_POST['aksi'] == "tambah") {
    // Mendapatkan data dari form
    $kata = mysqli_real_escape_string($koneksi, $_POST['kata']);

    // Membuat query untuk menambahkan data
    $query = "INSERT INTO sentiment_positif VALUES ('$kata')";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        echo "Data berhasil ditambahkan ke tabel sentiment_positif.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }

    // Mengarahkan kembali ke halaman sebelumnya
    header("location: " . $_SERVER['HTTP_REFERER']);
}

?>
