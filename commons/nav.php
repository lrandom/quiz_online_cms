<?php
if (session_status() !== PHP_SESSION_ACTIVE || session_id() === "") {
    session_start();
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    if (isset($_SESSION['user'])) {
        unset($_SESSION['user']);
    }
}

if (!isset($_SESSION['user'])) {
    header('Location:' . BASE_URL . 'login.php');
}
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="">
        Home
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul> -->
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>

    <div class="pull-right">
        <?php
        if (isset($_SESSION['user'])) {
        ?>
        <ul>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Hello <?php echo $_SESSION['user']['username']; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Cập nhật tài khoản</a>
                    <a class="dropdown-item" href="?action=logout">Đăng xuất</a>
                </div>
            </li>
        </ul>
        <?php
        } else {
        ?>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="signup.php">Đăng ký<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="login.php">Đăng nhập<span class="sr-only">(current)</span></a>
            </li>
        </ul>

        <?php } ?>
    </div>
</nav>