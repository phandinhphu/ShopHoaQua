<?php
    if (isset($_GET['layout'])) {
        $layout = $_GET['layout'];
    } else {
        $layout = 'dashboard';
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <link rel="icon" type="image/png" sizes="16x16" href="assets/plugins/images/favicon.png">
    <!-- Custom CSS -->
    <link href="assets/plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="assets/css/style.min.css" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
</head>

<body>
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <?php 
            include 'layout/header.php';
        ?>

        <?php 
            include 'layout/menu.php';
        ?>
        <div class="page-wrapper">
            <div class="page-breadcrumb bg-white">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?php
                            if ($layout == 'dashboard') {
                                include 'dashboard.php';
                            } else if ($layout == 'category') {
                                include 'category/category.php';
                            } else if ($layout == 'product') {
                                include 'product/product.php';
                            } else if ($layout == 'addcategory') {
                                include 'category/add.php';
                            } else if ($layout == 'addproduct') {
                                include 'product/add.php';
                            } else if ($layout == 'user') {
                                include 'user/user.php';
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app-style-switcher.js"></script>
    <script src="assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    <!--Wave Effects -->
    <script src="assets/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="assets/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="assets/js/custom.js"></script>
    <!--This page JavaScript -->
    <!--chartis chart-->
    <script src="assets/plugins/bower_components/chartist/dist/chartist.min.js"></script>
    <script src="assets/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="assets/js/pages/dashboards/dashboard1.js"></script>
</body>

</html>