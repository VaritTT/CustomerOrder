<?php
session_start();
require_once "../../config/connectDB.php";

if (!isset($_SESSION["customer_id"])) {
    if (isset($_POST['pick_qty']) && !empty($_POST['pick_qty'])) {
        $product_id = $_POST["product_id"];
        $_SESSION['product_id'] = $product_id;
    }
    die(header("Location: ../login.php"));
} else {
    if (isset($_POST['pick_qty']) && !empty($_POST['pick_qty'])) {
        $customer_id = $_SESSION["customer_id"];
        $product_id = $_POST["product_id"];
        $qty = $_POST["pick_qty"];

        $check_product_id = mysqli_query($conn, "SELECT COUNT(*) FROM cart WHERE customer_id = $customer_id AND product_id = $product_id");
        $row = mysqli_fetch_assoc($check_product_id);
        if ($row['COUNT(*)'] > 0) {
            $update_quantity = mysqli_query($conn, "UPDATE cart SET qty = qty + $qty WHERE customer_id = $customer_id AND product_id = $product_id");
        } else {
            mysqli_query($conn, "INSERT INTO cart (customer_id, product_id, qty) VALUES ($customer_id, $product_id, $qty)");
        }

        if (isset($_POST["purchase"])) {
            die(header("Location: ../cart.php"));
        } else if (isset($_POST['add'])) {
            die(header("Location: " . basename($_SERVER['HTTP_REFERER'])));
        }
    } else {
        die(header("Location: ../order.php"));
    }
}
