        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <div class="topbar">
                    <div class="topbar-left d-none d-lg-block">
                        <div class="text-center">
                            <a href="dashboard" class="logo text-white" style="font-size: 20px;">Bismillah Project TA</a>
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
                                        Sentimen Analisis Pelayanan Mudik
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
                                            <h3 class="page-title m-0">Pengujian Data</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row model">
                                            <div class="col-12">
                                                <h6 class="card-title">Pilih Model : </h6>
                                                    <select class="form-control select2" name="model" id="model" onchange="onchangeModel(this.value)">
                                                        <option hidden>-- Pilih Model --</option>
                                                            <?php
                                                            include "koneksi.php";
                                                                    
                                                            // Query untuk mengambil semua data dari tabel data_model
                                                            $query = mysqli_query($koneksi, "SELECT model_name, positive_label, negative_label FROM data_model");
                                                                    
                                                            while ($row = mysqli_fetch_assoc($query)) {
                                                            $totalLabels = $row['positive_label'] + $row['negative_label'];
                                                            ?>
                                                            <option value="<?= $totalLabels; ?>,<?= $row['positive_label']; ?>,<?= $row['negative_label']; ?>,<?= $row['model_name']; ?>">
                                                            <?= $row['model_name']; ?>
                                                            </option>
                                                            <?php
                                                            }
                                                            ?>
                                                    </select>
                                            </div>
                                        </div>
                                        <div class="row data mt-4">
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Jumlah Data Uji</h6>
                                                            <?php
                                                            include "koneksi.php";
                                                            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_testing");
                                                            $row = mysqli_fetch_assoc($query);
                                                            $count = $row['total'];
                                                            echo "<h2 class='text-white'>$count</h2>"; // Tambahkan echo di sini
                                                            ?>
                                                            <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Jumlah Data Latih</h6>
                                                            <h2 id="text_total">0</h2>
                                                            <!-- <h2 class='mb-4 text-white'>0</h2> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row sentiment mt-2">
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Sentiment Positive Data Latih</h6>
                                                            <h2 id="text_positif">0</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-sm-6">
                                                <div class="card mini-stat bg-primary">
                                                    <div class="card-body mini-stat-img">
                                                        <div class="text-white">
                                                            <h6 class="text-uppercase mb-3 font-size-16 text-white">Sentiment Negative Data Latih</h6>
                                                            <h2 id="text_negatif">0</h2>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <form method="post" action="functions/pengujian.php" style="display: inline;">
                                                            <!-- <button type="submit" name="delete" class="btn btn-danger" >Hapus Data</button> -->
                                            <button type="submit" name="proses" class="btn btn-lg btn-block btn-primary">Mulai Pengujian</button>
                                        </form>           
                                </div>                        
                            </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
                function onchangeModel(value) {
                    const myArray = value.split(",");
                    document.getElementById("text_total").innerHTML = myArray[0];
                    document.getElementById("text_positif").innerHTML = myArray[1];
                    document.getElementById("text_negatif").innerHTML = myArray[2];
                    document.getElementById("namaModel").value = myArray[3];
                    document.getElementById("jumlahSentimen").value = myArray[0];
                    document.getElementById("trainingPositif").value = myArray[1];
                    document.getElementById("trainingNegatif").value = myArray[2];
                    // document.getElementById("pengujianButton").disabled = false;
                }
            </script>