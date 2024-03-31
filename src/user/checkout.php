<?php
session_start();
require_once "../config/connectDB.php";

$select_info = mysqli_query($conn, "SELECT customer_name, addr, tel FROM customer WHERE customer_id = $_SESSION[customer_id]");
$row = mysqli_fetch_assoc($select_info);
$_SESSION['customer_name'] = $row['customer_name'];
$_SESSION['addr'] = $row['addr'];
$_SESSION['tel'] = $row['tel'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        .container-checkout {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .address-box {
            padding: 1rem;
        }

        .address-content {
            margin-top: 0.5rem;
            display: flex;
        }

        .address-content p {
            margin-left: 1rem;
        }

        .product-picked-header {
            display: flex;
            align-items: center;
            background-color: #fff;
            padding: 20px 0;
        }

        .header-detail h2 {
            padding-left: 1rem;
        }

        .product-detail {
            display: flex;
            text-align: center;
        }

        .product-detail div {
            padding: 0 1rem;
        }

        .product-detail .product-name {
            align-items: center;
        }

        .product-detail .product-description {
            line-height: 1.5em;
            flex: 8;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .header-detail,
        .product-detail {
            flex: 5;
        }

        .product-image {
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            margin-left: 1rem;
        }

        .product-name {
            flex: 1;
            min-width: 40px;
        }

        .product-picked-content {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            background-color: #fff;
        }

        .place-order-btn {
            margin-right: 8px;
            width: 120px;
            height: 50px;
            background: #4CAF50;
            border: none;
            outline: none;
            cursor: pointer;
            text-align: center;
            float: right;
            transition: background-color 0.3s ease;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);
        }

        .place-order-btn:hover {
            color: white;
            background-color: #45a049;
        }

        .header-price-per-unit,
        .header-picked-qty,
        .header-price-total,
        .product-price-per-unit,
        .product-picked-qty,
        .product-price-total {
            flex: 1;
            text-align: center;
        }

        .checkout-footer {
            background-color: #fff;
            width: inherit;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            align-items: flex-end;
            padding: 0 2rem;

        }

        .checkout-footer div {
            padding-bottom: 1rem;
        }

        .checkout-footer .place-order-btn-container {
            width: 100%;
            border-top: 1px solid #f0f0f0;
            padding: 1rem 0;
        }
    </style>
</head>

<body>
    <?php include './menu_user.php'; ?>

    <div class="container container-checkout">
        <div class="address-box">
            <h1>Delivery Address</h1>
            <div class="address-content">
                <h4><?php echo $_SESSION['customer_name'] . " (" . $_SESSION['tel'] . ")"  ?></h4>
                <p><?php echo $_SESSION['addr'] ?></p>
            </div>
        </div>
        <div class="product-picked">
            <div class="product-picked-header">
                <div class="header-detail">
                    <h2>Product Detail</h2>
                </div>
                <div class="header-price-per-unit">Unit Price</div>
                <div class="header-picked-qty">Amount</div>
                <div class="header-price-total">Item Subtotal</div>
            </div>
            <?php
            $pick_product_id_array_checked = $_SESSION['pick_product_id_array_checked'];
            $id_qty_combined = $_SESSION['id_qty_combined'];
            $product_id_picked_all = implode(',', $pick_product_id_array_checked); // จะได้ออกมาเป็น 2,3,4,5 เอาไปใช้ WHERE IN ใน SQL
            $_SESSION['product_id_picked_all'] = $product_id_picked_all;
            $result = mysqli_query($conn, "SELECT * FROM product WHERE product_id IN ($product_id_picked_all)");
            $count = 0;
            $total_price = 0.00;
            while ($row = mysqli_fetch_assoc($result)) {
                $product_image = base64_encode($row["product_image"]);
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $product_description = $row['product_description'];
                $product_picked_qty = $id_qty_combined[$product_id];
                $product_price_per_unit = intval($row['price_per_unit']);
                $product_price_total = $product_price_per_unit * $product_picked_qty;
                $count++;
                $total_price += $product_price_total;
            ?>
                <form method="POST" action="./controllers/checkout_process.php">
                    <div class="product-picked-content">
                        <div class="product-detail">
                            <div class="product-image"><img src="data:image/jpeg;base64,<?php echo $product_image ?>"></div>
                            <!-- <div class="product-id"><?php echo $product_id ?></div> -->
                            <div class="product-name"><?php echo $product_name ?></div>
                            <div class="product-description"><?php echo $product_description ?></div>
                        </div>
                        <div class="product-price-per-unit">฿<?php echo $product_price_per_unit ?></div>
                        <div class="product-picked-qty"><?php echo $product_picked_qty ?></div>
                        <div class="product-price-total">฿<?php echo $product_price_total ?></div>
                    </div>
                <?php } ?>

                <footer class="checkout-footer">
                    <div class="count-checked">Count: <?php echo $count ?></div>
                    <div class="price-checked">Total Price: <?php echo number_format($total_price, 2) ?></div>
                    <div class="place-order-btn-container">
                        <input class="btn btn-success place-order-btn" type="submit" name="place_order" value="Place Order">
                    </div>
                </footer>
                </form>
        </div>
    </div>
</body>

</html>