<?php
session_start();
require_once "../../config/connectDB.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['checkout'])) {
        if (isset($_POST['pick_product_id_array_checked']) && is_array($_POST['pick_product_id_array_checked'])) {
            $pick_product_id_array_checked = $_POST["pick_product_id_array_checked"];
            $pick_product_id_array_uncheck = $_POST["pick_product_id_array_uncheck"];
            $pick_qty_array = $_POST["pick_qty_array"];
            $_SESSION['pick_product_id_array_checked'] = $pick_product_id_array_checked;
            $_SESSION['id_qty_combined'] = array_combine($pick_product_id_array_uncheck, $pick_qty_array);
            die(header("Location: ../checkout.php"));
        } else {
            echo "<script>alert(\"You don't choose any product\"); window.location.href = '../cart.php';</script>";
        }
    } else if (isset($_POST["action"])) {
        $action = $_POST["action"];
        if ($action == "update") {
            echo "updateaskjsa";
            $product_id = $_POST['product_id'];
            $pick_qty = $_POST['pick_qty'];

            $update_query = mysqli_query($conn, "UPDATE cart SET qty = $pick_qty WHERE product_id = $product_id");

            if ($update_query) {
                echo "อัปเดตข้อมูลเรียบร้อยแล้ว";
            } else {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
            }
        } else if ($action == 'delete') {
            $product_id = $_POST['product_id'];
            $customer_id = $_POST['customer_id'];

            $delete_query = mysqli_query($conn, "DELETE FROM cart WHERE product_id = $product_id AND customer_id = $customer_id");
            if ($delete_query) {
                echo "Delete ข้อมูลเรียบร้อยแล้ว";
            } else {
                echo "เกิดข้อผิดพลาดในการ Delete ข้อมูล";
            }
        }
    }
}
