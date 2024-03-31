<?php
session_start();
require_once "../config/connectDB.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <title>Product</title>
    <style>
        .product-content {
            display: flex;
        }

        .product-image {
            padding: 2rem;
        }

        .product-image img {
            width: 300px;
            height: 300px;
        }

        .product-detail {
            padding: 1rem;
        }

        .product-name {
            font-weight: bold;
            font-size: 24px;
        }

        .product-description {
            font-size: 14px;
        }

        .product-price {
            font-size: 30px;
        }

        .product-qty {
            font-size: 14px;
        }

        .order-selector {
            display: flex;
        }

        .pick-qty {
            margin: 0 8px;
        }

        .decrease-btn,
        .increase-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #4CAF50;
            width: 40px;
            height: 40px;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            font-size: 16px;
            padding: 8px;
            transition: background-color 0.3s;
        }

        .decrease-btn:hover,
        .increase-btn:hover {
            background-color: #45a049;
        }

        input[name="add"],
        input[name="purchase"] {
            padding: 8px 16px;
            font-size: 12px;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[name="purchase"] {
            margin-left: 8px;
            background-color: #ff6600;
        }

        input[name="purchase"]:hover {
            background-color: #cc5500;
        }
    </style>
</head>

<body>
    <?php include './menu_user.php'; ?>
    <?php
    if (isset($_GET['id'])) {
        $product_id = $_GET['id'];
        $select_product = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id");
        $row = mysqli_fetch_assoc($select_product);
        $name1 = $row['product_id'];
        $name2 = $row['product_name'];
        $name3 = $row['product_description'];
        $name4 = $row['price_per_unit'];
        $name5 = $row['stock_qty'];
        $name6 = base64_encode($row['product_image']);
    }
    ?>

    <div class="container container-product">
        <section class="product-content">
            <div class="product-image">
                <img src="data:image/jpeg;base64,<?php echo $name6 ?>">
            </div>
            <!-- <div class="id"><?php echo $name1 ?></div> -->
            <div class="product-detail">
                <div class="product-name"><?php echo $name2 ?></div>
                <div class="product-price">฿<?php echo $name4 ?></div>
                <div id="qty-id" class="product-qty">in stock <?php echo $name5 ?></div>
                <div class="product-description"><?php echo $name3 ?></div>
                <form class="order_process-form" method="POST" action="./controllers/order_process.php">
                    <input type="hidden" name="product_id" value="<?php echo $name1 ?>">
                    <div class="order-selector">
                        <button class="btn btn-danger rounded-circle decrease-btn" name="decrease"><i class='bx bx-minus'></i></button>
                        <input type="text" class="pick-qty" name="pick_qty" value="1" min="1">
                        <button class="btn btn-success rounded-circle increase-btn" name="increase"><i class='bx bx-plus'></i></button>
                    </div>

                    <div class="order-btn mt-4 ms-5">
                        <input class="btn btn-success" type="submit" name="add" value="Add to Cart">
                        <input class="btn btn-warning" type="submit" name="purchase" value="Purchase">
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        const containerProducts = document.querySelectorAll('.container-product');

        containerProducts.forEach(function(containerProduct) {
            const decreaseBtn = containerProduct.querySelector('.decrease-btn');
            const increaseBtn = containerProduct.querySelector('.increase-btn');
            const pickQtyInput = containerProduct.querySelector('.pick-qty');
            const qtyElement = containerProduct.querySelector('.product-qty');
            const numberQty = parseInt((qtyElement.textContent).match(/\d+/));

            // disable enter ทิ้ง
            pickQtyInput.addEventListener('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });


            pickQtyInput.addEventListener('input', function() {
                if (!pickQtyInput.value || isNaN(pickQtyInput.value) || pickQtyInput.value < 1) {
                    pickQtyInput.value = 1;
                }
            });

            decreaseBtn.addEventListener('click', function(event) {
                console.log(event.key === "click");
                event.preventDefault(); // ไม่ให้ยุ่งกับ form
                let currentValue = parseInt(pickQtyInput.value);
                if (currentValue > 1) {
                    pickQtyInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', function(event) {
                event.preventDefault();
                let currentValue = parseInt(pickQtyInput.value);
                if (currentValue < numberQty) {
                    pickQtyInput.value = currentValue + 1;
                }
            });
        });
    </script>
</body>

</html>