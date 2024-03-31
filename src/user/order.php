<?php
session_start();
require_once "../config/connectDB.php";
$directory = dirname($_SERVER['REQUEST_URI']);

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Order</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


    <style>
        .container-grid {
            display: flex;
        }

        .container-list {
            display: block;
        }

        .product-main {
            list-style: none;
        }

        .product-content a {
            text-decoration: none;
            color: #000;
        }

        .list-view {
            display: flex;
            align-items: center;
            padding: 10px 0;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .search-container {
            margin: 1rem 0;
        }

        .search-box {
            width: 40%;
            padding: 8px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-btn {
            padding: 8px 16px;
            font-size: 16px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .view-toggle {
            display: flex;
            justify-content: flex-end;
            padding: 1rem 0;
        }

        .view-toggle .list-btn {
            margin-right: 8px;
        }

        .list-view {
            display: flex;
            align-items: center;
            padding: 10px 0;
            font-size: 16px;
            border-bottom: 1px solid #ccc;
        }

        .list-view:hover {
            background-color: #f9f9f9;
        }

        .list-view a {
            display: flex;
            text-decoration: none;
            color: #000;
        }

        .product-image img {
            border-radius: 8px;
            border: 1px solid #ddd;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }

        .product-detail {
            padding: 0 1rem;
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

        .order-btn {
            display: flex;
            justify-content: center;
        }

        .order-selector {
            display: flex;
            justify-content: center;
            margin-bottom: 8px;
        }

        .pick-qty {
            text-align: center;
            width: 6rem;
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

        .grid-view {
            width: 100%;
            padding: 0 0.5rem;
            margin: 0 5px;
            padding-bottom: 1rem;
        }

        .grid-view:hover {
            border: 2px solid #6D9886;
        }

        .grid-view .product-image {
            text-align: center;
            width: 100%;
            height: 200px;
        }

        .grid-view .product-image img {
            width: 100%;
            height: 100%;
            border: none;
            object-fit: contain;
        }

        .grid-view .product-detail {
            font-size: 12px;
        }

        .grid-view .product-detail .description {
            line-height: 1.5em;
            max-height: 3em;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .list-btn,
        .grid-btn {
            cursor: pointer;
            border: none;
            outline: none;
        }
    </style>
</head>


<body>
    <?php include './menu_user.php'; ?>

    <div class="container container-order">
        <form class="search-container" method="GET" action="">
            <input id="search" class="search-box" name="search" type="text" placeholder="Type here">
            <input id="submit" class="search-btn" type="submit" value="Search">
        </form>
        <div class="view-toggle">
            <button id="list-view" type="submit" name="list-view" class="list-btn"><i class='bx bx-list-ul bx-md'></i></button>
            <button id="grid-view" type="submit" name="grid-view" class="grid-btn"><i class='bx bxs-grid-alt bx-md'></i></button>
        </div>

        <ul id="product-main" class="product-main container-grid">
            <?php
            if (isset($_GET['search'])) {
                $search_value = mysqli_real_escape_string($conn, $_GET['search']);
                $cur = mysqli_query($conn, "SELECT * FROM product WHERE 
                                    product_id LIKE '%$search_value%' OR 
                                    product_name LIKE '%$search_value%' OR
                                    product_description LIKE '%$search_value%';");
            } else {
                if (isset($category_id)) {
                    $cur = mysqli_query($conn, "SELECT * FROM product WHERE category_id = $category_id");
                } else {
                    $cur = mysqli_query($conn, "SELECT * FROM product");
                }
            }
            $row_length = mysqli_num_rows($cur);
            while ($row = mysqli_fetch_assoc($cur)) {
                $product_id = $row['product_id'];
                $product_name = $row['product_name'];
                $product_description = $row['product_description'];
                $price_per_unit = $row['price_per_unit'];
                $stock_qty = $row['stock_qty'];
                $product_image = base64_encode($row['product_image']); // เก็บรูปแบบ binary (BLOB)
            ?>

                <li class="product-content grid-view">
                    <a href="product.php?id=<?php echo $product_id; ?>">
                        <div class="product-image">
                            <img src="data:image/jpeg;base64,<?php echo $product_image ?>">
                        </div>
                        <!-- <div class="id"><?php echo $product_id ?></div> -->
                        <div class="product-detail">
                            <div class="name"><?php echo $product_name ?></div>
                            <div class="description"><?php echo $product_description ?></div>
                            <div class="price">฿<?php echo $price_per_unit ?></div>
                            <div id="qty-id" class="quantity">in stock <?php echo $stock_qty ?></div>
                        </div>
                    </a>
                    <form class="order_process-form" method="POST" action="./controllers/order_process.php">
                        <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                        <div class="order-selector">
                            <button class="btn btn-danger rounded-circle decrease-btn" name="decrease"><i class='bx bx-minus'></i></button>
                            <input type="text" class="pick-qty" name="pick_qty" value="0" placeholder="0" min="0">
                            <button class="btn btn-success rounded-circle increase-btn" name="increase"><i class='bx bx-plus'></i></button>
                        </div>

                        <div class="order-btn">
                            <input class="btn btn-success" type="submit" name="add" value="Add to Cart">
                            <input class="btn btn-warning" type="submit" name="purchase" value="Purchase">
                        </div>
                    </form>
                </li>

            <?php
            } ?>
        </ul>
    </div>
    <script>
        document.querySelector('.list-btn').addEventListener('click', function(e) {
            e.preventDefault();
            setView('list');
        });

        document.querySelector('.grid-btn').addEventListener('click', function(e) {
            e.preventDefault();
            setView('grid');
        });

        function setView(view) {
            const mainProduct = document.querySelector('.product-main');
            console.log(mainProduct);
            const products = document.querySelectorAll('.product-content');
            products.forEach(product => {
                if (view === 'list') {
                    mainProduct.classList.remove('container-grid');
                    mainProduct.classList.add('container-list');
                    product.classList.remove('grid-view');
                    product.classList.add('list-view');
                } else if (view === 'grid') {
                    mainProduct.classList.remove('container-list');
                    mainProduct.classList.add('container-grid');
                    product.classList.remove('list-view');
                    product.classList.add('grid-view');
                }
            });
        }

        const containerOrders = document.querySelectorAll('.product-content');
        containerOrders.forEach(function(containerOrder) {
            const decreaseBtn = containerOrder.querySelector('.decrease-btn');
            const increaseBtn = containerOrder.querySelector('.increase-btn');
            const pickQtyInput = containerOrder.querySelector('.pick-qty');
            const qtyElement = containerOrder.querySelector('.quantity');
            const numberQty = parseInt((qtyElement.textContent).match(/\d+/));

            // disable enter ทิ้ง
            pickQtyInput.addEventListener('keydown', function(event) {
                if (event.keyCode === 13) {
                    event.preventDefault();
                }
            });

            pickQtyInput.addEventListener('input', function() {
                if (!pickQtyInput.value || isNaN(pickQtyInput.value)) {
                    pickQtyInput.value = 0;
                }
            });

            decreaseBtn.addEventListener('click', function(event) {
                console.log(event.key === "click");
                event.preventDefault(); // ไม่ให้ยุ่งกับ form
                let currentValue = parseInt(pickQtyInput.value);
                if (currentValue > 0) {
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