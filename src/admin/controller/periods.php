<?php
session_start();
require_once '../../config/connectDB.php';
unset($_SESSION['periods_name']);
unset($_SESSION['periods_sql']);
$order_status_id = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['order_status_id'])) {
        $order_status_id = $_POST['order_status_id'];
    }
    if (isset($_POST['all'])) {
        die(header("Location: " . $_SERVER['HTTP_REFERER']));
    } else if (isset($_POST['daily'])) {
        $period = $_POST['daily'];
        $period_name = 'daily';
        $sql = "SELECT * FROM order_header WHERE DATE(order_datetime) = CURDATE()";
    } else if (isset($_POST['weekly'])) {
        $period = $_POST['weekly'];
        $period_name = 'weekly';
        $sql = "SELECT * FROM order_header WHERE MONTH(order_datetime) = MONTH(CURDATE()) ";
    } else if (isset($_POST['monthly'])) {
        $period = $_POST['monthly'];
        $period_name = 'monthly';
        $sql = "SELECT * FROM order_header WHERE order_datetime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) ";
    } else if (isset($_POST['yearly'])) {
        $period = $_POST['yearly'];
        $period_name = 'yearly';
        $sql = "SELECT * FROM order_header WHERE YEAR(order_datetime) = YEAR(CURDATE()) ";
    }
    $_SESSION['periods_name'] = $period_name;
    $_SESSION['periods_sql'] = $sql;
    die(header("Location: " . $_SERVER['HTTP_REFERER']));
    exit();
}
