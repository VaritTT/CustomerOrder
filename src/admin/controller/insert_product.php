<?php
require_once '../../config/connectDB.php';

// รับค่า
$p_id = $_POST['pid'];
$p_name = $_POST['pname'];
$detail = $_POST['detail'];
$typeID = $_POST['typeID'];
$price = $_POST['price'];
$num = $_POST['amount'];

// upload photo
// if (is_uploaded_file($_FILES['file1']['tmp_name'])){
//     $new_image_name = 'pr_'.uniqid().".".pathinfo(basename($_FILES["file1"]["name"]), PATHINFO_EXTENSION);
//     $image_upload_path = "../img/".$new_image_name;
//     move_uploaded_file($_FILES["file1"]["tmp_name"], $image_upload_path);
// }else{
//     $new_image_name = "";
// }

// เพิ่มสินค้า
$sql = "INSERT INTO product(product_name,product_description,price_per_unit,stock_qty) VALUES ('$p_name','$detail','$price','$num')";
$result = mysqli_query($conn, $sql);
if ($result) {
    echo "<script>alert('บันทึกข้อมูลสินค้าเพิ่มลงไปเรียบร้อย');</script>";
    echo "<script>window.location='../product.php';</script>";
} else {
    echo "<script>alert('บันทึกรายการสินค้าไม่สำเร็จ');</script>";
}
