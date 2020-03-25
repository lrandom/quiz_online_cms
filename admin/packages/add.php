<?php
session_start();

require_once('./../../db.php');
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $db = new DB();
    $db = $db->getDB();
    $db->set_charset("utf8");

    $isExistFile = false;
    if (isset($_FILES['image'])) {
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
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5>Thêm gói</h5>
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
                        <label for="exampleFormControlInput1">Tên gói</label>
                        <input type="text" class="form-control" placeholder="Tên gói" name="name">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Mô tả</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Ảnh đại diện</label>
                        <input type="file" name="image">
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