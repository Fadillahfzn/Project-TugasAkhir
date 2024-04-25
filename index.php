<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>TA Bismillah</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="ThemeDesign" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <link rel="shortcut icon" href="assets/images/favicon.ico">
    <link rel="shortcut icon" href="assets/icons/font-awesome">

    

    <!-- morris css -->
    <link rel="stylesheet" href="../plugins/morris/morris.css">

    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/icons.css" rel="stylesheet" type="text/css">
    <link href="assets/css/style.css" rel="stylesheet" type="text/css">

</head>


<body class="fixed-left">

    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner">
                <div class="rect1"></div>
                <div class="rect2"></div>
                <div class="rect3"></div>
                <div class="rect4"></div>
                <div class="rect5"></div>
            </div>
        </div>
    </div>

    <!-- Begin page -->
    <div id="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="left side-menu">
            <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
          <i class="mdi mdi-close"></i>
        </button>

            <div class="left-side-logo d-block d-lg-none">
                <div class="text-center">
                    <a href="index.php" class=""><img src="" height="" alt="" /></a>
                </div>
            </div>

            <div class="sidebar-inner slimscrollleft">
                <div id="sidebar-menu">
                    <ul>
                        <li class="menu-title"></li>

                        <li>
                            <a href="index.php" class="waves-effect">
                                <i class="dripicons-home"></i> Dashboard
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="importdata.php" class="waves-effect">
                                <i class="fab fa-wpforms"></i> Import Data
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="preprocessing.php" class="waves-effect">
                                <i class="dripicons-home"></i> Preprocessing
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="labeling.php" class="waves-effect">
                                <i class="dripicons-home"></i> Labeling
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="splitdata.php" class="waves-effect">
                                <i class="dripicons-home"></i> Split Data
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="modelling.php" class="waves-effect">
                                <i class="dripicons-home"></i> Modelling
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="pengujian.htphpml" class="waves-effect">
                                <i class="dripicons-home"></i> Pengujian
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="visualisasidata.php" class="waves-effect">
                                <i class="dripicons-home"></i> Visualisasi Data
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- end sidebarinner -->
        </div>
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">
                <!-- Top Bar Start -->
                <div class="topbar">
                    <div class="topbar-left d-none d-lg-block">
                        <div class="text-center">
                            <a href="index.html" class="logo text-white" style="font-size: 20px;">Bismillah Project TA</a>
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
        <!-- container fluid -->
    </div>
    <!-- Page content Wrapper -->
    </div>
    <!-- content -->

    <footer class="footer">
        © Ojansky
        <span class="d-none d-md-inline-block">
            - Project Tugas Akhir</span
          >
        </footer>
      </div>
      <!-- End Right content here -->
    </div>
    <!-- END wrapper -->


        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <!--Morris Chart-->
        <script src="../plugins/morris/morris.min.js"></script>
        <script src="../plugins/raphael/raphael.min.js"></script>

        <!-- dashboard js -->
        <script src="assets/pages/dashboard.int.js"></script>        

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>
</html>