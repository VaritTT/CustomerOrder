<?php
session_start();
require_once "../../config/connectDB.php";

$countLimit_login = 5;
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = mysqli_query($conn, "SELECT * FROM customer WHERE username = '$username'");

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['lock_account'] == 1) {
            echo "<script>alert('บัญชีของคุณถูกระงับ\\nบัญชีของคุณจะถูกระงับเป็นเวลา $ban_time นาที เพราะผู้ใช้กรอกรหัสผิดเกิน {$row['count_login']} ครั้ง\\nบัญชีนี้จะถูกปลดจากการระงับเมื่อเวลา {$row['ban_datetime']}');</script>";
            echo "<script>window.location.href = '../login.php';</script>";
        } else if (password_verify($password . $row['password_salting'], $row['password'])) {
            $reset_count_login = mysqli_query($conn, "UPDATE customer SET count_login = 0 WHERE username = '$username'");
            $_SESSION["customer_id"] = $row["customer_id"];
            $_SESSION["username"] = $username;
            if ($row["user_type"] == "user") {
                $_SESSION['customer_id'] = $row['customer_id'];
                $_SESSION['user_type'] = $row['user_type'];
                header("Location: ../homepage_customer.php");
            } else if ($row["user_type"] == "admin") {
                $_SESSION['customer_id'] = $row['customer_id'];
                $_SESSION['user_type'] = $row['user_type'];
                header("Location: ../../admin/report_order_all.php");
            }
            if (isset($_SESSION['product_id'])) {
                $product_id = $_SESSION['product_id'];
                unset($_SESSION['product_id']);
                die(header("Location: ../product.php?id=$product_id"));
            }
        } else {
            $update_count_login = mysqli_query($conn, "UPDATE customer SET count_login = count_login + 1 WHERE username = '$username'");
            if ($row['count_login'] + 1 >= $countLimit_login) {
                $update_ban = mysqli_query($conn, "UPDATE customer SET lock_account = 1, ban_datetime = DATE_ADD(NOW(), INTERVAL $ban_time MINUTE) WHERE username = '$username'");
                echo "<script>alert('บัญชีของคุณถูกระงับ\\nบัญชีของคุณจะถูกระงับเป็นเวลา $ban_time นาที เพราะผู้ใช้กรอกรหัสผิดเกิน {$row['count_login']} ครั้ง\\nบัญชีนี้จะถูกปลดจากการระงับเมื่อเวลา {$row['ban_datetime']}');</script>";
                echo "<script>window.location.href = '../login.php';</script>";
            }
            $_SESSION['err_msg'] = "Invalid username or password."; // ไม่เจอ password
            header("Location: ../login.php");
        }
    } else {
        $_SESSION['err_msg'] = "Invalid username or password."; // ไม่เจอ username
        header("Location: ../login.php");
    }
}
