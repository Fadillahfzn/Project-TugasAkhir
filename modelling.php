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
                                            <h3 class="page-title m-0">Modelling</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-4">
                            <div class="col-12">
                                <form method="post" action="functions/modelling.php" style="display: inline;">
                                                    <!-- <button type="submit" name="delete" class="btn btn-danger" >Hapus Data</button> -->
                                    <button type="submit" name="proses" class="btn btn-block btn-primary">Mulai Modelling</button>
                                </form>
                            </div>
                    </div>
                </div>

                <div class="row label-lexicon">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="">
                                            <table id="datatable" class="ddatatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="">No</th>
                                                        <th class="">Model Name</th>
                                                        <th class="">Positive Labels</th>
                                                        <th class="">Negative Labels</th>
                                                        <th class="">Netral Labels</th>
                                                        <th class="">Total Sentiment</th>
                                                        <th class="">Created At</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                        $query = mysqli_query($koneksi, "SELECT * FROM data_model");
                                                        $totalPositive = 0;
                                                        $totalNegative = 0;
                                                        $totalNetral = 0;
                                                        while ($row = mysqli_fetch_assoc($query)) {
                                                            $totalPositive += $row['positive_label'];
                                                            $totalNegative += $row['negative_label'];
                                                            $totalNegative += $row['netral_label'];
                                                    ?>
                                                    <tr>
                                                        <td><?= $no++; ?></td>                                                   
                                                        <td><?= $row['model_name']; ?></td>
                                                        <td><?= $row['positive_label']; ?></td>
                                                        <td><?= $row['negative_label']; ?></td>
                                                        <td><?= $row['netral_label']; ?></td>
                                                        <td><?= $row['positive_label'] + $row['negative_label'] + $row['netral_label']; ?></td>
                                                        <td><?= $row['created_at'];?></td>
                                                        
                                                    </tr>
                                                    <?php   
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
