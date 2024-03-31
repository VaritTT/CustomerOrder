<?php
require_once '../../config/connectDB.php';

$ids = $_GET['id'];
$sql = "DELETE FROM product WHERE product_id='$ids'";

if ($result = mysqli_query($conn, $sql)) {
    echo "<script>alert('ลบข้อมูลสำเร็จ');</script>;";
    echo "<script>window.location='../product.php';</script>;";
} else {
    echo "Error : " . $sql . "<br>" . mysqli_error($conn);
    echo "<script>alert('ลบข้อมูลไม่สำเร็จ');</script>;";
}
mysqli_close($conn);
