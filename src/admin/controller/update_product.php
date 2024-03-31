<?php
require_once '../../config/connectDB.php';

// รับค่ามา
$proid = $_POST['pid'];
$proname = $_POST['pname'];
$detail = $_POST['detail'];
$price = $_POST['price'];
$amount = $_POST['num'];
// $image = $_POST['pimage'];
$image_temp = $_FILES['pimage']['tmp_name'];
$image_data = file_get_contents($image_temp);

// $img=$_POST['txtimg'];

// upload photo
// if (is_uploaded_file($_FILES['file1']['tmp_name'])){
//     $new_image_name = 'pr_'.uniqid().".".pathinfo(basename($_FILES["file1"]["name"]), PATHINFO_EXTENSION);
//     $image_upload_path = "../img/".$new_image_name;
//     move_uploaded_file($_FILES["file1"]["tmp_name"], $image_upload_path);
// }else{
//     $new_image_name = "$img";
// }

// แก้ไขข้อมูล
$sql = "UPDATE product SET product_name=?, product_description=?, price_per_unit=?, stock_qty=?, product_image=? WHERE product_id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'ssdiss', $proname, $detail, $price, $amount, $image_data, $proid);
$result = mysqli_stmt_execute($stmt);
if ($result) {
    echo "<script>alert('แก้ไขข้อมูลใหม่เรียบร้อย');</script>";
    echo "<script>window.location='../product.php';</script>";
} else {
    echo "<script>alert('แก้ไขข้อมูลไม่สำเร็จ');</script>";
}
