<?php
session_start();
require_once '../config/connectDB.php';
if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report All</title>

    <!-- link css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
    <!-- menu -->
    <?php include 'menu.php'; ?>
    <?php

    $pro_num = 0;
    if (isset($_GET['search'])) {
        $search = $_GET['search'];
        $sql = "SELECT * FROM product WHERE CONCAT(product_id,product_name,product_description) LIKE '%$search%' ORDER BY product_id";
    } else {
        $sql = "SELECT * FROM product";
    }
    $hand2 = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($hand2)) {
        $pro_num++;
    }
    ?>
    <!-- body -->

    <div class="container-fluid mt-4">
        <div class="row">

            <div class="col-6 mt-4">
                <h4 style="font-weight: 600;">สินค้าทั้งหมด <span class="badge text-bg-info"><?php echo $pro_num; ?></span></h4>
            </div>


            <div class="col-6 mt-4 text-end">
                <a href="add_product.php"><button class="btn btn-outline-info" type="button">เพิ่มสินค้า</button></a>
            </div>

            <form class="d-flex mt-4" role="search" action="" method="">
                <input class="form-control me-2" type="text" placeholder="ค้นหาสินค้า" name="search" aria-label="Search" value="<?php if (isset($_GET['search'])) {
                                                                                                                                    echo $_GET['search'];
                                                                                                                                } ?>">
                <button class="btn btn-info" type="submit">Search</button>
            </form>

            <div class="col-12 mt-4">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- <th>
                        <div class="checkbox d-inline-block">
                            <input type="checkbox" class="checkbox-input" id="checkbox1">
                            <label for="checkbox1" class="mb-0"></label>
                        </div>
                    </th> -->
                            <th class="text-center" scope="col">รหัสสินค้า</th>
                            <th class="text-center" scope="col">รูปสินค้า</th>
                            <th class="text-center" scope="col">ชื่อสินค้า</th>
                            <th class="text-center" scope="col">รายละเอียดสินค้า</th>
                            <th class="text-center" scope="col">ราคาต่อหน่วย</th>
                            <th class="text-center" scope="col">จำนวนที่มี</th>
                            <th class="text-center" scope="col">ดำเนินการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $hand = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_array($hand)) {
                            $product_img = base64_encode($row['product_image']);
                        ?>
                            <tr>
                                <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['product_id'] ?></td>
                                <td class="col-1 text-center" style="vertical-align: middle;"><img src="data:../image/jpeg;base64,<?php echo $product_img ?>" style="width: 200px; height: 180px;"></td>
                                <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['product_name'] ?></td>
                                <td class="col-4 text-center" style="vertical-align: middle;"><?= $row['product_description'] ?></td>
                                <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['price_per_unit'] ?> บาท</td>
                                <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['stock_qty'] ?></td>

                                <td class="col-3 text-center" style="vertical-align: middle;">
                                    <a href="add_stock.php?id=<?= $row['product_id'] ?>" class="btn btn-info">จัดการสต๊อก</a>
                                    <a href="edit_product.php?id=<?= $row['product_id'] ?>" class="btn btn-warning">แก้ไขข้อมูล</a>
                                    <a href="controller/delete_product.php?id=<?= $row['product_id'] ?>" class="btn btn-danger" onclick="del(this.href); return false;">ลบสินค้า</a>
                                </td>
                            </tr>

                        <?php
                        }
                        mysqli_close($conn);
                        ?>
                    </tbody>
                </table>
            </div>


        </div>
    </div>

</body>

</html>