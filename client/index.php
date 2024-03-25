<?php
require_once('../db/database.php');
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
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/main.css">
</head>

<body>
    <?php
    include_once('../layout/header.php');
    ?>

    <div class="container">
        <div class="grid">
            <div class="slide">
                <div class="slide__list">
                </div>
            </div>
            <div class="row">
                <div class="col c-3">
                    <div class="category">
                        <div class="category__heading">
                            <i class="category__heading-icon fa fa-list"></i>
                            <h3>Danh mục</h3>
                        </div>
                        <ul class="category__list">
                            <?php if (isset($class)) {
                                $_class = $class;
                            } ?>
                            <li class="category__item"><a class="category__item-link <?= !isset($_GET['id']) ? 'category__item-link--active' : '' ?>" href="index.php">Tất cả sản phẩm</a></li>
                            <?php
                            $categories = getRows('SELECT * FROM category');
                            foreach ($categories as $category) {
                            ?>
                                <li class="category__item"><a class="category__item-link <?=
                                                                                            isset($_GET['id']) && $_GET['id'] == $category['id'] ? 'category__item-link--active' : ''
                                                                                            ?>" href="index.php?id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="col c-9">
                    <div class="content">
                        <h3>Sản phẩm</h3>
                        <form class="form-inline my-2 my-lg-0">
                            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                            <button class="btn-search my-2 my-sm-0" type="submit">Search</button>
                        </form>
                        <div class="row">
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
                                <div class="col c-3">
                                    <a href="product-detail.php?id=<?= $product['id'] ?>" class="product">
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
                            <a href="index.php?page=<?= $page - 1 ?>" class="pagination__prev">
                                <i class="fa fa-arrow-left"></i>
                            </a>
                        <?php } ?>

                        <?php
                        for ($i = 1; $i <= $totalPage; $i++) {
                        ?>
                            <a href="index.php?page=<?= $i ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
                        <?php } ?>

                        <?php
                        if ($page < $totalPage) {
                        ?>
                            <a href="index.php?page=<?= $page + 1 ?>" class="pagination__next">
                                <i class="fa fa-arrow-right"></i>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once('../layout/footer.php');
    ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        var categoryHeading = document.querySelector('.category__heading');
        var categoryList = document.querySelector('.category__list');
        categoryHeading.addEventListener('click', function() {
            categoryList.classList.toggle('category__list--active');
        });
    </script>
    <script>
        function fetchThumbnails() {
            fetch('../api/get_thumbnail.php')
                .then(response => response.json())
                .then(data => {
                    window.thumbnail = data;
                    displayNextThumbnail();
                    setInterval(displayNextThumbnail, 5000);
                });
        }

        function displayNextThumbnail() {
            var slideList = document.querySelector('.slide__list');
            var nextThumbnail = window.thumbnail.shift();
            window.thumbnail.push(nextThumbnail);
            slideList.innerHTML =
                `<div class="slide__item">
                            <a href="product-detail.php?id=${nextThumbnail.id}" class="slide__link">
                                <img src="${nextThumbnail.thumbnail}" alt="slide" class="slide__img">
                            </a>
                        </div>`;
        }

        fetchThumbnails();
    </script>
</body>

</html>