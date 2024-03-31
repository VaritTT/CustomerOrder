<?php
session_start();
require_once "../config/connectDB.php";

$order_id = $_SESSION['order_id'];
$select_order_header = mysqli_query($conn, "SELECT * FROM order_header WHERE order_id = $order_id");
$row = mysqli_fetch_assoc($select_order_header);
$customer_id = $row['customer_id'];
$order_status_id = $row['order_status_id'];
if ($row['order_address'] == NULL) {
    $order_address = $_SESSION['addr'];
} else {
    $order_address = $row['order_address'];
}
$order_datetime = $row['order_datetime'];
$total_price = $row['total_price'];
?>

<html>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Receipt</title>
    <style>
        .container-receipt {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
        }

        .table-container {
            margin: 0 auto;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .header-info h3 {
            padding: 10px;
        }

        .header-info img {
            width: 100px;
            height: 100px;
        }

        .header-info h3 {
            margin: 0;
            padding: 10px;
        }

        .order-header {
            margin-bottom: 20px;
        }

        .order-detail table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-detail table tr:first-child {
            font-weight: bold;
        }

        .order-detail table th,
        .order-detail table td {
            padding: 8px;
        }

        .order-detail table th {
            background-color: #4CAF50;
            color: white;
        }

        .order-content img {
            max-width: 100px;
            max-height: 100px;
        }

        .order-summary {
            text-align: right;
            margin-top: 20px;
        }

        .order-summary div {
            margin-bottom: 5px;
        }

        .create-btn {
            display: flex;
            justify-content: flex-end;
        }

        .download-pdf-btn {
            width: 150px;
            padding: 10px;
            text-align: center;
            background-color: #FF0000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 1rem;
        }

        .download-pdf-btn:hover {
            background-color: #CC0000;
        }


        .download-csv-btn {
            width: 150px;
            padding: 10px;
            text-align: center;
            background-color: #008000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .download-csv-btn:hover {
            background-color: #006600;
        }

        .product-image img {
            width: 100px;
            height: 100px;
        }
    </style>
</head>

<body>
    <?php include './menu_user.php'; ?>

    <div class='container container-receipt'>
        <header class='header-info'>
            <img src='../assets/img/logo_original.png'>
            <div class="btn btn-info">
                <h3>ใบเสร็จรับเงิน<br>Receipt</h3>
            </div>
        </header>
        <main>
            <header class='order-header'>
                <div>Name: <?php echo $_SESSION['customer_name'] ?></div>
                <div>Tel: <?php echo $_SESSION['tel'] ?> </div>
                <div>Address: <?php echo $order_address ?></div>
            </header>
            <section class='order-detail'>
                <table class='table-container'>
                    <tr>
                        <!-- <td>รูปภาพ</td> -->
                        <td>รายการ</td>
                        <td>ราคาต่อหน่วย</td>
                        <td>จำนวน</td>
                        <td>ราคารวม</td>
                    </tr>

                    <?php
                    $select_order_detail = mysqli_query($conn, "SELECT * FROM order_detail WHERE order_id = $order_id");
                    $count = 1;
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
                    ?>
                        <tr class='order-content'>
                            <td><?php echo $product_name ?></td>
                            <td>฿<?php echo $product_price_per_unit ?></td>
                            <td><?php echo $qty ?></td>
                            <td>฿<?php echo $product_price_total ?></td>
                        </tr>
                    <?php
                        $count++;
                    }
                    ?>
                    <div>Order <?php echo $order_id ?></div>
                    <div>Placed on <?php echo $order_datetime ?></div>
            </section>
            </table>
            <div class='order-summary'>
                <div>จำนวนเงินรวม: ฿<?php echo $total_price ?></div>
            </div>
        </main>
        <div class='create-btn'>
            <a href='./controllers/invoice_PDF_process.php' class='btn btn-danger download-pdf-btn'>Download PDF</a>
            <a href='./controllers/invoice_CSV_process.php' class='btn btn-success download-csv-btn'>Download CSV</a>
        </div>
    </div>
</body>

</html>