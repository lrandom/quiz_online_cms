<?php
session_start();

require_once('./../../db.php');
$db = new DB();
$db = $db->getDB();
$db->set_charset("utf8");
if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id_package = $_POST['id_package'];

    $query = 'insert into questions(title,content,id_package) 
        values("' . $title . '","' . $content . '",' . $id_package . ')';
    mysqli_query($db, $query) or die("Cannot insert data");
    $_SESSION['success'] = 'Thêm Câu hỏi thành công !!!!';
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
                        <label for="exampleFormControlInput1">Tiêu đề câu hỏi<label>
                                <input type="text" class="form-control" placeholder="Tiêu đề câu hỏi" name="title">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Nội dung</label>
                        <textarea class="form-control" name="content" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Gói</label>
                        <select class="form-control" name="id_package">
                            <?php
                            $packages = mysqli_query($db, 'select * from question_packages');
                            if ($packages->num_rows > 0) {
                                while ($row = $packages->fetch_assoc()) {
                            ?>
                            <option value=" <?php echo $row['id'] ?>"><?php echo $row['name']; ?></option> ?></option>

                            <?php
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class=" form-group">
                        <input type="submit" class="btn btn-primary" name="submit" value="Lưu">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>