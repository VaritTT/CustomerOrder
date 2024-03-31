<?php
require_once '../../config/connectDB.php';

$ids = $_POST['pid'];
$nums = $_POST['pnum'];

$sql = "UPDATE product SET stock_qty = stock_qty + $nums WHERE product_id = '$ids'";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<script>alert('อัพเดตข้อมูลสำเร็จ...');</script>";
    echo "<script>window.location='../product.php';</script>";
} else {
    echo "<script>alert('ไม่สามารถอัพเดตข้อมูลได้สำเร็จ...');</script>";
}
