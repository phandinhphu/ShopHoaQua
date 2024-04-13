<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="?module=client&action=trangchu">Shop Hoa Quả</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="?module=client&action=trangchu">Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="?module=client&action=giohang">Giỏ hàng
            <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
            <span class="badge badge-danger"><?= !empty($_SESSION['cart']) ? count($_SESSION['cart']) : '0' ?></span>
        </a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="?module=client&action=search_product">Tìm kiếm</a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="?module=client&action=history">Lịch sử</a>
      </li>
    </ul>

    
    <form class="form-inline my-2 my-lg-0" method="get">
      <input type="hidden" name="module" value="client">
      <input type="hidden" name="action" value="search_product">
      <div class="group__search">
        <input class="input__search" type="search" placeholder="Search" aria-label="Search" name="keyword">
        <button class="btn__search my-2 my-sm-0" type="submit">Search</button>
        <i class="search__icon fa fa-search" aria-hidden="true"></i>
      </div>
    </form>
    
    
    <div class="navbar-nav navbar__user">
      <span class="navbar-text">
        <?= $_SESSION['username'] ?>
      </span>
      <ul class="navbar-nav navbar__user-items">
        <li class="nav-item">
          <a class="navbar__user-link" href="?module=client&action=profile">Profile</a>
        </li>
        <li class="nav-item">
          <a class="navbar__user-link" href="?module=client&action=logout">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>