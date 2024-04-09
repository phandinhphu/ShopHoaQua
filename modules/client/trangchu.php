<?php
session_start();
if (empty($_SESSION['username'])) {
    header('Location: ?module=client&action=login');
    die();
}

if (isset($_GET['id'])) {
    $class = 'category__item-link--active';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/main.css">
    <link rel="stylesheet" href="./modules/client/assets/css/responsive.css">
</head>

<body>
    <?php
    include_once('./modules/layout/header.php');
    ?>

    <div class="slide">
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-3 col-0 col-sm-0">
                <div class="category hide-on-mobile">
                    <div class="category__heading">
                        <i class="category__heading-icon fa fa-list"></i>
                        <h3>Danh mục</h3>
                    </div>
                    <ul class="category__list">
                        <?php if (isset($class)) {
                            $_class = $class;
                        } ?>
                        <li class="category__item"><a class="category__item-link <?= !isset($_GET['id']) ? 'category__item-link--active' : '' ?>" href="?modules=client&action=trangchu">Tất cả sản phẩm</a></li>
                        <?php
                        $categories = getRows('SELECT * FROM category');
                        foreach ($categories as $category) {
                        ?>
                            <li class="category__item"><a class="category__item-link <?=
                                                                                        isset($_GET['id']) && $_GET['id'] == $category['id'] ? 'category__item-link--active' : ''
                                                                                        ?>" href="?modules=client&action=trangchu&id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <div class="col-md-9 col-12 col-sm-12">
                <div class="content">
                    <h3>Sản phẩm</h3>
                    <div id="product" class="row">
                        <?php
                        if (isset($_GET['page'])) {
                            $page = $_GET['page'];
                        } else {
                            $page = 1;
                        }
                        $limit = 12;
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                            $total = count(getRows("SELECT * FROM product WHERE id_category = $id"));
                            $totalPage = ceil($total / $limit);
                            $start = ($page - 1) * $limit;
                            $products = getRows("SELECT * FROM product 
                                                    WHERE id_category = $id
                                                    LIMIT $start, $limit");
                        } else {
                            $total = count(getRows('SELECT * FROM product'));
                            $totalPage = ceil($total / $limit);
                            $start = ($page - 1) * $limit;
                            $products = getRows("SELECT * FROM product LIMIT $start, $limit");
                        }
                        foreach ($products as $product) {
                        ?>
                            <div class="col-xl-3 col-md-4 col-6 col-sm-6">
                                <a href="?modules=client&action=product_detail&id=<?= $product['id'] ?>" class="product">
                                    <img src=<?= $product['thumbnail'] ?> alt="product" class="product__img">
                                    <h4 class="product__name" style="margin-top: 10px;"><?= $product['title'] ?></h4>
                                    <p class="product__price">Giá: <?= $product['price'] ?>vnd</p>
                                    <div class="product__buy">
                                        <input type="button" class="btn" value="Mua hàng">
                                    </div>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="pagination">
                    <?php
                    if ($page > 1) {
                    ?>
                        <a href="?modules=client&action=trangchu&page=<?= $page - 1 ?>
                            <?= isset($_GET['id']) ? '&id=' . $_GET['id'] : '' ?>
                            <?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    <?php } ?>

                    <?php
                    for ($i = 1; $i <= $totalPage; $i++) {
                    ?>
                        <a href="?modules=client&action=trangchu&page=<?= $i ?>
                            <?= isset($_GET['id']) ? '&id=' . $_GET['id'] : '' ?>
                            <?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
                    <?php } ?>

                    <?php
                    if ($page < $totalPage) {
                    ?>
                        <a href="?modules=client&action=trangchu&page=<?= $page + 1 ?>
                            <?= isset($_GET['id']) ? '&id=' . $_GET['id'] : '' ?>
                            <?= isset($_GET['search']) ? '&search=' . $_GET['search'] : '' ?>" class="pagination__next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once('./modules/layout/footer.php');
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <!-- Display slide thumbnail -->
    <script>
        function fetchThumbnails() {
            fetch('./api/product/get_thumbnails.php')
                .then(response => response.json())
                .then(data => {
                    window.thumbnail = data;
                    displayNextThumbnail();
                    setInterval(displayNextThumbnail, 5000);
                });
        }

        function displayNextThumbnail() {
            var slideList = document.querySelector('.slide');
            var navbarHeader = document.querySelector('.navbar__header');
            var nextThumbnail = window.thumbnail.shift();
            window.thumbnail.push(nextThumbnail);
            slideList.setAttribute('style', `
                    background-image: url(${nextThumbnail.thumbnail});
                    background-size: cover;
                    background-position: center;
                    background-repeat: no-repeat;
                    background-attachment: fixed;
                    margin-top: 56px;
                    width: 100%;
                    height: 100vh;
                    `);
        }

        fetchThumbnails();
    </script>
    <!-- Display slide thumbnail -->
</body>

</html>