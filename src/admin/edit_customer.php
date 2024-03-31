<?php
require_once "../config/connectDB.php";
$cusID = $_GET['id'];
$sql = "SELECT * FROM customer WHERE customer_id = '$cusID'";
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
    <title>Edit customer</title>

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
                    <div class="alert alert-primary h4" role="alert">แก้ไขข้อมูลลูกค้าของรหัส : <?= $row1['customer_id'] ?></div>
                    <form name="form1" method="post" action="controller/update_customer.php" enctype="multipart/form-data">
                        <label>รหัสสินค้า : </label>
                        <input type="text" name="cid" class="form-control" value=<?= $row1['customer_id'] ?> style="color: grey;" readonly><br>

                        <label>ชื่อลูกค้า : </label>
                        <input type="text" name="cname" class="form-control" value=<?= $row1['customer_name'] ?>><br>

                        <label>เพศ : </label>
                        <select name="sex" class="form-control">
                            <option value="ชาย" <?php if ($row1['sex'] == "ชาย") echo "selected"; ?>>ชาย</option>
                            <option value="หญิง" <?php if ($row1['sex'] == "หญิง") echo "selected"; ?>>หญิง</option>
                            <option value="ไม่ระบุ" <?php if ($row1['sex'] == "ไม่ระบุ") echo "selected"; ?>>ไม่ระบุ</option>
                        </select>


                        <label>ที่อยู่ : </label>
                        <textarea name="addr" class="form-control"><?= $row1['addr'] ?></textarea><br>

                        <label>เบอร์ติดต่อ : </label>
                        <input type="tel" name="tel" class="form-control" value="<?= $row1['tel'] ?>"><br>


                        <label>วันเกิด : </label>
                        <input type="date" name="bdate" class="form-control" value="<?= $row1['birthDate'] ?>"><br>

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