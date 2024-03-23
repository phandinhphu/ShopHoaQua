<?php
require_once(__DIR__ . '/db/database.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        <?php
        include_once(__DIR__ . '/assets/css/grid.css');
        include_once(__DIR__ . '/assets/css/main.css');
        ?>
    </style>
</head>

<body>
    <?php
    include_once(__DIR__ . '/layout/header.php');
    ?>

    <div class="container">
        <div class="grid">
            <div class="row">
                <div class="col c-3">
                    <div class="category">
                        <div class="category__heading">
                            <i class="category__heading-icon fa fa-list"></i>
                            <h3>Danh mục</h3>
                        </div>
                        <ul class="category__list">
                            <li class="category__item"><a class="category__item-link" href="index.php">Tất cả sản phẩm</a></li>
                            <?php
                            $categories = getRows('SELECT * FROM category');
                            foreach ($categories as $category) {
                            ?>
                                <li class="category__item"><a class="category__item-link" href="index.php?id=<?= $category['id'] ?>"><?= $category['name'] ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <div class="col c-9">
                    <div class="content">
                        <h3>Sản phẩm</h3>
                        <div class="row">
                            <?php
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                            } else {
                                $page = 1;
                            }
                            $total = count(getRows('SELECT * FROM product'));
                            $limit = 8;
                            $totalPage = ceil($total / $limit);
                            $start = ($page - 1) * $limit;
                            $products = getRows("SELECT * FROM product LIMIT $start, $limit");
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                                $products = getRows("SELECT * FROM product 
                                                    WHERE id_category = $id
                                                    LIMIT $start, $limit");
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
    include_once(__DIR__ . '/layout/footer.php');
    ?>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        var categorys = document.querySelector('.category__item-link');
        for (var i = 0; i < categorys.length; i++) {
            categorys[i].addEventListener('click', function() {
                console.log(categorys[i]);
                categorys.forEach(function(item) {
                    item.classList.remove('category__item-link--active');
                });
                this.classList.add('category__item-link--active');
            });
        }
    </script>
</body>

</html>