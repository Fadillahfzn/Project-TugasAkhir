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
                                            <h3 class="page-title m-0">Preprocessing</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row mb-4">
                            <div class="col-12">
                            <form method="post" action="" style="display: inline;">
                                                    <!-- <button type="submit" name="delete" class="btn btn-danger" >Hapus Data</button> -->
                                                    <button type="submit" name="proses" class="btn btn-block btn-primary">Preprocessing</button>
                                                </form>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30 shadow-sm bg-body-tertiary">
                                    <div class="card-header shadow-sm bg-body-tertiary">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-title">Data Preprocessing</h6>
                                            <form action="functions/preprocessing.php?aksi=hapus" method="POST" style="display: inline;">
                                            <button type="button" name="delete" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Username</th>
                                                    <th>Full Text</th>
                                                    <th>Clean Text</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    include "koneksi.php";

                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM proses");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                            <tr>
                                                                <!-- <td><?= $no++; ?></td> -->
                                                                <td><?= $row['username']; ?></td>
                                                                <td><?= $row['full_text']; ?></td>
                                                                <td><?= $row['processed_text']; ?></td>
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
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="card m-b-30 shadow-sm bg-body-tertiary">
                                    <div class="card-header shadow-sm bg-body-tertiary">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="card-title">Data Clean</h6>
                                            <button class="btn btn-sm btn-danger">Hapus Data Clean</button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Clean Text</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                                    include "koneksi.php";

                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM proses");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                            <tr>
                                                                <?= $no++; ?>
                                                                <td><?= $no++; ?></td>
                                                                <td><?= $row['processed_text']; ?></td>
                                                            </tr>
                                                    <?php
                                                    }
                                                    ?>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->

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
                            <form method="post" action="functions/preprocessing.php?aksi=hapus" style="display: inline;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>

        <!-- end row -->
 