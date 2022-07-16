<!DOCTYPE html>
<html lang="en">
<?php

use App\Libraries\Settings;

$setting = new Settings();
$appname = $setting->info['app_name'];
$sitetitle = $setting->info['site_title'];
$brand = $setting->info['site_title'] . " v" . $setting->info['app_version'];
$instansi = $setting->info['nama_instansi'];
$alamat = $setting->info['alamat_instansi'];
?>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?= $title; ?> - <?= $sitetitle; ?></title>
    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/mdi/css/materialdesignicons.min.css">
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/template/css/style.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/datatables/css/dataTables.bootstrap5.min.css">
    <link rel="shortcut icon" href="<?= base_url(); ?>/template/images/favicon.png" />
    <style>
        .postList {
            -webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
            margin: 5px 15px 2px;
            padding: 2px;
            line-height: 1.5;
        }

        .show_more_main {
            margin: 15px 0;
        }

        .show_more {
            background-color: #f8f8f8;
            background-image: -webkit-linear-gradient(top, #fcfcfc 0, #f8f8f8 100%);
            background-image: linear-gradient(top, #fcfcfc 0, #f8f8f8 100%);
            border: 1px solid;
            border-color: #d3d3d3;
            color: #333;
            font-size: 14px;
            outline: 0;
        }

        .show_more {
            cursor: pointer;
            display: block;
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
        }

        .loding {
            background-color: #e9e9e9;
            border: 1px solid;
            border-color: #c6c6c6;
            color: #333;
            font-size: 14px;
            display: block;
            text-align: center;
            padding: 10px 0;
            outline: 0;
            font-weight: bold;
        }

        .loding_txt {
            background-image: url(loading.gif);
            background-position: left;
            background-repeat: no-repeat;
            border: 0;
            display: inline-block;
            height: 16px;
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="container-scroller d-flex">

        <!-- Sidebar -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                <li class="nav-item sidebar-category">
                    <p>Navigation</p>
                    <span></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/dashboard">
                        <i class="menu-icon mdi mdi-home mdi-24px"></i>
                        <span class="menu-title">Dashboard</span>
                    </a>
                </li>
                <?php if (allow('admin')) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/transaksi">
                            <i class="menu-icon mdi mdi-swap-horizontal-bold mdi-24px"></i>
                            <span class="menu-title">Data Sedekah</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/datasedekah">
                            <i class="menu-icon mdi mdi-delete-variant mdi-24px"></i>
                            <span class="menu-title">Realisasi Sedekah</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/akun">
                            <i class="menu-icon mdi mdi-account-multiple mdi-24px"></i>
                            <span class="menu-title">Akun</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/faq">
                            <i class="menu-icon mdi mdi-comment-question mdi-24px"></i>
                            <span class="menu-title">FAQ</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/setting">
                            <i class="menu-icon mdi mdi-settings mdi-24px"></i>
                            <span class="menu-title">Pengaturan</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>/backup">
                            <i class="menu-icon mdi mdi-database mdi-24px"></i>
                            <span class="menu-title">Backup DB</span></a>
                    </li>
                <?php endif; ?>

                <li class="nav-item sidebar-category">
                    <p>Sedekah</p>
                    <span></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/transaksi/setor/<?= session()->get('id') ?>">
                        <i class="menu-icon mdi mdi-heart mdi-24px"></i>
                        <span class="menu-title">Sedekah</span></a>
                </li>

                <li class="nav-item sidebar-category">
                    <p>User Profile</p>
                    <span></span>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/user">
                        <i class="menu-icon mdi mdi-account-details mdi-24px"></i>
                        <span class="menu-title">Profil saya</span></a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url() ?>/logout">
                        <i class="menu-icon mdi mdi-logout mdi-24px"></i>
                        <span class="menu-title">Logout</span></a>
                </li>
            </ul>
        </nav>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div class="container-fluid page-body-wrapper">

            <!-- Topbar -->
            <nav class="navbar navbar-light bg-light shadow-sm col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button class="navbar-toggler navbar-toggler-icon align-self-center" type="button" data-toggle="minimize"></button>

                    <div class="navbar-brand-wrapper">
                        <a class="navbar-brand brand-logo" href=""><?= $appname ?></a>
                        <a class="navbar-brand brand-logo-mini" href=""><?= $appname ?></a>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav navbar-nav-right">
                        <!-- Nav Item - User Information -->
                        <li class="nav-item nav-profile dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">

                                <?php if (session()->get('foto') != 'profile.png') { ?>
                                    <img src="<?= base_url() ?>/<?= session()->get('foto'); ?>" width="35" alt="profil <?= session()->get('username'); ?>" />
                                <?php } else { ?>
                                    <img src="<?= base_url('/images/photos/profile.png') ?>" width="35" alt="Foto profil <?= session()->get('username'); ?>">
                                <?php } ?>
                                <span class="ms-2 nav-profile-name"><?= session()->get('username'); ?></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                                <a class="dropdown-item" href="<?= base_url() ?>/user">
                                    <i class="mdi mdi-settings text-primary"></i>
                                    Profil Saya
                                </a>
                                <a class="dropdown-item" href="<?= base_url() ?>/logout" data-bs-toggle="modal" data-bs-target="#logoutModal">
                                    <i class="mdi mdi-logout text-primary"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-icon navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas"></button>
                </div>
            </nav>
            <!-- End of Topbar -->

            <!-- Main Content -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <!-- Begin Page Content -->
                    <?= $this->renderSection('content'); ?>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <!-- Footer -->
                <footer class="footer">
                    <div class="container my-auto">
                        <div class="my-auto text-center copyright">
                            <span>Copyright &copy; <?= date('Y'); ?> Sedekah Receh Official </span>
                        </div>
                    </div>
                </footer>
                <!-- End of Footer -->
            </div>
        </div>
        <!-- End of Content Wrapper -->

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">Pilih "Logout" di bawah jika Anda siap untuk mengakhiri sesi Anda saat ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                        <a class="btn btn-primary" href="<?= base_url('/logout'); ?>">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->renderSection('modal'); ?>

    <!-- Core JavaScript-->
    <!-- <script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script> -->
    <script src="<?= base_url(); ?>/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= base_url(); ?>/js/jquery-nested-form.js"></script>
    <script src="<?= base_url(); ?>/template/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="<?= base_url(); ?>/template/js/off-canvas.js"></script>
    <script src="<?= base_url(); ?>/template/js/hoverable-collapse.js"></script>
    <script src="<?= base_url(); ?>/template/js/template.js"></script>
    <script src="<?= base_url(); ?>/template/vendors/chart.js/Chart.min.js"></script>
    <script src="<?= base_url(); ?>/template/vendors/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url(); ?>/template/vendors/datatables/js/dataTables.bootstrap5.min.js"></script>
    <script src="<?= base_url(); ?>/template/vendors/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>

    <script>
        function previewImg(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImg').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
        $('#foto').change(function() {
            previewImg(this)
        })
    </script>
    <?= $this->renderSection('script'); ?>

</body>

</html>