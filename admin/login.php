<?php
if (session_status() !== PHP_SESSION_ACTIVE || session_id() === "") {
    session_start();
}
require_once('./../db.php');
require_once('./../config.php');
if (isset($_SESSION['user']) && $_SESSION['user']['level'] == 0) {
    //if la user
    header('Location:' . BASE_URL . 'index.php');
}

if (isset($_SESSION['user']) && $_SESSION['user']['level'] == 1) {
    //if la admin
    header('Location:' . BASE_URL . 'admin/questions/index.php');
}

$db = new DB();
$db = $db->getDB();
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
//???
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $result = mysqli_query($db, 'SELECT * FROM users
     WHERE username="' . $username .
        '" AND pwd = "' . md5($pwd) . '" AND level=1');
    if ($result->num_rows == 1) {
        $_SESSION['user'] = $result->fetch_assoc();
        header('Location:index.php');
    } else {
        //LỖI 
        $_SESSION['error'] = 'Thông tin đăng nhập không đúng';
    }
}
$query = 'SELECT * from question_packages';
$packages = mysqli_query($db, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Trắc nghiệm onlien</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</head>


<body>
    <div class="container">
        <?php
        if (isset($_SESSION['error'])) {
        ?>
        <div class="alert alert-primary" role="alert">
            <?php echo $_SESSION['error'] ?>
        </div>
        <?php
        }
        ?>
        <form method="POST">
            <div class="form-group">
                <label for="exampleInputEmail1">Username</label>
                <input type="text" name="username" class="form-control">`
            </div>

            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="pwd" class="form-control">
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>