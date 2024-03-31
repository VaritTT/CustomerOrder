<?php
require_once '../config/connectDB.php';
$ids = $_GET['id'];
$sql = "SELECT * FROM product WHERE product_id='$ids'";
$hand = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($hand);
if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>up stock</title>

    <!-- link bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <div class="alert alert-success mt-4 h3">แก้ไขข้อมูลสินค้า รหัส : <?= $row['product_id'] ?></div>

                <form name="form1" method="post" action="controller/update_stock_product.php">
                    <div class="mb-3 mt-3">
                        <label>รหัสสินค้า : </label>
                        <input type="text" name="pid" class="form-control" id="" value="<?= $row['product_id'] ?>" readonly style="color: gray;">
                    </div>
                    <div class="mb-3">
                        <label>ชื่อสินค้า : </label>
                        <input type="text" name="pname" class="form-control" id="" value="<?= $row['product_name'] ?>" readonly style="color: gray;">
                    </div>
                    <div class="mb-3">
                        <label>ระบุจำนวนสินค้าที่จะเพิ่ม : </label>
                        <input type="text" name="pnum" class="form-control" id="" value="<?= $row['stock_qty'] ?>">
                    </div>

                    <input type="submit" name="submit" class="btn btn-success" id="" value="Submit">
                    <a href="product.php" class="btn btn-danger">Cancel</a>
                </form>

            </div>
        </div>
    </div>

</body>

</html>