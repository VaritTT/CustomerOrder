<?php
session_start();
require_once "../../config/connectDB.php";

if (isset($_POST['place_order'])) {
    $customer_id = $_SESSION['customer_id'];
    $ship_addr = $_SESSION['addr'];
    // $select_picked_product_stock = mysqli_query($conn, "SELECT * FROM product WHERE product_id IN ($productIndex)");
    // $insert_picked_order_header = mysqli_query($conn, "INSERT INTO order_header (customer_id, order_datetime, order_address) VALUES ($customer_id, NOW(), $ship_addr)");
    $insert_picked_order_header = mysqli_query($conn, "INSERT INTO order_header (customer_id, order_status_id, order_datetime) VALUES ($customer_id, 1, NOW())");
    // while ($row = mysqli_fetch_assoc($select_picked_product_stock)) {
    //     $product_id = $row['product_id'];
    //     $product_name = $row['product_name'];
    //     $product_description = $row['product_description'];
    //     $product_picked_qty = $id_qty_combined[$product_id];
    //     $product_price_per_unit = $row['price_per_unit'];
    //     $product_price_total = $product_price_per_unit * $product_picked_qty;

    $order_id = mysqli_insert_id($conn); // mysqli_insert_id จะเอาค่า id ที่ query ไปล่าสุดออกมา 
    $_SESSION['order_id'] = $order_id; // mysqli_insert_id จะเอาค่า id ที่ query ไปล่าสุดออกมา 
    $product_price_total = 0;

    foreach ($_SESSION['pick_product_id_array_checked'] as $product_id) {
        $product_qty = $_SESSION['id_qty_combined'][$product_id];
        $select_product_info = mysqli_query($conn, "SELECT price_per_unit FROM product WHERE product_id = $product_id");
        $row = mysqli_fetch_assoc($select_product_info);
        $product_price_per_unit = $row['price_per_unit'];

        $insert_order_detail = mysqli_query($conn, "INSERT INTO order_detail (order_id, product_id, qty) VALUES ($order_id, $product_id, $product_qty)");

        $product_price_total += $product_qty * $product_price_per_unit;
    }

    $update_total_price = mysqli_query($conn, "UPDATE order_header SET total_price = $product_price_total WHERE order_id = $order_id AND customer_id = $customer_id");
    die(header("Location: ../receipt.php"));
}
