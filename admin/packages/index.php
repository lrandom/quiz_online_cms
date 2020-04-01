<!DOCTYPE html>
<html lang="en">

<?php
require_once('./../commons/head.php');
require_once('./../../config.php');
require_once('./../../db.php');
require_once('./../auth.php');
$db = new DB();
$db = $db->getDB();
mysqli_query($db, "SET NAMES utf8");
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    //xoa goi
    $id = $_GET['id'];
    $obj = mysqli_query($db, 'SELECT image FROM question_packages WHERE id = ' . $id);
    if ($obj->num_rows == 1) {
        $row = $obj->fetch_assoc();
        if ($row['image'] != null) {
            if (file_exists('./../../uploads/' . str_replace('uploads/', '', $row['image']))) {
                try {
                    unlink('./../../uploads/' . str_replace('uploads/', '', $row['image']));
                } catch (\Throwable $th) {
                    //throw $th;
                    $th->getMessage();
                }
            };
        }
    }
    mysqli_query($db, 'DELETE FROM question_packages WHERE id =' . $id) or die('Khong the thuc hien thao tac nay');
}
$query = mysqli_query($db, 'SELECT * FROM question_packages');

?>

<body>
    <?php
    require_once('./../commons/nav.php');
    ?>
    <div class="container">
        <div class="row">
            <div style="margin-top:10px">
                <a class="btn btn-primary" href="add.php">Thêm gói</a></div>
            <br>
            <br>
            <br>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#id</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Mô tả</th>
                        <th scope="col">Ảnh đại diện</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($query->num_rows > 0) {
                        while ($row = $query->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['description'] ?></td>
                        <td>
                            <?php if ($row['image'] != null) { ?>
                            <img style="width:100px;height:80px" src="<?php echo BASE_URL . $row['image']; ?>" />
                            <?php } ?>
                        </td>
                        <td>
                            <a class="btn btn-warning" href="edit.php?id=<?php echo $row['id']; ?>">Sửa</a>
                            <a class="btn btn-danger" href="?action=delete&id=<?php echo $row['id']; ?>">Xoá</a>
                        </td>
                    </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>