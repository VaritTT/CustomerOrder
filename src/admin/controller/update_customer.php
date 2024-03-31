<?php
require_once '../../config/connectDB.php';

// รับค่ามา
$cid = $_POST['cid'];
$cname = $_POST['cname'];
$sex = $_POST['sex'];
$addr = $_POST['addr'];
$tel = $_POST['tel'];
$bdate = $_POST['bdate'];
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
$sql = "UPDATE customer SET customer_name='$cname',sex='$sex',addr='$addr',tel='$tel',birthDate='$bdate' WHERE customer_id = '$cid'";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<script>alert('แก้ไขข้อมูลใหม่เรียบร้อย');</script>";
    echo "<script>window.location='../customer.php';</script>";
} else {
    echo "<script>alert('แก้ไขข้อมูลไม่สำเร็จ');</script>";
}
