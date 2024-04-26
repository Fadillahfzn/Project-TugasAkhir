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

    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />

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

            <div class="sidebar-inner slimscrollleft">
                <div id="sidebar-menu">
                    <ul>
                        <li class="menu-title"></li>

                        <li>
                            <a href="dashboard" class="waves-effect">
                                <i class="dripicons-home"></i> Dashboard
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="importdata" class="waves-effect">
                                <i class="fab fa-wpforms"></i> Import Data
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="preprocessing" class="waves-effect">
                                <i class="dripicons-home"></i> Preprocessing
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="labelling" class="waves-effect">
                                <i class="dripicons-home"></i> Labeling
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="splitdata" class="waves-effect">
                                <i class="dripicons-home"></i> Split Data
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="modelling" class="waves-effect">
                                <i class="dripicons-home"></i> Modelling
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="pengujian" class="waves-effect">
                                <i class="dripicons-home"></i> Pengujian
                                <span class="badge badge-success badge-pill float-right"></span>
                            </a>
                        </li>
                        <li>
                            <a href="visualisasidata" class="waves-effect">
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

        <?php include "content.php" ?>
        
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

        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <!--Morris Chart-->
        <script src="plugins/morris/morris.min.js"></script>
        <script src="plugins/raphael/raphael.min.js"></script>

        <script src="plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="plugins/datatables/responsive.bootstrap4.min.js"></script>

        <!-- <script src="assets/pages/datatables.init.js"></script> -->
        <script>
            $(document).ready(function() {
                $('.datatable').DataTable({
                    "lengthMenu": [ [3, 10, 25, 50, -1], [3, 10, 25, 50, "All"] ], // Menentukan opsi jumlah entri
                    "pageLength": 3 // Mengatur jumlah entri default menjadi 5
                });
            })
        </script>

        <!-- dashboard js -->
        <script src="assets/pages/dashboard.int.js"></script>        

        <!-- App js -->
        <script src="assets/js/app.js"></script>

    </body>
</html>