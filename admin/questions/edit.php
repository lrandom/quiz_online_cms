<?php
session_start();

require_once('./../../db.php');
$db = new DB();
$db = $db->getDB();
mysqli_query($db, "SET NAMES utf8");

if (isset($_SESSION['success'])) {
    unset($_SESSION['success']);
}
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $id_package = $_POST['id_package'];

    $query = 'update questions set title = "' . $title . '",
    content = "' . $content . '", 
    id_package=' . $id_package . ' where id=' . $id;
    mysqli_query($db, $query) or die("Cannot update data");

    $query = 'select * from answers where id_question = ' . $id;
    $answers = mysqli_query($db, $query);
    while ($row = $answers->fetch_assoc()) {
        $id_answer = $row['id'];
        $update_data = $_POST['answer_' . $id_answer];
        mysqli_query($db, 'update answers set content = "' . $update_data . '" where id = ' . $id_answer);
    }

    $_SESSION['success'] = 'Cập nhật câu hỏi thành công !!!!';
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $obj = mysqli_query($db, 'SELECT * FROM questions WHERE id =' . $id);
    if ($obj->num_rows == 1) {
        $row = $obj->fetch_assoc();
    }

    $query = 'select * from answers where id_question = ' . $id;
    $answers = mysqli_query($db, $query);
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
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>" />
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Tiêu đề câu hỏi<label>
                            <input type="text" class="form-control" placeholder="Tiêu đề câu hỏi" name="title" value="<?php echo $row['title'];
                            ?>">
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Nội dung</label>
                            <textarea class="form-control" name="content" rows="3">
                                <?php echo $row['content']; ?>
                            </textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlSelect2">Gói</label>
                            <select class="form-control" name="id_package">
                                <?php
                                $packages = mysqli_query($db, 'select * from question_packages');
                                if ($packages->num_rows > 0) {
                                    while ($r = $packages->fetch_assoc()) {
                                        ?>

                                        <option <?php if ($row['id_package'] == $r['id']) {
                                            echo 'selected="selected"';
                                        } ?> value="<?php echo $r['id'] ?>">
                                        <?php echo $r['name']; ?>
                                    </option>

                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>


                    <?php
                    $i = 0;
                    while ($row = $answers->fetch_assoc()) {
                        $i++;
                        ?>
                        <div class="form-group">
                            <label>Câu trả lời <?php echo $i ?></label>
                            <input type="text" class="form-control" value="<?php echo $row['content'] ?>" name="answer_<?php echo $row['id'] ?>" />
                        </div>
                        <?php
                    }
                    ?>

                    <?php
                    $i = 0;
                    mysqli_data_seek($answers, 0);
                    while ($row = $answers->fetch_assoc()) {
                        ?>
                        <div>
                            <label for=""><?php echo $i + 1; ?></label>
                            <input type="radio" name="right_answer" <?php if ($row['is_correct'] == 1) {
                                echo 'checked="checked"';
                            } ?> value="<?php echo $row['id']; ?>" />
                        </div>
                        <?php
                        $i++;
                    }
                    ?>

                    <div class=" form-group">
                        <input type="submit" class="btn btn-primary" name="submit" value="Lưu">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>