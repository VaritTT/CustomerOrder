<?php
session_start();
require_once '../config/connectDB.php';
$order_ids = $_GET['id'];
if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายการสั่งซื้อ</title>

    <!-- link css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>


</head>

<body>
    <?php
    // รับส่วน head order
    $sql = "SELECT * FROM order_header o,customer c WHERE o.order_id = '$order_ids' AND o.customer_id = c.customer_id";
    $result = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_array($result);

    $total_price = $row1['total_price'];
    $status = $row1['order_status_id'];
    ?>

    <?php
    // รับส่วน detail order
    $sql1 = "SELECT * FROM order_detail d,product p WHERE d.product_id=p.product_id AND d.order_id = '$order_ids' ";
    $result1 = mysqli_query($conn, $sql1);
    ?>

    <div class="container">
        <div class="row mb-4">
            <div class="col-12 mt-4">
                <div class="col-12">
                    <p class="text-center" style="font-weight: 600; font-size: 24px;">
                        รายละเอียดสินค้า
                        <?php
                        if ($status == 1) {
                            echo "<b> (ชำระแล้ว)<b>";
                        } else if ($status == 2) {
                            echo "<b> (ยังไม่ชำระเงิน)<b>";
                        } else if ($status == 3) {
                            echo "<b> (ยกเลิกการสั่งซื้อ)<b>";
                        }
                        ?>
                    </p>
                </div>
                <div class="row">
                    <div class="col-6 mt-4">
                        <p>
                            <b>ชื่อ-นามสกุล (ลูกค้า) : </b><?= $row1['customer_name'] ?><br>
                            <b>ที่อยู่การจัดส่ง : </b><?= $row1['addr'] ?><br>
                            <b>เบอร์โทรศัพท์ : </b><?= $row1['tel'] ?><br>
                        </p>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-9">
                                <p class="text-start m-4">
                                    <b>เลขที่ใบออเดอร์สั่งซื้อ </b><?= $row1['order_id'] ?><br>
                                    <b>วันที่สั่งซื้อ </b><?= date('d-m-Y', strtotime($row1['order_datetime'])) ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>
            </div>

            <div class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>รหัสสินค้า</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคาต่อหน่วย</th>
                            <th>จำนวน</th>
                            <th>ราคารวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        $sum_total = 0;

                        while ($row2 = mysqli_fetch_array($result1)) {
                            $sum_total = $row2["qty"] * $row2["price_per_unit"];
                        ?>
                            <tr>
                                <td><?= $row2['product_id'] ?></td>
                                <td><?= $row2['product_name'] ?></td>
                                <td><?= $row2['price_per_unit'] ?></td>
                                <td><?= $row2['qty'] ?></td>
                                <td><?= number_format($sum_total, 2) ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-6 mt-4">
                        <p class="text" style="vertical-align: middle;"><b>หมายเหตุ</b><br></p>
                        <p class="text" style="vertical-align: middle;"><b>ผู้ออกใบเสร็จ </b>บริษัท ช้อปฟิล จำกัด<br></p>
                    </div>
                    <div class="col-6 mt-4">
                        <div class="row">
                            <div class="col-2"></div>
                            <div class="col-4">
                                <p><b>รวมเป็นเงิน</b><br></p>
                                <p><b>ภาษีมูลค่าเพิ่ม 0% </b><br></p>
                                <p><b>จำนวนเงินทั้งสิ้น </b><br></p>
                            </div>
                            <div class="col-2 text-center">
                                <p><?= number_format($total_price, 2) ?><br></p>
                                <p>0.00<br></p>
                                <p><?= number_format($total_price, 2) ?><br></p>
                            </div>
                            <div class="col-4 text-start">
                                <p><b> บาท</b></p>
                                <p><b> บาท</b></p>
                                <p><b> บาท</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <center>
        <div class="button">
            <a href="report_order_all.php" class="btn btn-danger">Back To Order</a>
            <a href="Report.pdf" class="btn btn-warning">Export PDF</a>
        </div>
    </center>

</body>

</html>