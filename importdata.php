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

    <!-- DataTables -->
    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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

            <div class="sidebar-inner slimscrollleft ">
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
                                <i class="dripicons-home"></i> Import Data
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
                            <a href="labelling.php" class="waves-effect">
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
                            <a href="pengujian.php" class="waves-effect">
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
                            <a href="index.php" class="logo text-white" style="font-size: 20px;">Bismillah Project TA</a>
                        </div>
                    </div>

                    <nav class="navbar-custom">
                        <!-- Search input -->

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

                <!-- end page title -->
    
                <div class="row">
                    <div class="col-12">
                        <div class="import mt-3">
                            <div class="card shadow-sm bg-body-tertiary">
                                <div class="card-header">
                                    <h6 class="card-title">Import Data</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form">
                                        <p>Anda dapat melakukan import data dengan format :</p>
                                        <ul>
                                            <li>XLX</li>
                                            <li>XLXS</li>
                                        </ul>
                                        <form class="form-group" action="import_process.php" method="POST" enctype="multipart/form-data">
                                            <div class="col-4 mb-3">
                                                <input type="file" name="excel_file" id="excel_file" class="form-control-file filestyle" accept=".xls, .xlsx, .csv" data-buttonname="btn-secondary">
                                            </div>
                                            <div class="col-4 mb-3">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light btn-md">Submit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->


                    <!-- end row -->
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30 shadow-sm bg-body-tertiary">
                            <div class="card-header shadow-sm bg-body-tertiary">
                                <h6 class="card-title">Data Real</h6>
                            </div>
                            <div class="card-body">
                                <table id="datatable" class="table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Username</th>
                                            <th>Full Text</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                            include "koneksi.php";

                                            $no = 1;
                                            $query = mysqli_query($koneksi, "SELECT * FROM data_raw ORDER BY id DESC");
                                            while ($row = mysqli_fetch_assoc($query)) {
                                            ?>
                                                    <tr>
                                                        <!-- <td><?= $no++; ?></td> -->
                                                        <td><?= $row['username']; ?></td>
                                                        <td><?= $row['full_text']; ?></td>
                                                        <td><?= $row['created_at']; ?></td>
                                                    </tr>
                                            <?php
                                            }
                                            ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- end col -->
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

        <!-- Required datatable js -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <!--Morris Chart-->
        <script src="plugins/morris/morris.min.js"></script>
        <script src="plugins/raphael/raphael.min.js"></script>

        <!-- dashboard js -->
        <script src="assets/pages/dashboard.int.js"></script>

        <!-- Datatable init js -->
        <script src="assets/pages/datatables.init.js"></script>        

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>
</html>