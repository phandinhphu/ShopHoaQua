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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="#" class="nav-link active">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a href="../admin/index.php?layout=product" class="nav-link">Quản lý sản phẩm</a>
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
                    $total = count(getRows('SELECT * FROM category'));
                    $limit = 8;
                    $totalPage = ceil($total / $limit);
                    $start = ($page - 1) * $limit;
                    $sql = "SELECT * FROM category LIMIT $start, $limit";
                    $categories = getRows($sql);
                ?>
                <table class="table table-bordered">
                    <a href="../admin/index.php?layout=addcategory" class="btn btn-success" style="margin-bottom: 6px;">Thêm Danh Mục</a>
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Name</th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category) { ?>
                            <tr>
                                <td><?= $category['id'] ?></td>
                                <td><?= $category['name'] ?></td>
                                <td>
                                    <a href="category/add.php?id=<?= $category['id'] ?>" class="btn btn-warning">Sửa</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger" onclick="deleteCategory(<?=$category['id']?>)">Xóa</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagination">
                    <?php
                    if ($page > 1) {
                    ?>
                        <a href="index.php?layout=category&page=<?= $page - 1 ?>" class="pagination__prev">
                            <i class="fa fa-arrow-left"></i>
                        </a>
                    <?php } ?>

                    <?php
                    for ($i = 1; $i <= $totalPage; $i++) {
                    ?>
                        <a href="index.php?layout=category&page=<?= $i ?>" class="pagination__number <?= $i == $page ? 'pagination__number--active' : '' ?>"><?= $i ?></a>
                    <?php } ?>

                    <?php
                    if ($page < $totalPage) {
                    ?>
                        <a href="index.php?layout=category&page=<?= $page + 1 ?>" class="pagination__next">
                            <i class="fa fa-arrow-right"></i>
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function deleteCategory(id) {
            var conf = confirm('Bạn có chắc chắn muốn xóa danh mục này không?');
            if (!conf) {
                return;
            }
            $.post('category/ajax.php', {
                'id': id,
                'action': 'delete'
            }, function(data) {
                location.reload();
            });
        }
    </script>
</body>

</html>