<?php
session_start();

if (empty($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$category = getRows('SELECT * FROM category');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['keyword'])) {
        $search = $_GET['keyword'];
        $products = getRows("SELECT * FROM product WHERE title LIKE '%$search%'");
    } else {
        $products = getRows('SELECT * FROM product');
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm sản phẩm</title>
    <link rel="shortcut icon" href="https://th.bing.com/th/id/R.74bff8ec53bb5bc71046aaa4a21fe9a5?rik=3d39%2f638LB5vog&pid=ImgRaw&r=0" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./modules/client/assets/css/base.css">
    <link rel="stylesheet" href="./modules/client/assets/css/main.css">
    <link rel="stylesheet" href="./modules/client/assets/css/responsive.css">
</head>

<body>
    <?php
    include_once './modules/layout/header.php';
    ?>

    <nav class="breadcrumb" style="margin-top: 56px;">
        <a class="breadcrumb-item" href="?module=client&action=trangchu">
            <i class="fa fa-home" aria-hidden="true"></i>
            Trang chủ
        </a>

        <a class="breadcrumb-item" href="?module=client&action=search_product">
            <i class="fa fa-product-hunt" aria-hidden="true"></i>
            Tìm kiếm sản phẩm
        </a>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h2 class="page-heading">Tìm kiếm sản phẩm <?= isset($search) ? $search : ' - Tất cả sản phẩm' ?></h2>
                <form method="get">
                    <input type="hidden" name="module" value="client">
                    <input type="hidden" name="action" value="search_product">
                    <select id="sortSelect" name="sort">
                        <option value="">Sort By</option>
                        <option value="price_asc">Price Low to High</option>
                        <option value="price_desc">Price High to Low</option>
                        <option value="title_asc">Title A-Z</option>
                        <option value="title_desc">Title Z-A</option>
                    </select>
                </form>
                <div id="product" class="row">
                    <?php
                    if (isset($_GET['sort'])) {
                        $sort = $_GET['sort'];
                        switch ($sort) {
                            case 'price_asc':
                                usort($products, function ($a, $b) {
                                    return $a['price'] - $b['price'];
                                });
                                break;
                            case 'price_desc':
                                usort($products, function ($a, $b) {
                                    return $b['price'] - $a['price'];
                                });
                                break;
                            case 'title_asc':
                                usort($products, function ($a, $b) {
                                    return $a['title'] <=> $b['title'];
                                });
                                break;
                            case 'title_desc':
                                usort($products, function ($a, $b) {
                                    return $b['title'] <=> $a['title'];
                                });
                                break;
                        }
                    }
                    if (count($products) > 0) {
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
                        <?php }
                    } else { ?>
                        <div class="col-xl-12 col-md-12 col-12 col-sm-12">
                            <h1 align="center" style="margin-top: 20px;">Không tìm thấy sản phẩm</h1>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="category hide-on-mobile">
                    <div class="category__heading">
                        <i class="category__heading-icon fa fa-list"></i>
                        <h3>Danh mục</h3>
                    </div>
                    <ul class="category__list">
                        <?php
                        foreach ($category as $item) {
                        ?>
                            <li class="category__item">
                                <a class="category__item-link" href="?module=client&action=trangchu&id=<?= $item['id'] ?>">
                                    <?= $item['name'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <?php
    include_once './modules/layout/footer.php';
    ?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="./modules/client/assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const sortSelect = document.getElementById('sortSelect');

            sortSelect.addEventListener('change', () => {
                const selectValue = sortSelect.value;
                var currentURL = window.location.href;

                if (currentURL.indexOf('sort=') === -1) {
                    if (currentURL.indexOf('?') !== -1) {
                        currentURL += `&sort=${selectValue}`;
                    } else {
                        currentURL += `?sort=${selectValue}`;
                    }
                } else {
                    currentURL = currentURL.replace(/(sort=)[^\&]+/, `$1${selectValue}`);
                }
                window.location.href = currentURL;
            });
        });
    </script>
</body>

</html>