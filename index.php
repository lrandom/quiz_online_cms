<?php
require_once('db.php');
require_once('config.php');
$db = new DB();
$db = $db->getDB();
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
        <div class="row">
            <?php
            while ($row = $packages->fetch_assoc()) {
            ?>
            <div class="col-md-4 col-xs-12">
                <div style="overflow:hidden;height:300px">
                    <img src="<?php echo BASE_URL . $row['image']; ?>" style="height:180px" />
                    <h5><?php echo $row['name']; ?></h5>
                    <p><?php echo $row['description']; ?></p>
                    <a class="btn btn-primary" href="choose_question.php?id=<?php echo $row['id']; ?>">Chọn gói</a>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>

</html>