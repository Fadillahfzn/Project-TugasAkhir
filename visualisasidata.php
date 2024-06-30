<?php
// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "taproject";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk mengambil data riwayat dari database
function getRiwayat($conn) {
    $query = mysqli_query($conn, "SELECT * FROM riwayat LIMIT 1");
    return mysqli_fetch_all($query, MYSQLI_ASSOC);
}

// Fungsi untuk memisahkan vocabulary dan weights
function processVocabularyAndWeight($riwayat) {
    $vocabulary = explode(", ", $riwayat['vocabulary']);
    $weight = explode(", ", $riwayat['vocab_weight']);
    $wordCloud = [];
    foreach ($vocabulary as $key => $value) {
        $wordCloud[] = ["'$value'", $weight[$key]];
    }
    return $wordCloud;
}

// Inisialisasi data
$riwayats = getRiwayat($koneksi);
$dataChart = [];
$wordCloud = [];

foreach ($riwayats as $riwayat) {
    $dataChart[] = ["Positive", $riwayat['predict_positive']];
    $dataChart[] = ["Negative", $riwayat['predict_negative']];
    $wordCloud = processVocabularyAndWeight($riwayat);
}

// Menyiapkan data untuk ditampilkan
$data = [
    'riwayats' => $riwayats,
    'dataChart' => $dataChart,
    'wordCloud' => $wordCloud
];
?>    

