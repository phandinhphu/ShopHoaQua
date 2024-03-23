<?php
require_once(__DIR__ . '/../../db/database.php');

$product = [
    'title' => '',
    'thumbnail' => '',
    'price' => '',
    'content' => '',
    'id_category' => ''
];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT product.*, category.name as category_name,
            category.id as category_id
            FROM product left join category 
            on product.id_category = category.id 
            WHERE product.id = $id";
    $product = getRow($sql);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $product_name = $_POST['title_product'];
        $thumbnail = $_POST['thumbnail'];
        $price = $_POST['price'];
        $content = $_POST['content'];
        $id_category = $_POST['category'];
        $data = [
            'title' => $product_name,
            'thumbnail' => $thumbnail,
            'price' => $price,
            'content' => $content,
            'id_category' => $id_category,
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $where = [
            'id' => $id
        ];
        try {
            $rs = update('product', $data, $where);
            $msg = "Cập nhật thành công";
            $type = "success";
        } catch (Exception $e) {
            $msg = "Cập nhật không thành công";
            $type = "danger";
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['title_product'];
    $thumbnail = $_POST['thumbnail'];
    $price = $_POST['price'];
    $content = $_POST['content'];
    $id_category = $_POST['category'];

    $data = [
        'title' => $product_name,
        'thumbnail' => $thumbnail,
        'price' => $price,
        'content' => $content,
        'id_category' => $id_category,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    try {
        $rs = insert('product', $data);
        $msg = "Thêm thành công";
        $type = "success";
    } catch (Exception $e) {
        $msg = "Thêm không thành công";
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
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
                <h2 class="text-center">Thêm/sửa sản phẩm</h2>
            </div>
            <?php if (isset($msg)) { ?>
                <div class="alert alert-<?= $type ?>" role="alert">
                    <?= $msg ?>
                </div>
            <?php } ?>
            <div class="panel-body">
                <form method="post">
                    <div class="form-group">
                        <label for="title_product" style="margin-bottom: 6px;">Tên sản phẩm</label>
                        <input type="text" name="title_product" class="form-control" id="title_product" value="<?= $product['title'] ?>" placeholder="Enter product name" required>
                    </div>
                    <div class="form-group">
                        <label for="category" style="margin-bottom: 6px;">Danh mục</label>
                        <select class="form-control" name="category" id="category" required>
                            <option value="">--Lựa chọn danh mục--</option>
                            <?php
                            $sql = "SELECT * FROM category";
                            $categories = getRows($sql);
                            ?>
                            <?php if (isset($product['category_id'])) { ?>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= $category['name'] ?></option>
                                <?php } ?>
                            <?php } else { ?>
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                <?php } ?>
                            <?php } ?>

                        </select>

                    </div>
                    <div class="form-group">
                        <label for="price" style="margin-bottom: 6px;">Giá</label>
                        <input type="number" name="price" class="form-control" id="price" value="<?= $product['price'] ?>" placeholder="Enter price" required>
                    </div>
                    <div class="form-group">
                        <label for="thumbnail" style="margin-bottom: 6px;">Thumbnail</label>
                        <input type="text" name="thumbnail" class="form-control" id="thumbnail" onchange="changeThumbnail()" value="<?= $product['thumbnail'] ?>" placeholder="Enter thumbnail" required>
                        <img src="<?= $product['thumbnail'] ?>" id="js-thumbnail" alt="" style="width: 150px;">
                    </div>
                    <div class="form-group">
                        <label for="content" style="margin-bottom: 6px;">Content</label>
                        <textarea class="form-control" name="content" id="content" rows="5" required><?= $product['content'] ?></textarea>
                    </div>
                    <input type="submit" class="btn btn-primary" style="margin-top: 8px;" value="Save">
                </form>
            </div>
        </div>
    </div>
    <script>
        function changeThumbnail() {
            var thumbnail = document.getElementById('thumbnail').value;
            document.getElementById('js-thumbnail').src = thumbnail;
        }
        $('#content').summernote({
            height: 150,
            codemirror: {
                theme: 'monokai'
            }
        });
    </script>
</body>

</html>