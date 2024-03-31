<?php
require_once '../../config/connectDB.php';
$ids = $_GET['id'];

$sql = "UPDATE order_header SET order_status_id = 4 WHERE order_id = '$ids'";
$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('ยกเลิกใบสั่งซื้อเสร็จเรียบร้อย')</script>";
    echo "<script>window.location='../report_order_cancel.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถดำเนินการลบได้')</script>";
}

mysqli_close($conn);
