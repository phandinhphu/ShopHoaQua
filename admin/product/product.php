<?php
require_once(__DIR__ . '/../../db/database.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Admin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="../admin/index.php?layout=category" class="nav-link">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link active">Quản lý sản phẩm</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Danh sách danh mục</h2>
            </div>
            <div class="panel-body">
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
                $sql = "SELECT product.id, product.title, product.thumbnail, product.price,
                                category.name as category_name,
                                product.updated_at FROM product left join category on product.id_category = category.id
                                LIMIT $start, $limit";
                $products = getRows($sql);
                ?>
                <table class="table table-bordered">
                    <a href="../admin/index.php?layout=addproduct" class="btn btn-success" style="margin-bottom: 6px;">Thêm Danh Mục</a>
                    <thead>
                        <tr>
                            <th width="10px">ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Hình ảnh</th>
                            <th>Giá bán</th>
                            <th>Danh mục</th>
                            <th>Ngày cập nhật</th>
                            <th width="20px"></th>
                            <th width="20px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?= $product['id'] ?></td>
                                <td><?= $product['title'] ?></td>
                                <td><img src="<?= $product['thumbnail'] ?>" alt="<?= $product['title'] ?>" style="max-width: 100px;"></td>
                                <td><?= $product['price'] ?></td>
                                <td><?= $product['category_name'] ?></td>
                                <td><?= $product['updated_at'] ?></td>
                                <td>
                                    <a href="category/add.php?id=<?= $product['id'] ?>" class="btn btn-warning">Sửa</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteProduct(<?= $product['id'] ?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                    if ($page > 1) {
                    ?>
                        <a href="index.php?layout=product&page=<?= $page - 1 ?>" class="pagination__prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    <?php } ?>

                    <?php
                    for ($i = 1; $i <= $totalPage; $i++) {
                    ?>
                        <a href="index.php?layout=product&page=<?= $i ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
                    <?php } ?>

                    <?php
                    if ($page < $totalPage) {
                    ?>
                        <a href="index.php?layout=product&page=<?= $page + 1 ?>" class="pagination__next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script>
        function deleteProduct(id) {
            var conf = confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?');
            if (!conf) {
                return;
            }
            $.post('product/ajax.php', {
                'id': id,
                'action': 'delete'
            }, function(data) {
                location.reload();
            })
        }
    </script>
</body>

</html>