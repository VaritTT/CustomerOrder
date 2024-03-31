<?php
session_start();
require_once '../config/connectDB.php';
require_once __DIR__ . '/../vendor/autoload.php';
$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 12,
    'default_font' => 'sarabun'
]);

ob_start();  //ฟังก์ชัน ob_start()

error_reporting(E_ERROR | E_PARSE);
$addition_sql_periods = "";

if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}

if ($_GET['period']) {
    $period = $_GET['period'];
    if ($period == "daily") {
        $addition_sql_periods = " DATE(order_datetime) = CURDATE()";
    } else if ($period == "weekly") {
        $addition_sql_periods = " MONTH(order_datetime) = MONTH(CURDATE())";
    } else if ($period == "monthly") {
        $addition_sql_periods = " order_datetime >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)";
    } else if ($period == "yearly") {
        $addition_sql_periods = " YEAR(order_datetime) = YEAR(CURDATE())";
    }
}
if (isset($_GET['order_status_id'])) {
    $order_status_id = $_GET['order_status_id'];
    $select_status_all = mysqli_query($conn, "SELECT * FROM order_header WHERE order_status_id = $order_status_id AND " . $addition_sql_periods);
    $select_status_name = mysqli_query($conn, "SELECT order_status_name FROM order_status WHERE order_status_id = $order_status_id");
    $row_status_name = mysqli_fetch_assoc($select_status_name);
} else {
    if ($_GET['period']) {
        $select_status_all = mysqli_query($conn, "SELECT * FROM order_header WHERE" . $addition_sql_periods);
    } else {
        $select_status_all = mysqli_query($conn, "SELECT * FROM order_header");
    }
}
date_default_timezone_set('Asia/Bangkok');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="container-fluid mt-4">
        <p class="fw-bold text-center">บริษัท ช้อปฟิล จำกัด (มหาชน)</p>
        <p class="fw-bold text-center">รายงานแสดง
            <?php
            if (isset($_GET['order_status_id'])) {
                echo 'สถานะการสั่งซื้อ "' . $row_status_name["order_status_name"] .  '"';
            } else {
                echo  'สถานะการสั่งซื้อ "' . "ทั้งหมด" .  '"';
            }
            ?>

            <?php
            if ($_GET['period']) {
                echo 'และแสดงระยะเวลา "' . $period .  '"';
            } else {
                echo  'และแสดงระยะเวลา"' . "ทั้งหมด" .  '"';
            }
            ?>
        </p>
        <p class="fw-bold text-center">ณ สิ้นวันที่ <?php echo date("d/m/Y"); ?>" </p>
    </div>


    <div class="col-12">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center align-middle" scope="col">วันที่และเวลาสั่งซื้อ</th>
                    <th class="text-center align-middle" scope="col">รหัสการสั่งซื้อ</th>
                    <th class="text-center align-middle" scope="col">รหัสลูกค้า</th>
                    <th class="text-center align-middle" scope="col">สถานที่จัดส่ง</th>
                    <th class="text-center align-middle" scope="col">ราคาการสั่งซื้อ (บาท)</th>
                    <th class="text-center align-middle" scope="col">สถานะการสั่งซื้อ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // if (isset($_GET['order_status_id'])) {
                //     $sql = "SELECT * FROM order_header WHERE order_status_id = $order_status_id ORDER BY order_datetime DESC";
                // } else {
                //     $sql = "SELECT * FROM order_header ORDER BY order_datetime DESC";
                // }
                // $result = mysqli_query($conn, $sql);
                $total_price_all = 0;
                while ($row = mysqli_fetch_array($select_status_all)) {
                    $status = $row['order_status_id'];
                ?>
                    <tr style="border: none;">
                        <td class="col-1 text-center" style="vertical-align: middle; border: none;"><?= $row['order_datetime'] ?></td>
                        <td class="col-1 text-center" style="vertical-align: middle; border: none;"><?= $row['order_id'] ?></td>
                        <td class="col-1 text-center" style="vertical-align: middle; border: none;"><?= $row['customer_id'] ?></td>
                        <td class="col-5 text-center" style="vertical-align: middle; border: none;"><?= $row['order_address'] ?></td>
                        <td class="col-1 text-center" style="vertical-align: middle; border: none;"><?= $row['total_price'] ?></td>
                        <td class="col-1 text-center" style="vertical-align: middle; border: none;">
                            <?php
                            if ($status == 1) {
                                echo "<b style='color:green'>ชำระแล้ว<b>";
                            } else if ($status == 2) {
                                echo "ยังไม่ชำระเงิน";
                            } else if ($status == 3) {
                                echo "<b style='color:red'>ยกเลิกการสั่งซื้อ<b>";
                            }
                            $total_price_all += $row['total_price'];
                            ?>
                        </td>
                    </tr>

                <?php
                }
                mysqli_close($conn);
                ?>
                <tr style="height: 100px; border: none;">
                    <td class="col-1 text-center" style="border: none;"></td>
                    <td class="col-1 text-center" style="border: none;"></td>
                    <td class="col-1 text-center" style="border: none;"></td>
                    <td class="col-3 text-end" style="vertical-align: middle; border: none;">รวมเป็นเงินทั้งหมด</td>
                    <td class="col-1 text-center" style="vertical-align: middle; border: none; text-decoration-line: underline; text-decoration-style: double;"><?php echo number_format($total_price_all, 2); ?></td>
                    <td class="col-1 text-center" style="border: none;"></td>
                </tr>
            </tbody>
        </table>
    </div>
    <?php
    $html = ob_get_contents(); // เรียกใช้ฟังก์ชัน รับข้อมูลที่จะมาแสดงผล
    $mpdf->WriteHTML($html); // รับข้อมูลเนื้อหาที่จะแสดงผลผ่านตัวแปร $html
    $mpdf->Output('Report.pdf'); //สร้างไฟล์ PDF ชื่อว่า myReport.pdf
    die(header("Location: Report.pdf"));
    ob_end_flush(); // ปิดการแสดงผลข้อมูลของไฟล์ HTML ณ จุดนี้
    ?>

    <center>
        <div class="button container">
            <div class="float-end mb-4">
                <a href="Report.pdf" class="btn btn-danger btn-lg">Export PDF</a>
                <a href="order.php" class="btn btn-warning btn-lg">Back</a>
            </div>
        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>