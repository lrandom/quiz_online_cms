<?php
if (session_status() !== PHP_SESSION_ACTIVE || session_id() === "") {
    session_start();
}
require_once('db.php');
require_once('config.php');
$db = new DB();
$db = $db->getDB();
if (isset($_SESSION['error'])) {
    unset($_SESSION['error']);
}
mysqli_query($db, "SET NAMES utf8");

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $pwd = $_POST['pwd'];
    $fullname = $_POST['fullname'];
    $result = mysqli_query($db, 'SELECT * FROM users WHERE username=' . $username);
    if ($result->num_rows > 0) {
        $_SESSION['error'] = 'Nguời dùng này đã tồn tại';
    } else {
        //chèn vào csdl
        mysqli_query($db, 'INSERT INTO users (username,pwd,fullname) 
        VALUES ("' . $username . '","' . md5($password) . '","' . $fullname . '")')
            or die('Cannot insert into db');
        header('Location:login.php');
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
    <?php require_once('./commons/nav.php') ?>
    <br>
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
                <label>Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="pwd" required>
            </div>

            <div class="form-group">
                <label>Fullname</label>
                <input type="text" class="form-control" name="fullname" required>
            </div>

            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>