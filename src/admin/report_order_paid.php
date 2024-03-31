<?php
session_start();
require_once '../config/connectDB.php';
$order_status_id = 1;
$periods_name = "";

if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM order_header WHERE order_status_id = $order_status_id AND CONCAT(order_id,customer_id,order_address) LIKE '%$search%' ORDER BY order_id";
} else if (isset($_SESSION['periods_sql'])) {
    if (isset($_SESSION['periods_name'])) {
        $periods_name = $_SESSION['periods_name'];
    }
    $sql = $_SESSION['periods_sql'] . " AND order_status_id = $order_status_id ORDER BY order_datetime DESC";
} else {
    $sql = "SELECT * FROM order_header WHERE order_status_id = $order_status_id ORDER BY order_datetime DESC";
}
$result = mysqli_query($conn, $sql);
$row_count = mysqli_num_rows($result)
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Report All</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <!-- menu -->
    <?php
    include 'menu.php';
    include 'dash.php';
    ?>

    <div class="col-12 mt-5 mb-4 text-center">
        <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <a href="report_order_all.php" class="btn btn-outline-info">ทั้งหมด</a>
            <a href="report_order_paid.php" class="btn btn-outline-info active">ชำระเงินแล้ว</a>
            <a href="report_order_unpaid.php" class="btn btn-outline-info">ยังไม่ได้ชำระ</a>
            <a href="report_order_cancel.php" class="btn btn-outline-info">ยกเลิกการซื้อ</a>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <div class="d-flex">
            <h4 style="font-weight: 600;">รายงานการสั่งซื้อ(ที่ชำระแล้ว) <?php echo $periods_name; ?> <span class="badge text-bg-success"><?php echo $row_count . "/" . $order1; ?></span></h4>
            <div class="dropdown ms-4">
                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">ระยะเวลา</button>
                <form method="POST" action="controller/periods.php">
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <input type="hidden" name="order_status_id" value="<?php $order_status_id ?>">
                        <li><button class="dropdown-item" name="all" value="all">ทั้งหมด</button></li>
                        <li><button class="dropdown-item" name="daily" value="daily">รายวัน</button></li>
                        <li><button class="dropdown-item" name="weekly" value="weekly">รายสัปดาห์</button></li>
                        <li><button class="dropdown-item" name="monthly" value="monthly">รายเดือน</button></li>
                        <li><button class="dropdown-item" name="yearly" value="yearly">รายปี</button></li>
                    </ul>
                </form>
            </div>
        </div>

        <div class="text-end">
            <?php if (isset($_SESSION['periods_name'])) { ?>
                <a href="report_order_yes.php?order_status_id=<?php echo $order_status_id ?>&period=<?= $periods_name ?>"><button class="btn btn-warning" type="button">Export PDF</button></a>
            <?php } else { ?>
                <a href="report_order_yes.php?order_status_id=<?php echo $order_status_id ?>"><button class="btn btn-warning" type="button">Export PDF</button></a>
            <?php } ?>
        </div>

    </div>

    <form class="d-flex mt-4" role="search" action="" method="">
        <input class="form-control me-2" type="text" placeholder="ค้นหาออเดอร์ที่คุณต้องการ" name="search" aria-label="Search" value="<?php if (isset($_GET['search'])) {
                                                                                                                                            echo $_GET['search'];
                                                                                                                                        } ?>">
        <button class="btn btn-info" type="submit">Search</button>
    </form>

    <div class="col-12 mt-4">
        <table class="table table-striped">

            <thead>
                <tr>
                    <th class="text-center" scope="col">ออเดอร์</th>
                    <th class="text-center" scope="col">รหัสลูกค้า</th>
                    <th class="text-center" scope="col">ที่อยู่จัดส่งสินค้า</th>
                    <th class="text-center" scope="col">วันที่สั่งซื้อ</th>
                    <th class="text-center" scope="col">ราคารวม</th>
                    <th class="text-center" scope="col">สถานะสั่งซื้อ</th>
                    <th class="text-center" scope="col">ดำเนินการ</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $status = $row['order_status_id'];
                ?>
                    <tr>
                        <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['order_id'] ?></td>
                        <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['customer_id'] ?></td>
                        <td class="col-4 text-center" style="vertical-align: middle;"><?= $row['order_address'] ?></td>
                        <td class="col-2 text-center" style="vertical-align: middle;"><?= $row['order_datetime'] ?></td>
                        <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['total_price'] ?></td>
                        <td class="col-2 text-center" style="vertical-align: middle;">
                            <?php
                            if ($status == 1) {
                                echo "<b style='color:green'>ชำระแล้ว<b>";
                            } else if ($status == 2) {
                                echo "ยังไม่ชำระเงิน";
                            } else if ($status == 3) {
                                echo "<b style='color:red'>ยกเลิกการสั่งซื้อ<b>";
                            }
                            ?>
                        </td>
                        <td class="col-1 text-center" style="vertical-align: middle;">
                            <?php if (isset($_SESSION['periods_sql'])) { ?>
                                <a href="report_order_detail.php?id=<?= $row['order_id'] ?>" class="btn btn-info">แสดงข้อมูล</a>
                            <?php } else { ?>
                                <a href="report_order_detail.php?id=<?= $row['order_id'] ?>" class="btn btn-info">แสดงข้อมูล</a>
                            <?php } ?>
                        </td>
                    </tr>

                <?php
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>


    </div>
    </div>

</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    function del(mypage) {
        var agree = confirm('คุณต้องการยกเลิกใบสั่งซื้อนี้ใช่หรือไม่');
        if (agree) {
            window.location = mypage;
        }
    }

    function upd(mypage) {
        var agree = confirm('คุณต้องการปรับสถานะการชำระเงินใช่หรือไม่');
        if (agree) {
            window.location = mypage;
        }
    }
</script>