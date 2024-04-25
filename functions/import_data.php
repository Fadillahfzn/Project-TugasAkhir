<?php

if($_GET['aksi'] == "hapus") {
    echo "berhasil";

    header("location: " . $_SERVER['HTTP_REFERER']);
}


?>