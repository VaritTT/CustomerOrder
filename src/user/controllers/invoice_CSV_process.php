<?php
session_start();
require_once "../../config/connectDB.php";


$order_id = $_SESSION['order_id'];

$csv_filename = "order_$order_id.csv";
$f = fopen('php://memory', 'w');
fputs($f, chr(0xEF) . chr(0xBB) . chr(0xBF));

$csv_header = array('Customer ID', 'Place on', 'Total Price');
fputcsv($f, $csv_header, ",");

$select_order_header = mysqli_query($conn, "SELECT * FROM order_header WHERE order_id = $order_id");
$row = mysqli_fetch_assoc($select_order_header);
$csv_data = array($row['customer_id'], $row['order_datetime'], $row['total_price']);
fputcsv($f, $csv_data, ",");

$csv_header = array('Order ID', 'Product ID', 'Product Name', 'Price Per Unit', 'Quantity', 'Total Price');
fputcsv($f, $csv_header, ",");

$select_order_detail = mysqli_query($conn, "SELECT * FROM order_detail WHERE order_id = $order_id");
while ($row = mysqli_fetch_assoc($select_order_detail)) {
    $detail_id = $row['detail_id'];
    $product_id = $row['product_id'];
    $qty = $row['qty'];
    $select_picked_product = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id");
    $row1 = mysqli_fetch_assoc($select_picked_product);
    $product_image = base64_encode($row1['product_image']);
    $product_name = $row1['product_name'];
    $product_description = $row1['product_description'];
    $product_price_per_unit = intval($row1['price_per_unit']);
    $product_price_total = $product_price_per_unit * $qty;

    $csv_data = array($order_id, $product_id, $product_name, $product_price_per_unit, $qty, $product_price_total);
    fputcsv($f, $csv_data, ",");
}

fseek($f, 0);

header('Content-type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $csv_filename . '"');

fpassthru($f);
