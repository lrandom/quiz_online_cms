<?php
session_start();

require_once('./../../db.php');
require_once('./../auth.php');
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $db = new DB();
    $db = $db->getDB();
    mysqli_query($db, "SET NAMES utf8");

    $isExistFile = false;
    if (isset($_FILES['image']) && $_FILES['image']['name'] != null) {
        //var_dump($_FILES['image']);
        $fileName = $_FILES['image']['name'];
        $fileName = time() . str_replace(' ', '_', $fileName);
        move_uploaded_file($_FILES['image']['tmp_name'], './../../uploads/' . $fileName) or die('Cannot upload files');
        $isExistFile = true;
    };
    if ($isExistFile) {
        $query = 'insert into question_packages(name, description, image) 
    values("' . $name . '","' . $description . '","uploads/' . $fileName . '")';
    } else {
        $query = 'insert into question_packages(name, description) 
        values("' . $name . '","' . $description . '")';
    }
    mysqli_query($db, $query) or die("Cannot insert data");
    $_SESSION['success'] = 'Thêm gói thành công !!!!';
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
require_once('./../commons/head.php');
?>

<body>
    <?php
    require_once('./../commons/nav.php');
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5>Thêm nguời dùng</h5>
                <?php
                if (isset($_SESSION['success'])) {
                ?>
                <div class="alert alert-primary" role="alert">
                    <?php echo $_SESSION['success'] ?>
                </div>
                <?php
                }
                ?>
                <form enctype="multipart/form-data" method="post">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Username</label>
                        <input type="text" class="form-control" name="username">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Fullname</label>
                        <input type="text" class="form-control" name="fullname">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlInput1">Password</label>
                        <input type="text" class="form-control" name="pwd">
                    </div>


                    <div class="form-group">
                        <label for="exampleFormControlInput1">Quyền</label>
                        <select name="level">
                            <option value="1">Admin</option>
                            <option value="1">User</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="submit" value="Lưu">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>