<?php
require_once(__DIR__ . '/../../db/database.php');

$category_name = '';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $category_name = getRow("SELECT * FROM category WHERE id = $id")['name'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $category_name = $_POST['category_name'];
        $data = [
            'name' => $category_name,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $where = [
            'id' => $id
        ];
        try {
            $rs = update('category', $data, $where);
            $msg = "Cập nhật thành công";
            $type = "success";
        } catch (Exception $e) {
            $msg = "Cập nhật không thành công";
            $type = "danger";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $_POST['category_name'];
    $data = [
        'name' => $category_name,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => null
    ];
    try {
        $rs = insert('category', $data);
        $msg = "Thêm mới thành công";
        $type = "success";
    } catch (Exception $e) {
        $msg = "Thêm mới không thành công";
        $type = "danger";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm/sửa danh mục sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="canonical" href="https://www.wrappixel.com/templates/ample-admin-lite/" />
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/plugins/images/favicon.png">
    <link href="../assets/plugins/bower_components/chartist/dist/chartist.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/plugins/bower_components/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css">
    <!-- Custom CSS -->
    <link href="../assets/css/style.min.css" rel="stylesheet">
</head>

<body>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a href="../admin/index.php?layout=category" class="nav-link">Quản lý danh mục</a>
        </li>
        <li class="nav-item">
            <a href="../admin/index.php?layout=product" class="nav-link">Quản lý sản phẩm</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Thêm/sửa danh mục</h2>
            </div>
            <?php if (isset($msg)) { ?>
                <div class="alert alert-<?= $type ?>" role="alert">
                    <?= $msg ?>
                </div>
            <?php } ?>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label for="category" style="margin-bottom: 6px;">Tên danh mục</label>
                        <input type="text" name="category_name" class="form-control" id="category" value="<?= $category_name ?>" placeholder="Enter category name" required>
                    </div>
                    <input type="submit" class="btn btn-primary" style="margin-top: 8px;" value="Save">
                </form>
            </div>
        </div>
    </div>

</body>

</html>