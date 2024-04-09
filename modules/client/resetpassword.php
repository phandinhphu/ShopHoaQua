<div class="col-md-9">
    <div class="card">
        <div class="card-header">
            <h3>Đổi mật khẩu</h3>
            <div class="alert" role="alert">
                <strong></strong>
            </div>
        </div>
        <div class="card-body">
            <form id="form-reset" action="?module=client&action=updateProfile" method="post">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>
                <div class="form-group">
                    <label for="rpassword">Confime password</label>
                    <input type="password" name="rpassword" id="rpassword" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
</div>