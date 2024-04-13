<?php
session_start();
if (empty($_SESSION['username'])) {
    header('Location: ?module=client&action=login');
    die();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $product = getRow("SELECT * FROM product WHERE id = $id");
} else {
    header('Location: ?module=client&action=trangchu');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="CodeHim">
    <title>Trang Sản Phẩm</title>
    <link rel="shortcut icon" href="https://th.bing.com/th/id/R.74bff8ec53bb5bc71046aaa4a21fe9a5?rik=3d39%2f638LB5vog&pid=ImgRaw&r=0" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./modules/client/assets/css/main.css">
</head>

<body>
    <?php
    include_once('./modules/layout/header.php');
    ?>

    <nav class="breadcrumb" style="margin-top: 56px;">
        <a class="breadcrumb-item" href="?module=client&action=trangchu">
            <i class="fa fa-home" aria-hidden="true"></i>
            Trang chủ
        </a>

        <a class="breadcrumb-item" href="?module=client&action=trangchu">
            <i class="fa fa-product-hunt" aria-hidden="true"></i>
            Sản phẩm
        </a>

        <span class="breadcrumb-item active"><?= $product['title'] ?></span>
    </nav>

    <form action="?module=client&action=giohang" method="post" class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?= $product['thumbnail'] ?>" alt="..." /></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder"><?= $product['title'] ?></h1>
                    <div class="fs-5 mb-5">
                        <span class="text-decoration-line-through" style="font-size: 20px; font-weight: 600;">
                            <?= $product['price'] ?>vnd
                        </span>
                        <!-- <span>$40.00</span> -->
                    </div>
                    <p class="lead"><?= $product['content'] ?></p>
                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="num" name="quantity" value="1" style="max-width: 3rem; margin-right: 8px;" />
                        <button class="btn btn-outline-dark flex-shrink-0" type="submit" name="addToCart">
                            <i class="fa fa-cart-arrow-down"></i>
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <input type="hidden" name="title" value="<?= $product['title'] ?>">
        <input type="hidden" name="price" value="<?= $product['price'] ?>">
    </form>

    <?php
    include_once('./modules/layout/footer.php');
    ?>

    <script src="./modules/client/assets/js/main.js"></script>
</body>

</html>