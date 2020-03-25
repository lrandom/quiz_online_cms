<!DOCTYPE html>
<html lang="en">

<?php
require_once('./../../config.php');
require_once('./../commons/head.php');
require_once('./../../db.php');
$db = new DB();
$db = $db->getDB();
if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $obj = mysqli_query($db, 'update question_packages 
     SET name ="' . $name . '", description = "' . $description . '" where id=' . $id) or die('Cannot update');
    if (isset($_FILES['image']) && $_FILES['image']['name'] != null) {
        //upload file va thay the
        $obj = mysqli_query($db, 'SELECT image FROM question_packages WHERE id = ' . $id);
        if ($obj->num_rows == 1) {
            $row = $obj->fetch_assoc();
            if ($row['image'] != null) {
                if (file_exists('./../../uploads/' . str_replace('uploads/', '', $row['image']))) {
                    try {
                        // xoá ảnh cũ
                        unlink('./../../uploads/' . str_replace('uploads/', '', $row['image']));

                        //tải ảnh lên và cập nhật vào csdl
                        $fileName = $_FILES['image']['name'];
                        $fileName = time() . str_replace(' ', '_', $fileName);
                        move_uploaded_file($_FILES['image']['tmp_name'], './../../uploads/' . $fileName) or die('Cannot upload files');

                        mysqli_query($db, 'update question_packages 
     SET image ="uploads/' . $fileName . '" where id=' . $id) or die('Cannot update');
                    } catch (\Throwable $th) {
                        //throw $th;
                        $th->getMessage();
                    }
                };
            }
        }
    }
}

if (isset($_GET['id'])) {
    $id  = $_GET['id'];
    if (is_numeric($id)) {
        $obj = mysqli_query($db, 'SELECT * FROM question_packages WHERE id =' . $id);
        if ($obj->num_rows == 1) {
            $row = $obj->fetch_assoc();
        }
    }
}



?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h5>Thêm gói</h5>
                <form enctype="multipart/form-data" method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tên gói</label>
                        <input type="text" class="form-control" placeholder="Tên gói"
                            value="<?php echo isset($row['name']) ? $row['name'] : '' ?>" name="name">
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Mô tả</label>
                        <textarea class="form-control" name="description" rows="3">
                        <?php echo isset($row['description']) ? $row['description'] : '' ?>
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlSelect2">Ảnh đại diện</label>
                        <?php if (isset($row['image']) && $row['image'] != null) {
                        ?>
                        <img style="width:100px;height:80px" src="<?php echo BASE_URL . $row['image']; ?>" />
                        <?php
                        } ?>
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