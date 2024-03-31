<?php
require_once '../config/connectDB.php';
$proID = $_GET['id'];
$sql = "SELECT * FROM product WHERE product_id = '$proID'";
$hand = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_array($hand);
if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

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
                    <div class="alert alert-primary h4" role="alert">แก้ไขข้อมูลสินค้าของรหัส : <?= $row1['product_id'] ?></div>
                    <form name="form1" method="post" action="controller/update_product.php" enctype="multipart/form-data">
                        <label>รหัสสินค้า : </label>
                        <input type="text" name="pid" class="form-control" value=<?= $row1['product_id'] ?> style="color: grey;" readonly><br>

                        <label>ชื่อสินค้า : </label>
                        <textarea name="pname" class="form-control"><?= $row1['product_name'] ?></textarea><br>

                        <label>รายละเอียดสินค้า : </label>
                        <textarea name="detail" class="form-control"><?= $row1['product_description'] ?></textarea><br>

                        <label>ราคา : </label>
                        <input type="number" name="price" class="form-control" value="<?= $row1['price_per_unit'] ?>"><br>

                        <label>จำนวน : </label>
                        <input type="number" name="num" class="form-control" value="<?= $row1['stock_qty'] ?>"><br>
                        <label>รูปภาพ : </label>
                        <input type="file" name="pimage" class="form-control" value=""><br>

                        <!-- 
                        <img src="../img/<?= $row1['image'] ?>" alt="" width="100"><br><br>
                        <label>รูปภาพ : </label>
                        <input type="file" name="file1"><br><br>
                        <!-- ซ่อนรูปภาพเอาไฟล์ไปใช้ต่อ 
                        <input type="hidden" name="txtimg" class="form-control" value="<?= $row1['image'] ?>"><br>
                        -->

                        <button type="submit" class="btn btn-primary">submit</button>
                        <a href="#" class="btn btn-danger" role="button">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>


</body>

</html>

<?php
mysqli_close($conn);
?>