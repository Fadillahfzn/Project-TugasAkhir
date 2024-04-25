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
                                            <h3 class="page-title m-0">Dashboard</h3>
                                        </div>
                                    </div>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->
                        </div>
                        <!-- end page-title-box -->
                    </div>
                </div>
                <!-- end page title -->

                <!-- row1 -->
                <div class="row">
                    <div class="col-xl-4 col-md-6 "> 
                            <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                <div class="card-header p-1 bg-light">
                                    <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                            Jumlah Data
                                    </h6>
                                </div>
                                <div class="p-4 mini-stat-desc text-center bg-info">
                                    <div class="clearfix">      
                                            <?php
                                            include "koneksi.php";
                                            $query = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM data_raw");
                                            $row = mysqli_fetch_assoc($query);
                                            $count = $row['total'];
                                            echo "<h2>$count</h2>"; // Tambahkan echo di sini
                                            ?>   
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 "> 
                            <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                <div class="card-header p-1 bg-light">
                                    <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                            Jumlah Data Preprocessing
                                    </h6>
                                </div>
                                <div class="p-4 mini-stat-desc text-center bg-info">
                                    <div class="clearfix">      
                                        <h2>0</h2>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 "> 
                            <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                <div class="card-header p-1 bg-light">
                                    <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                            Jumlah Data Label
                                    </h6>
                                </div>
                                <div class="p-4 mini-stat-desc text-center bg-info">
                                    <div class="clearfix">      
                                        <h2>0</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>

                <!-- row2 -->
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-4 col-md-6 "> 
                            <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                <div class="card-header p-1 bg-light">
                                    <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                            Jumlah Data Uji
                                    </h6>
                                </div>
                                <div class="p-4 mini-stat-desc text-center bg-info">
                                    <div class="clearfix">      
                                        <h2>0</h2>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 "> 
                            <div class="card mini-stat font-weight-bold shadow-md bg-body-tertiary">
                                <div class="card-header p-1 bg-light">
                                    <h6 class="card-title text-uppercase mt-0  text-center mt-2">
                                            Jumlah Data Latih
                                    </h6>
                                </div>
                                <div class="p-4 mini-stat-desc text-center bg-info">
                                    <div class="clearfix">      
                                        <h2>0</h2>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->


            <!-- end row -->
        </div>