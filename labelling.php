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
                                            <h3 class="page-title m-0">Labelling</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row label">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4 row">
                                            <div class="col-6 p-2">
                                                <button class="btn btn-primary">Tampilkan Data</button>
                                            </div>
                                            <div class="col-6 p-2 text-right">
                                            <form action="functions/.php?aksi=hapus" method="POST" style="display: inline;">
                                                <button class="btn mr-2 btn-danger">Hapus Data</button>
                                            </form>
                                            </div>
                                        </div>
                                        <div class="">
                                            <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="">Username</th>
                                                        <th class="">Clean Text</th>
                                                        <th class="">Sentimen</th>
                                                        <!-- <th class="">Action</th> -->
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM label");
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                        <tr data-id="<?= $row['id']; ?>">                                                   
                                                        <td><?= $row['username']; ?></td>
                                                        <td><?= $row['full_text']; ?></td>
                                                        <td class="col-2">
                                                            <select class="form-control sentiment-dropdown" data-id="<?= $row['id']; ?>">
                                                                <option value="" selected>-- Pilih --</option>
                                                                <option value="positif" <?php echo ($row['sentiment'] == 'positif') ? 'selected' : ''; ?>>Positif</option>
                                                                <option value="negatif" <?php echo ($row['sentiment'] == 'negatif') ? 'selected' : ''; ?>>Negatif</option>
                                                                <option value="netral" <?php echo ($row['sentiment'] == 'netral') ? 'selected' : ''; ?>>Netral</option>
                                                            </select>
                                                        </td>
                                                        <!-- <td></td> -->
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
                        
                        <div class="row label-lexicon">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="mb-4 row">
                                            <div class="col-6 p-2">
                                                <button class="btn ml-2 btn-primary">Labelling Data Otomatis</button>
                                            </div>
                                            <div class="col-6 p-2 text-right">
                                            <form action="functions/labelling.php?aksi=hapus" method="POST" style="display: inline;">
                                            <button type="button" name="delete" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#myModal">Hapus Data</button>
                                            </form>
                                            </div>
                                        </div>
                                        <div class="">
                                            <table id="datatable" class="datatable table table-bordered dt-responsive" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th class="">Username</th>
                                                        <th class="">Clean Text</th>
                                                        <th class="">Sentimen</th>
                                                    </tr>
                                                </thead>
                                                
                                                <tbody>
                                                    <?php
                                                    include "koneksi.php";
                                                    $no = 1;
                                                    $query = mysqli_query($koneksi, "SELECT * FROM label_lexicon");
                                                    $query_positif = mysqli_query($koneksi, "SELECT * FROM label_lexicon WHERE sentiment = 'positif'");
                                                    $query_negatif = mysqli_query($koneksi, "SELECT * FROM label_lexicon WHERE sentiment = 'negatif'");
                                                    $query_netral = mysqli_query($koneksi, "SELECT * FROM label_lexicon WHERE sentiment = 'netral'");
                                                    $total_positif = mysqli_num_rows($query_positif);
                                                    $total_negatif = mysqli_num_rows($query_negatif);
                                                    $total_netral = mysqli_num_rows($query_netral);
                                                    while ($row = mysqli_fetch_assoc($query)) {
                                                    ?>
                                                    <tr data-id="<?= $row['id']; ?>">                                                   
                                                        <td><?= $row['username']; ?></td>
                                                        <td><?= $row['full_text']; ?></td>
                                                        <td><?= $row['sentiment']; ?></td>
                                                        <!-- <td class="col-2">
                                                            <select class="form-control sentiment-dropdown" data-id="<?= $row['id']; ?>">
                                                                <option value="" selected>-- Pilih --</option>
                                                                <option value="Positif" <?php echo ($row['sentiment'] == 'Positif') ? 'selected' : ''; ?>>Positif</option>
                                                                <option value="Negatif" <?php echo ($row['sentiment'] == 'Negatif') ? 'selected' : ''; ?>>Negatif</option>
                                                            </select>
                                                        </td> -->
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
                            <h5 class="mr-3">Positif : <?php echo $total_positif; ?></h5>
                            <h5 class="mr-3">Negatif : <?php echo $total_negatif; ?></h5>
                            <h5>Netral : <?php echo $total_netral; ?></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Script -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                    // Memilih semua dropdown sentiment
                    var sentimentDropdowns = document.querySelectorAll('.sentiment-dropdown');

                    // Menambahkan event listener untuk setiap dropdown
                    sentimentDropdowns.forEach(function (dropdown) {
                        dropdown.addEventListener('change', function () {
                            var id = dropdown.getAttribute('data-id');
                            var sentiment = dropdown.value;

                            // Kirim permintaan Ajax ke server untuk memperbarui data
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', 'update_sentiment.php', true);
                            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    console.log('Data updated successfully');
                                } else {
                                    console.log('Failed to update data');
                                }
                            };
                            xhr.send('id=' + id + '&sentiment=' + sentiment);
                        });
                    });
                });
        </script>

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
                            <form method="post" action="functions/labelling.php?aksi=hapus" style="display: inline;">
                                <button type="submit" class="btn btn-primary waves-effect waves-light">Save changes</button>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div>