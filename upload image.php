<?php


include("include/web.php");
include("include/cont.php");

$error = $msg_success ="";

if (isset($_POST['upload'])) {

    $maxsize = 2097152;

    $fileName = $_FILES['image']['name'];
    $fileTmpLoc = $_FILES['image']['tmp_name'];
    $fileType = $_FILES['image']['type'];
    $fileSize = $_FILES['image']['size'];
    $fileErrorMsg = $_FILES["image"]['error'];
    $kaboom = explode(".", $fileName);
    $fileExt = end($kaboom);

    $db_file_name = rand(100000000000, 999999999999) . "." . $fileExt;
    if ($fileSize >= $maxsize || $fileSize == 0) {

        if ($fileSize >= $maxsize) {
            $error = "Your image file was larger than 2MB";
        }

        if ($fileSize == 0) {
            $error= "Please select image";
        }

    } else if (!preg_match("/\.(gif|jpg|jpeg|png)$/i", $fileName)) {
        $error = "Your image file was not jpg, jpeg, gif or png type";

    } else if ($fileErrorMsg == 1) {
        $error = "An unknown error occurred";

    } else {

        $image = $_FILES['image']['name'];
        $target = "images/" . basename($_FILES['image']['name']);

       
        $upload_image = "INSERT INTO img_upload(name) VALUE ('" . $image . "')";
        if ($db->multi_query($upload_image)) {

            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $msg_success = "Image uploaded successfully";
            } else {
                $error = "There was a problem uploading image";
            }

        }

       
        $file_name = basename($_FILES['image']['name']);
        $temp_path = "C:\\wamp64\\www\\test\\images\\$file_name";
        $move_path = "D:\\Image\\$file_name";

        $safe_temp_path = escapeshellarg($temp_path);
        $safe_move_target = escapeshellarg($move_path);
        exec("move $safe_temp_path $safe_move_target");

    }

}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container-fluid col-md-6 col-md-offset-3" style="margin-top: 50px;">
    <form action="" method="post" enctype="multipart/form-data">
        <h3 class="text-left">Change Profile Picture </h3>

        <div class="row" style="margin-top: 30px;">

            <div class="col-sm-2">
                <input type="file" name="image" class="btn btn-info waves-effect waves-light m-b-5"/>
            </div>

            <div class="col-sm-1">
                <button type="submit" name="upload" class="btn btn-info waves-effect waves-light m-b-5"
                        style="margin-left: 200px; margin-bottom: 30px;" id="insert"><i class="fa fa-cloud m-r-5"></i> <span>Upload </span>
                </button>
            </div>

        </div>


        <?php if (!empty($msg_success)) { ?>
            <div class="col-sm-12 alert alert-success" role="alert">
                <?php echo $msg_success ?>
            </div>
        <?php } ?>

        <?php if (!empty($error)) { ?>
            <div class="col-sm-12 alert alert-danger" role="alert">
                <?php echo $error ?>
            </div>
        <?php } ?>

    </form>

    <?php
    $result = $db->query(" SELECT * FROM img_upload ");
//    $move_path = "D:\\Image\\";
    while ($row = $result->fetch_assoc()) {?>

        <img src="<?php echo "D://Image//".$row['name'];?>"
             class="img-thumbnail thumb-xl img-thumbnail m-b-10"
             alt="profile-image" style="height: 150px; width: 150px; margin-top: 20px;"/>

    <?php } ?>
</div>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
