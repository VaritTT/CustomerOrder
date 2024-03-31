<?php
session_start();
require_once __DIR__ . '../../../vendor/autoload.php';
require_once "../../config/connectDB.php";
$mpdf = new \Mpdf\Mpdf([
    'default_font_size' => 14,
    'default_font' => 'sarabun'
]);

ob_start();  //ฟังก์ชัน ob_start()


$order_id = $_SESSION['order_id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .tax-header {
            font-weight: 600;
            font-size: 24px;
        }

        .table tr th,
        .table tr td {
            border: 1px solid #212121;
        }
    </style>
</head>

<body>
    <?php
    // รับส่วน head order
    $select_order = mysqli_query($conn, "SELECT * FROM order_header o,customer c WHERE o.order_id = '$order_id' AND o.customer_id = c.customer_id");
    $row = mysqli_fetch_array($select_order);

    $total_price = $row['total_price'];
    ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 mt-4">
                <div class="col-12 tax-header">
                    <p class="text-center">รายละเอียดสินค้า</p>
                </div>
                <div class="row">
                    <div class="col-6 mt-4 float-start">
                        <p class=""><b>บริษัท เทพกานต์สุดโหด จำกัด</b><br>
                            สถาบันเทคโนโลยีพระจอมเกล้าเจ้าคุณทหารลาดกระบัง<br>ถนนฉลองกรุง เขตลาดกระบัง กรุงเทพมหานคร<br>10520, ประเทศไทย<br>
                            โทร. 0 2329 8000<br>
                        </p>
                    </div>
                    <div class="col-6 mt-4 float-end">
                        <p class="text-center">
                            <b style="font-size: 24px; font-weight: 600;">ใบเสร็จรับเงิน/ใบกำกับภาษี</b><br>
                            e-Receipt/e-Tax Invoice<br>
                            <b>ต้นฉบับ</b>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6 float-start">
                        <p>
                            <b>ชื่อ-นามสกุล (ลูกค้า) : </b><?= $row['customer_name'] ?><br>
                            <b>ที่อยู่การจัดส่ง : </b><?= $row['addr'] ?><br>
                            <b>เบอร์โทรศัพท์ : </b><?= $row['tel'] ?><br>
                        </p>
                    </div>
                    <div class="col-6 float-end">
                        <div class="row">
                            <div class="col-3 float-start"></div>
                            <div class="col-9 float-end">
                                <p class="text-start">
                                    <b>เลขที่ใบออเดอร์สั่งซื้อ </b><?= $row['customer_name'] ?><br>
                                    <b>วันที่สั่งซื้อ </b><?= date('d-m-Y', strtotime($row['order_datetime'])) ?><br>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <br><br>
            </div>

            <div class="col">
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th class="col-1 text-center">รหัสสินค้า</th>
                            <th class="col-6 text-center">ชื่อสินค้า</th>
                            <th class="col-2 text-center">ราคาต่อหน่วย</th>
                            <th class="col-1 text-center">จำนวน</th>
                            <th class="col-1 text-center">ราคารวม</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // รับส่วน detail order
                        $sql1 = "SELECT * FROM order_detail d,product p WHERE d.product_id=p.product_id AND d.order_id = '$order_id' ";
                        $result1 = mysqli_query($conn, $sql1);

                        $sum_total = 0;

                        while ($row2 = mysqli_fetch_array($result1)) {
                            $sum_total = $row2["qty"] * $row2["price_per_unit"];
                        ?>
                            <tr class="text-center">
                                <td class="text-center"><?= $row2['product_id'] ?></td>
                                <td class="text-center"><?= $row2['product_name'] ?></td>
                                <td class="text-center"><?= $row2['price_per_unit'] ?></td>
                                <td class="text-center"><?= $row2['qty'] ?></td>
                                <td class="text-center"><?= number_format($sum_total, 2) ?> บาท</td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="col-12 mb-4">
                <div class="row">
                    <div class="col-4 mt-2 float-start">
                        <p class="text"><b>หมายเหตุ</b></p>
                        <p class="text"><b>ผู้ออกใบเสร็จ </b>บริษัท กานต์สุดโหด จำกัด<br></p>
                    </div>
                    <div class="col-8 mt-2 float-end">
                        <div class="col-12 row">
                            <div class="col-7 text-end float-start">
                                <p><b>รวมเป็นเงิน</b><br></p>
                                <p><b>ภาษีมูลค่าเพิ่ม 0% </b><br></p>
                                <p><b>จำนวนเงินทั้งสิ้น </b><br></p>
                            </div>
                            <div class="col-2 text-end float-start">
                                <p><?= number_format($total_price, 2) ?><br></p>
                                <p>0.00<br></p>
                                <p><?= number_format($total_price, 2) ?><br></p>
                            </div>
                            <div class="col-2 text-end float-start">
                                <p><b> บาท</b></p>
                                <p><b> บาท</b></p>
                                <p><b> บาท</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    // คำสั่งการ Export ไฟล์เป็น PDF
    $html = ob_get_contents();      // เรียกใช้ฟังก์ชัน รับข้อมูลที่จะมาแสดงผล
    $mpdf->WriteHTML($html);        // รับข้อมูลเนื้อหาที่จะแสดงผลผ่านตัวแปร $html
    $mpdf->Output('Report.pdf');  //สร้างไฟล์ PDF ชื่อว่า myReport.pdf
    die(header("Location: Report.pdf"));
    ob_end_flush();                 // ปิดการแสดงผลข้อมูลของไฟล์ HTML ณ จุดนี้
    ?>
    <center>
        <div class="button container">
            <div class="float-end mb-4">
                <a href="Report.pdf" class="btn btn-danger btn-lg">Export PDF</a>
            </div>
        </div>
    </center>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>