<!-- chartjs js -->
<script src="plugins/chartjs/chart.min.js"></script>
<!-- <script src="assets/pages/chartjs.init.js"></script> -->
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
    
    <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <div class="topbar">
                    <div class="topbar-left d-none d-lg-block">
                        <div class="text-center">
                            <a href="dashboard" class="logo text-white" style="font-size: 20px;">Project Tugas Akhir</a>
                        </div>
                    </div>

                    <nav class="navbar-custom">
                        <!-- Search input -->
                        <div class="search-wrap" id="search-wrap">
                            <div class="search-bar">
                                <input class="search-input" type="search" placeholder="Search" />
                                <a href="#" class="close-search toggle-search" data-target="#search-wrap">
                                    <i class="mdi mdi-close-circle"></i>
                                </a>
                            </div>
                        </div>

                        <ul class="list-inline float-right mb-0">

                            <li class="list-inline-item dropdown notification-list nav-user">
                                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="d-none d-md-inline-block ml-1" style="font-size: 15px;">
                                    Analisis Sentimen - Text Mining
                                    </span>
                                </a>

                            </li>
                        </ul>

                        <ul class="list-inline menu-left mb-0">
                            <li class="list-inline-item">
                                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="mdi mdi-menu"></i>
                  </button>
                            </li>
                            <li class="list-inline-item dropdown notification-list d-none d-sm-inline-block">
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Top Bar End -->

                <div class="page-content-wrapper">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <h3 class="page-title m-0">Visualisasi Data Hasil</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <!-- <h4>asd</h4> -->
                                                <?php foreach ($data['riwayats'] as $riwayat): ?>
                                                <div class="mb-4">
                                                    Tanggal : <b><?= date('d-m-Y H:i:s', strtotime($riwayat['created_at'])) ?></b><br>
                                                </div>
                                                <div class="mb-4 table-container">
                                                    <table border="1" style="width: 100%; border-collapse: collapse;">
                                                        <tr align="center">
                                                            <td colspan="2" rowspan="2">
                                                                Data Training = <b><?= $riwayat['data_training'] ?></b><br>
                                                                Data Testing = <b><?= $riwayat['data_testing'] ?></b>
                                                            </td>
                                                            <td colspan="3">Kelas Aktual</td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td>Positive</td>
                                                            <td>Netral</td>
                                                            <td>Negative</td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td rowspan="3">Kelas Prediksi</td>
                                                            <td>Positive</td>
                                                            <td><b>TP = <?= $riwayat['true_positive'] ?></b></td>
                                                            <td><b>NtP = <?= $riwayat['positive_netral'] ?></b></td>
                                                            <td><b>FP = <?= $riwayat['false_positive'] ?></b></td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td>Netral</td>
                                                            <td><b>PNt = <?= $riwayat['netral_positive'] ?></b></td>
                                                            <td><b>TNt = <?= $riwayat['true_netral'] ?></b></td>
                                                            <td><b>NNt = <?= $riwayat['netral_negative'] ?></b></td>
                                                        </tr>
                                                        <tr align="center">
                                                            <td>Negative</td>
                                                            <td><b>FN = <?= $riwayat['false_negative'] ?></b></td>
                                                            <td><b>NtN = <?= $riwayat['negative_netral'] ?></b></td>
                                                            <td><b>TN = <?= $riwayat['true_negative'] ?></b></td>
                                                        </tr>
                                                    </table>
                                                </div>

                                                <div class="mb-4 formula">
                                                            <!-- Perhitungan Accuracy -->
                                                            <p>
                                                                <?php
                                                                $accuracy = ($riwayat['true_positive'] + $riwayat['true_negative'] + $riwayat['true_netral']) / 
                                                                            ($riwayat['true_positive'] + $riwayat['true_negative'] + $riwayat['true_netral'] + 
                                                                            $riwayat['false_positive'] + $riwayat['false_negative'] + 
                                                                            $riwayat['positive_netral'] + $riwayat['netral_positive'] + $riwayat['netral_negative'] + $riwayat['negative_netral']);
                                                                ?>
                                                                Accuracy = \( \frac{TP + TN + TNt}{TP + TN + TNt + FP + FN + PNt + NtP + NtN} \)
                                                                = \( \frac{<?= $riwayat['true_positive'] ?> + <?= $riwayat['true_negative'] ?> + <?= $riwayat['true_netral'] ?>}
                                                                {<?= $riwayat['true_positive'] ?> + <?= $riwayat['true_negative'] ?> + <?= $riwayat['true_netral'] ?> + 
                                                                <?= $riwayat['false_positive'] ?> + <?= $riwayat['false_negative'] ?> + 
                                                                <?= $riwayat['positive_netral'] ?> + <?= $riwayat['netral_positive'] ?> + <?= $riwayat['netral_negative'] ?> + <?= $riwayat['negative_netral'] ?>} \) = <?= number_format($accuracy, 2) ?>
                                                            </p>

                                                            <!-- Perhitungan Precision -->
                                                            <p>
                                                                <?php
                                                                $precision_positive = $riwayat['true_positive'] / 
                                                                                    ($riwayat['true_positive'] + $riwayat['false_positive'] + $riwayat['netral_positive']);
                                                                $precision_neutral = $riwayat['true_netral'] / 
                                                                                    ($riwayat['true_netral'] + $riwayat['positive_netral'] + $riwayat['negative_netral']);
                                                                $precision_negative = $riwayat['true_negative'] / 
                                                                                    ($riwayat['true_negative'] + $riwayat['false_negative'] + $riwayat['netral_negative']);
                                                                $precision = ($precision_positive + $precision_neutral + $precision_negative) / 3;
                                                                ?>
                                                                Precision = \( \frac{Precision_{positive} + Precision_{neutral} + Precision_{negative}}{3} \) = \( \frac{<?= number_format($precision_positive, 4) ?> + <?= number_format($precision_neutral, 4) ?> + <?= number_format($precision_negative, 4) ?>}{3} \) = <?= number_format($precision, 2) ?>
                                                            </p>

                                                            <!-- Perhitungan Recall -->
                                                            <p>
                                                                <?php
                                                                $recall_positive = $riwayat['true_positive'] / 
                                                                                ($riwayat['true_positive'] + $riwayat['false_negative'] + $riwayat['positive_netral']);
                                                                $recall_neutral = $riwayat['true_netral'] / 
                                                                                ($riwayat['true_netral'] + $riwayat['netral_positive'] + $riwayat['netral_negative']);
                                                                $recall_negative = $riwayat['true_negative'] / 
                                                                                ($riwayat['true_negative'] + $riwayat['false_positive'] + $riwayat['negative_netral']);
                                                                $recall = ($recall_positive + $recall_neutral + $recall_negative) / 3;
                                                                $recall_percent = $recall * 100;
                                                                ?>
                                                                Recall = \( \frac{Recall_{positive} + Recall_{neutral} + Recall_{negative}}{3} \) = \( \frac{<?= number_format($recall_positive, 4) ?> + <?= number_format($recall_neutral, 4) ?> + <?= number_format($recall_negative, 4) ?>}{3} \) = <?= number_format($recall, 2) ?>
                                                            </p>

                                                            <!-- Perhitungan F1 Score -->
                                                            <p>
                                                                <?php
                                                                $f1_score_positive = 2 * ($precision_positive * $recall_positive) / ($precision_positive + $recall_positive);
                                                                $f1_score_neutral = 2 * ($precision_neutral * $recall_neutral) / ($precision_neutral + $recall_neutral);
                                                                $f1_score_negative = 2 * ($precision_negative * $recall_negative) / ($precision_negative + $recall_negative);
                                                                $f1_score = ($f1_score_positive + $f1_score_neutral + $f1_score_negative) / 3;
                                                                ?>
                                                                F1-Score = \( \frac{F1_{\text{positive}} + F1_{\text{neutral}} + F1_{\text{negative}}}{3} \) = \( \frac{<?= number_format($f1_score_positive, 4) ?> + <?= number_format($f1_score_neutral, 4) ?> + <?= number_format($f1_score_negative, 4) ?>}{3} \) = <?= number_format($f1_score, 2) ?>
                                                            </p>
                                                </div>
                                                <div class="mb-4">
                                                    Keterangan :
                                                    <ul>
                                                        <li><b>TP = True Positive</b> <br> Dokumen yang secara aktual positif dan diidentifikasi dengan benar sebagai positif oleh model.</li>
                                                        <li><b>FN = False Negative</b> <br> Dokumen yang secara aktual positif tetapi diidentifikasi sebagai negatif oleh model.</li>
                                                        <li><b>PNt = Positive Neutral</b> <br> Dokumen yang secara aktual positif tetapi diidentifikasi sebagai netral oleh model.</li>
                                                        <li><b>TN = True Negative</b> <br> Dokumen yang secara aktual positif dan diidentifikasi dengan benar sebagai negatif oleh model.</li>
                                                        <li><b>FP = False Positive</b> <br> Dokumen yang secara aktual negatif tetapi diidentifikasi sebagai positif oleh model.</li>
                                                        <li><b>FNt = False Neutral</b> <br> Dokumen yang secara aktual negatif tetapi diidentifikasi sebagai netral oleh model.</li>
                                                        <li><b>NtP = Neutral Positive</b> <br> Dokumen yang secara aktual netral tetapi diidentifikasi sebagai positif oleh model.</li>
                                                        <li><b>NtN = Neutral Negative</b> <br> Dokumen yang secara aktual netral tetapi diidentifikasi sebagai negatif oleh model</li>
                                                        <li><b>TNt = True Netral</b> <br> Dokumen yang secara aktual netral dan diidentifikasi dengan benar sebagai netral oleh model.</li>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
                                            </div>
                                            <div class="col-6">
                                                <div class="row">
                                                    <div class="col-xl-4 col-sm-4">
                                                        <div class="card mini-stat bg-primary">
                                                            <div class="card-body mini-stat-img">
                                                                <!-- <div class="mini-stat-icon">
                                                                    <i class="mdi mdi-cube-outline float-end"></i>
                                                                </div> -->
                                                                <div class="text-white">
                                                                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Total Prediksi Positif</h6>
                                                                    <?php
                                                                    include "koneksi.php";
                                                                    // Menjalankan query untuk mengambil semua nilai dari kolom `predict_positive` di tabel `riwayat`
                                                                    $query = mysqli_query($koneksi, "SELECT predict_positive FROM riwayat");

                                                                    // Memastikan query berhasil
                                                                    if ($query) {
                                                                        $values = [];
                                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                                            $values[] = $row['predict_positive'];
                                                                        }

                                                                        // Jika Anda ingin menampilkan semua nilai dalam satu elemen HTML
                                                                        $valuesString = implode(", ", $values);
                                                                        echo "<h2 class='mb-4 text-white'>$valuesString</h2>";
                                                                    } // Tambahkan echo di sini
                                                                    ?>
                                                                    <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-sm-4">
                                                        <div class="card mini-stat bg-primary">
                                                            <div class="card-body mini-stat-img">
                                                                <!-- <div class="mini-stat-icon">
                                                                    <i class="mdi mdi-cube-outline float-end"></i>
                                                                </div> -->
                                                                <div class="text-white">
                                                                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Total Prediksi Negatif</h6>
                                                                    <?php
                                                                    include "koneksi.php";
                                                                    // Menjalankan query untuk mengambil semua nilai dari kolom `predict_positive` di tabel `riwayat`
                                                                    $query = mysqli_query($koneksi, "SELECT predict_negative FROM riwayat");

                                                                    // Memastikan query berhasil
                                                                    if ($query) {
                                                                        $values = [];
                                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                                            $values[] = $row['predict_negative'];
                                                                        }

                                                                        // Jika Anda ingin menampilkan semua nilai dalam satu elemen HTML
                                                                        $valuesString = implode(", ", $values);
                                                                        echo "<h2 class='mb-4 text-white'>$valuesString</h2>";
                                                                    } // Tambahkan echo di sini
                                                                    ?>
                                                                    <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-4 col-sm-4">
                                                        <div class="card mini-stat bg-primary">
                                                            <div class="card-body mini-stat-img">
                                                                <!-- <div class="mini-stat-icon">
                                                                    <i class="mdi mdi-cube-outline float-end"></i>
                                                                </div> -->
                                                                <div class="text-white">
                                                                    <h6 class="text-uppercase mb-3 font-size-16 text-white">Total Prediksi Netral</h6>
                                                                    <?php
                                                                    include "koneksi.php";
                                                                    // Menjalankan query untuk mengambil semua nilai dari kolom `predict_positive` di tabel `riwayat`
                                                                    $query = mysqli_query($koneksi, "SELECT predict_netral FROM riwayat");

                                                                    // Memastikan query berhasil
                                                                    if ($query) {
                                                                        $values = [];
                                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                                            $values[] = $row['predict_netral'];
                                                                        }

                                                                        // Jika Anda ingin menampilkan semua nilai dalam satu elemen HTML
                                                                        $valuesString = implode(", ", $values);
                                                                        echo "<h2 class='mb-4 text-white'>$valuesString</h2>";
                                                                    } // Tambahkan echo di sini
                                                                    ?>
                                                                    <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <h4 class="card-title mb-4">Chart</h4>
                                                        
                                                        <canvas id="bar" height="200"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="plugins/chartjs/chart.min.js"></script>

        <script>
                // Mengambil data dari backend
                fetch('functions/getChartData.php')
                    .then(response => response.json())
                    .then(data => {
                        // Menyiapkan data untuk chart
                        const labels = data.map(item => item.created_at);
                        const positiveData = data.map(item => item.predict_positive);
                        const negativeData = data.map(item => item.predict_negative);
                        const netralData = data.map(item => item.predict_netral);

                        // Membuat bar chart
                        const ctx = document.getElementById('bar').getContext('2d');
                        const barChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: labels,
                                datasets: [
                                    {
                                        label: 'Positive Predictions',
                                        data: positiveData,
                                        backgroundColor: '#36508b',
                                        borderColor: '#36508b',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Negative Predictions',
                                        data: negativeData,
                                        backgroundColor: '#fb2212',
                                        borderColor: '#fb2212',
                                        borderWidth: 1
                                    },
                                    {
                                        label: 'Netral Predictions',
                                        data: netralData,
                                        backgroundColor: '#AFAFAF',
                                        borderColor: '#AFAFAF',
                                        borderWidth: 1
                                    }
                                ]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true
                                    }
                                }
                            }
                        });
                    });
            </script>