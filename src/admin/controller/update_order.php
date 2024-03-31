<?php
require_once '../../config/connectDB.php';
$ids = $_GET['id'];

$sql = "UPDATE order_header SET order_status_id = 1 WHERE order_id = '$ids'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('แก้ไขเป็นชำระเงินเรียบร้อยเสร็จสิ้น!')</script>";
    echo "<script>window.location='../report_order_paid.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถดำเนินการได้')</script>";
}

mysqli_close($conn);
