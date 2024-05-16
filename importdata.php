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
                                                <!-- <input type="file" name="excel_file" id=""> -->
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
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-title">Data Real</h6>
                                            <form action="functions/import_data.php?aksi=hapus" method="POST" style="display: inline;">
                                                <button class="btn btn-sm btn-danger">Hapus Data</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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