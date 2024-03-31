<?php
require_once '../config/connectDB.php';
if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>

    <!-- link bootsrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</head>

<body class="sb-nav-fixed">
    <?php include 'menu.php'; ?>
    <div class="container-fluid px-4">
        <div class="card-body mt-4">
            <div class="row">
                <div class="col">
                    <div class="alert alert-primary h4" role="alert">เพิ่มข้อมูลสินค้า</div>
                    <form name="form1" method="post" action="controller/insert_product.php" enctype="multipart/form-data">
                        <label>ชื่อสินค้า : </label>
                        <input type="text" name="pname" class="form-control" placeholder="ชื่อสินค้า..." id="" required><br>

                        <label>รายละเอียดสินค้า : </label>
                        <textarea name="detail" class="form-control" placeholder="รายละเอียดของสินค้า..." id="" required></textarea><br>

                        <label>ราคา : </label>
                        <input type="number" name="price" class="form-control" placeholder="ราคา..." id="" required><br>

                        <label>จำนวน : </label>
                        <input type="number" name="amount" class="form-control" placeholder="ราคา..." id="" required><br>

                        <!-- <label>รูปภาพ : </label>
                        <input type="file" name="file1" required><br><br> -->

                        <button type="submit" class="btn btn-primary">submit</button>
                        <a href="#" class="btn btn-danger" role="button">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>