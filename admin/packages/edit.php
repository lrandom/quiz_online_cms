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