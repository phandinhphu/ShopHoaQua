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
            <a href="#" class="nav-link active">Quản lý người dùng</a>
        </li>
        <li class="nav-item">
            <a href="../admin/index.php?layout=product" class="nav-link">Quản lý sản phẩm</a>
        </li>
    </ul>
    <div class="container">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h2 class="text-center">Danh sách người dùng</h2>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="10%"></th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody class="jsTbody">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        var tbody = document.querySelector('.jsTbody');
        $.ajax({
            url: 'http://localhost/ShopHoaQua/api/user/get_all_user.php',
            type: 'POST',
            success: function(response) {
                if (response.status == 1) {
                    var i = 0;
                    response.data.forEach(user => {
                        tbody.innerHTML += `
                            <tr>
                                <td>${++i}</td>
                                <td>${user.username}</td>
                                <td>${user.email}</td>
                                <td>
                                    <a href="../admin/index.php?layout=adduser&id=${user.id}" class="btn btn-warning">Sửa</a>
                                </td>
                                <td>
                                    <button class="btn btn-danger jsDelete" data-id="${user.id}">Xóa</button>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="5">Không có dữ liệu</td></tr>';
                }
            }
        })
    </script>
</body>
</html>