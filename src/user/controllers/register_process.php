<?php
session_start();
require_once "../../config/connectDB.php";

$minLength = 8;
if (isset($_POST['register'])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];
    $default_profile = "../../assets/img/default_profile.jpg";
}

if (empty($username)) {
    $_SESSION["error"] = "Please enter your username.";
    die(header("location: ../register.php"));
} else {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM customer WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if ($row[0] > 0) {
        $_SESSION['error'] = "Username already exists.";
        die(header("Location: ../register.php"));
    }
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION["error"] = "Please enter a valid email address.";
    die(header("location: ../register.php"));
} else {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM customer WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if ($row[0] > 0) {
        $_SESSION['error'] = "Email already exists.";
        die(header("Location: ../register.php"));
    }
}

if (strlen($password) < $minLength) {
    $_SESSION["error"] = "Your password must have at least 8 letters.";
    die(header("location: ../register.php"));
} else if (!preg_match('/[0-9]/', $password)) {
    $_SESSION["error"] = "Your password must contain at least 1 number letter.";
    die(header("location: ../register.php"));
} else if (!preg_match('/[a-z]/', $password)) {
    $_SESSION["error"] = "Your password must contain at least 1 lowercase letter.";
    die(header("location: ../register.php"));
} else if (!preg_match('/[A-Z]/', $password)) {
    $_SESSION["error"] = "Your password must contain at least 1 uppercase letter.";
    die(header("location: ../register.php"));
} else if (!preg_match('/[^A-Za-z0-9]/', $password)) {
    $_SESSION["error"] = "Your password must contain at least 1 special character.";
    die(header("location: ../register.php"));
}
if ($password !== $confirmPassword) {
    $_SESSION["error"] = "Your password do not match.";
    die(header("location: ../register.php"));
} else {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM customer WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result);
    if ($row[0] > 0) {
        $_SESSION['error'] = "Username already exists.";
        die(header("Location: ../register.php"));
    } else {
        $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM customer WHERE email = ?");
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if ($row[0] > 0) {
            $_SESSION['errEmail_msg'] = "Email already exists.";
            header("Location: ../register.php");
        } else {
            $length = random_int(97, 128);
            // random_byte คือการสุ่ม byte ที่แทนค่า 0-255 ออกมาเป็น unicode 
            // bin2hex คือการเปลี่ยนจากฐาน 2 เป็น 16
            // ตัวอย่าง สมมติว่าสุ่มได้ 4 byte = 32 bit = 8 ตัวอักษรในฐาน 16
            // แล้วเอาไปต่อกับ password จะเป็นการ hash + salt
            $salt_account = bin2hex(random_bytes($length));
            $password = $password . $salt_account;
            $algo = PASSWORD_ARGON2ID; // วิธีการ hash แบบ Argon2ID
            $options = [
                'cost' => PASSWORD_ARGON2_DEFAULT_MEMORY_COST,
                'time_cost' => PASSWORD_ARGON2_DEFAULT_TIME_COST,
                'threads' => PASSWORD_ARGON2_DEFAULT_THREADS
            ];
            $password_hash_salt = password_hash($password, $algo, $options);
            $query_create_account = "INSERT INTO customer (username, email, password, password_salting, image_profile) VALUES ('$username', '$email', '$password_hash_salt', '$salt_account', '$default_profile')";
            $call_back_craete_account = mysqli_query($conn, $query_create_account);
            if ($call_back_craete_account) {
                echo "<script>alert('Your account has been successfully created. Please log in to continue.');</script>";
                echo "<script>window.location.href = '../login.php';</script>";
            } else {
                echo "<script>window.location.href = '../register.php';</script>";
            }
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
