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
                                            <h3 class="page-title m-0">Split Data</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row button-split">
                                            <div class="col-6">
                                                <form action="functions/split_data.php" method="post">
                                                    <button class="btn btn-success btn-block">Split Data</button>
                                                </form>    
                                            </div>
                                            <div class="col-6">
                                                <form action="functions/split_data.php?aksi=hapus" method="post">
                                                <button type="button" name="delete" class="btn btn-block btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                                </form>    
                                            </div>
                                        </div>
                                        <div class="row mt-4 info-split">
                                            <div class="col-6">
                                                <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                                    <div class="card-header p-1 bg-light">
                                                        <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                                                Jumlah Data Training
                                                        </h6>
                                                    </div>
                                                    <div class="p-4 mini-stat-desc text-center bg-primary">
                                                        <div class="clearfix">      
                                                                <?php
                                                                include "koneksi.php";
                                                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_training");
                                                                $row = mysqli_fetch_assoc($query);
                                                                $count = $row['total']; // Tambahkan echo di sini
                                                                $no = 1;
                                                                // $query = mysqli_query($koneksi, "SELECT * FROM data_training");
                                                                $query_positif = mysqli_query($koneksi, "SELECT * FROM data_training WHERE sentiment = 'positif'");
                                                                $query_negatif = mysqli_query($koneksi, "SELECT * FROM data_training WHERE sentiment = 'negatif'");
                                                                $query_netral = mysqli_query($koneksi, "SELECT * FROM data_training WHERE sentiment = 'netral'");
                                                                $total_positif = mysqli_num_rows($query_positif);
                                                                $total_negatif = mysqli_num_rows($query_negatif);
                                                                $total_netral = mysqli_num_rows($query_netral);
                                                                echo "<h2>$count</h2>";
                                                                // echo "<h2>$total_positif</h2>";
                                                                // echo "<h2>$total_negatif</h2>";
                                                                // echo "<h2>$total_netral</h2>";
                                                                ?>   
                                                        </div>
                                                    </div>
                                                </div>
                                                <h6 class="mr-3">Positif : <?php echo $total_positif; ?></h6>
                                                <h6 class="mr-3">Negatif : <?php echo $total_negatif; ?></h6>
                                                <h6>Netral : <?php echo $total_netral; ?></h6>
                                            </div>
                                            <div class="col-6">
                                                <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                                    <div class="card-header p-1 bg-light">
                                                        <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                                                Jumlah Data Testing
                                                        </h6>
                                                    </div>
                                                    <div class="p-4 mini-stat-desc text-center bg-primary">
                                                        <div class="clearfix">      
                                                                <?php
                                                                include "koneksi.php";
                                                                $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_testing");
                                                                $row = mysqli_fetch_assoc($query);
                                                                $count = $row['total'];
                                                                echo "<h2>$count</h2>"; // Tambahkan echo di sini
                                                                ?>   
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
        </div>

        <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title mt-0" id="myModalLabel">Modal Heading</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <h6>Apakah anda yakin ingin menghapus data ini?</h6>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Close</button>
                            <form method="post" action="functions/split_data.php?aksi=hapus" style="display: inline;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>
