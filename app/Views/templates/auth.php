<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $brand ?>">
    <meta name="author" content="Sedekah Receh Official">

    <title><?= $sitetitle; ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url(); ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/mdi/css/materialdesignicons.min.css">
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="<?= base_url(); ?>/template/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= base_url(); ?>/template/css/style.css">
    <link rel="shortcut icon" href="<?= base_url(); ?>/template/images/favicon.png" />

</head>

<body>
    <div class="container-scroller d-flex">
        <div class="container-fluid page-body-wrapper full-page-wrapper d-flex">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">

                <?= $this->renderSection('content'); ?>

            </div>
        </div>
    </div>

    <!-- Core JavaScript-->
    <script src="<?= base_url(); ?>/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url(); ?>/template/vendors/js/vendor.bundle.base.js"></script>
    <script src="<?= base_url(); ?>/template/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="<?= base_url(); ?>/template/js/off-canvas.js"></script>
    <script src="<?= base_url(); ?>/template/js/hoverable-collapse.js"></script>
    <script src="<?= base_url(); ?>/template/js/template.js"></script>

    <script>
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>

    <?= $this->renderSection('script'); ?>
</body>

</html>