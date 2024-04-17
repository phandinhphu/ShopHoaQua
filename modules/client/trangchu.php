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
    <link rel="shortcut icon" href="https://th.bing.com/th/id/R.74bff8ec53bb5bc71046aaa4a21fe9a5?rik=3d39%2f638LB5vog&pid=ImgRaw&r=0" type="image/x-icon">
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
        <div class="slide__list"></div>
        <div class="btns">
            <div class="btn__left btn__slide">
                <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>
            </div>
            <div class="btn__right btn__slide">
                <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
            </div>
        </div>
        <div class="index__img"></div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-3 col-0 col-sm-3">
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

            <div class="col-md-9 col-12 col-sm-9">
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
                            <div class="col-xl-3 col-6 col-sm-4">
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

    <script src="./modules/client/assets/js/main.js"></script>

    <script>
        fetch('./api/product/get_thumbnails.php')
            .then(response => response.json())
            .then(data => {
                const slideList = document.querySelector('.slide__list');
                const indexImg = document.querySelector('.index__img');
                let htmlImg = data.map(function(thumbnails) {
                    return `
                    <img srcset="${thumbnails.thumbnail} 2x" alt="slide" class="slide__img">
                    `;
                }).join('');

                let htmlIdxImg = data.map(function(thumbnails) {
                    return `
                    <div class="index__item"></div>
                    `;
                }).join('');

                slideList.innerHTML = htmlImg;
                indexImg.innerHTML = htmlIdxImg;

                const imgs = document.querySelectorAll('.slide__img');
                const length = imgs.length;
                const btnLeft = document.querySelector('.btn__left');
                const btnRight = document.querySelector('.btn__right');
                const idxImgs = document.querySelectorAll('.index__item');
                idxImgs[0].classList.add('active__slide');
                
                let current = 0;

                const handleChangeSlide = () => {
                    if (current == length - 1) {
                        current = 0;
                        slideList.style.transform = `translateX(0px)`;
                        idxImgs.forEach(idxImg => {
                            idxImg.classList.remove('active__slide');
                        })
                        idxImgs[current].classList.add('active__slide');
                    } else {
                        ++current;
                        let width = imgs[0].offsetWidth;
                        slideList.style.transform = `translateX(${width * -1 * current}px)`;
                        idxImgs.forEach(idxImg => {
                            idxImg.classList.remove('active__slide');
                        })
                        idxImgs[current].classList.add('active__slide');
                    }
                };

                let handleInterval = setInterval(handleChangeSlide, 4000);

                btnRight.addEventListener('click', () => {
                    clearInterval(handleInterval);
                    handleChangeSlide();
                    handleInterval = setInterval(handleChangeSlide, 4000);
                });

                btnLeft.addEventListener('click', () => {
                    clearInterval(handleInterval);
                    if (current == 0) {
                        current = length - 1;
                        let width = imgs[0].offsetWidth;
                        slideList.style.transform = `translateX(${width * -1 * current}px)`;
                        idxImgs.forEach(idxImg => {
                            idxImg.classList.remove('active__slide');
                        })
                        idxImgs[current].classList.add('active__slide');
                    } else {
                        --current;
                        let width = imgs[0].offsetWidth;
                        slideList.style.transform = `translateX(${width * -1 * current}px)`;
                        idxImgs.forEach(idxImg => {
                            idxImg.classList.remove('active__slide');
                        })
                        idxImgs[current].classList.add('active__slide');
                    }
                    handleInterval = setInterval(handleChangeSlide, 4000);
                });
            });
    </script>
</body>

</html>