<?php
session_start();
require_once "../config/connectDB.php";

if (!isset($_SESSION['customer_id']) || !isset($_SESSION['user_type'])) {
    die(header("Location: login.php"));
} else if (isset($_GET['logout'])) {
    session_destroy();
    die(header("Location: login.php"));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cart</title>

    <style>
        .container-cart {
            margin-bottom: 80px;
        }

        .cart-box {
            display: flex;
            align-items: center;
            padding: 10px 0;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .cart-box:hover {
            background-color: #e6e6e6;
        }


        .cart-detail div {
            padding-left: 1rem;
        }

        .product-image img {
            border-radius: 16px;
            border: 1px solid grey;
            width: 150px;
            height: 150px;
        }

        .cart-detail {
            display: flex;
            padding: 0 1rem;
        }

        .product-pick-qty {
            display: flex;
            justify-content: center;
            height: 20px;
        }

        .cart-footer {
            background-color: #ccc;
            width: 80%;
            height: 80px;
            bottom: 0;
            position: fixed;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1rem;
        }

        .checkout-btn {
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

        .checkout-btn:hover {
            color: white;
            background-color: #45a049;
        }

        .delete-btn {
            margin-right: 8px;
            width: 120px;
            height: 50px;
            background-color: #CC0000;
            border: none;
            outline: none;
            cursor: pointer;
            text-align: center;
            float: right;
            transition: background-color 0.3s ease;
            box-shadow: 0px 0px 5px 0px rgba(0, 0, 0, 0.1);
        }

        .delete-btn:hover {
            color: white;
            background-color: #FF3333;
        }

        .count-checked {
            display: flex;
        }

        .product-pick-qty {
            display: flex;
            height: fit-content;
            width: fit-content;
            margin-bottom: 8px;
        }

        .pick-qty {
            margin: 0 8px;
        }

        .rounded-circle {
            width: 40px;
            height: 40px;
        }

        .price-checked {
            display: flex;
        }

        .footer-btn {
            display: flex;
        }

        @media screen and (max-width: 768px) {
            .cart-footer {
                width: 100%;
                margin: 0 auto;
            }
        }

        @media screen and (min-width: 769px) and (max-width: 1200px) {
            .cart-footer {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php include './menu_user.php'; ?>

    <div class="container container-cart">
        <div class="form-check">
            <input class="form-check-input checkbox-all" id="select_all" type="checkbox" value="" id="flexCheckDefault">
            <label class="form-check-label label-checkbox-all" for="flexCheckDefault">Select All</label>
        </div>
        <?php
        $customer_id = $_SESSION['customer_id'];
        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE customer_id = $customer_id");
        ?>
        <?php if (mysqli_num_rows($select_cart) <= 0) { ?>
            <div class="container container-cart">
                <div>Please check at least one checkbox to delete.</div>
            <?php }
        $pick_qty = array();
        while ($row = mysqli_fetch_assoc($select_cart)) {
            $product_id = $row["product_id"];
            $pick_qty = $row['qty'];
            $select_product = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $product_id");
            $row1 = mysqli_fetch_assoc($select_product);
            $product_name = $row1["product_name"];
            $product_description = $row1["product_description"];
            $price_per_unit = $row1["price_per_unit"];
            // $stock_qty = $row1["stock_qty"];
            $product_image = base64_encode($row1["product_image"]);

            if (mysqli_num_rows($select_cart) <= 0) {
                echo "โล่ง";
            }
            ?>
                <form method="POST" action="./controllers/cart_process.php">
                    <div id="cart-box" class="cart-box">
                        <div class="form-check">
                            <input class="form-check-input product-checkbox" type="checkbox" id="flexCheckDefault" name="pick_product_id_array_checked[]" value="<?php echo $product_id ?>" autocomplete="off">
                        </div>
                        <input type="hidden" name="pick_product_id_array_uncheck[]" value="<?php echo $product_id ?>" id="checkbox_<?php echo $product_id ?>">
                        <div class="cart-image">
                            <div class="product-image"><img src="data:image/jpeg;base64,<?php echo $product_image ?>"></div>
                        </div>
                        <div class="cart-detail">
                            <div class="product-name"><?php echo $product_name ?></div>
                            <div class="product-description"><?php echo $product_description ?></div>
                            <div class="product-price">฿<?php echo $price_per_unit ?></div>
                            <div class="product-pick-qty">
                                <button id="decrease-btn" class="btn btn-danger rounded-circle" name="decrease"><i class='bx bx-minus'></i></button>
                                <input id="productPickQty" class="pick-qty" type="text" name="pick_qty_array[]" value="<?php echo $pick_qty ?>">
                                <button id="increase-btn" class="btn btn-success rounded-circle" name="increase"><i class='bx bx-plus'></i></button>
                            </div>
                        </div>
                    </div>
                <?php
            }
                ?>
                <footer class="cart-footer">
                    <div class="product-checked">
                        <div class="count-checked">
                            <p>Count:</p>
                            <p id="count-checked">0</p>
                        </div>
                        <div class="price-checked">
                            <p>Total Price: ฿</p>
                            <p id="price-checked" min="0">0.00</p>
                        </div>

                    </div>
                    <div class="footer-btn">
                        <input id="delete-btn" type="submit" class="btn btn-danger delete-btn" name="delete" value="Delete">
                        <input id="checkout-btn" type="submit" class="btn btn-success checkout-btn" name="checkout" value="Check Out">
                    </div>
                </footer>
                </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
            <script>
                const checkboxAll = document.getElementById("select_all");
                const checkboxes = document.querySelectorAll('.product-checkbox');
                const deleteBtn = document.getElementById("delete-btn");
                let totalPrice = 0;
                let count = 0;

                checkboxAll.addEventListener('change', () => {
                    checkboxes.forEach(checkbox => {
                        console.log(checkbox.checked == true);
                        if (checkbox.checked == false && checkboxAll.checked == true) {
                            checkbox.checked = checkboxAll.checked;
                            calculateTotalPrice(checkbox);
                        } else if (checkbox.checked == true && checkboxAll.checked == false) {
                            checkbox.checked = checkboxAll.checked;
                            calculateTotalPrice(checkbox);
                        }
                    });
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', () => {
                        let allChecked = true;
                        checkboxes.forEach(checkbox => {
                            if (!checkbox.checked) {
                                allChecked = false;
                            }
                        });
                        checkboxAll.checked = allChecked;
                        calculateTotalPrice(checkbox);
                    });
                });

                deleteBtn.addEventListener('click', (event) => {
                    event.preventDefault();
                    if (confirm("Do you want to remove the checked items?")) {
                        checkboxes.forEach(checkbox => {
                            if (checkbox.checked) {
                                removeCheckedCart(checkbox);
                            }
                        });
                    }
                });

                const cartBoxes = document.querySelectorAll('.cart-box');
                cartBoxes.forEach(cartBox => {
                    const decreaseBtn = cartBox.querySelector('#decrease-btn');
                    const increaseBtn = cartBox.querySelector('#increase-btn');
                    const pickQtyInput = cartBox.querySelector('.pick-qty');

                    decreaseBtn.addEventListener('click', function(event) {
                        event.preventDefault();
                        decreaseQuantity(cartBox);
                        updateCart(pickQtyInput);
                    });

                    increaseBtn.addEventListener('click', function(event) {
                        event.preventDefault();
                        increaseQuantity(cartBox);
                        updateCart(pickQtyInput);
                    });

                    pickQtyInput.addEventListener('change', function(event) {
                        updateCart(pickQtyInput);
                    });
                });

                function calculateTotalPrice(checkbox) {
                    // checkboxes.forEach(checkbox => {
                    const productPriceText = checkbox.closest('.cart-box').querySelector('.product-price').innerText;
                    const productPrice = parseFloat(productPriceText.replace(/[^\d.]/g, ''));
                    const productQty = parseInt(checkbox.closest('.cart-box').querySelector('.pick-qty').value);
                    if (checkbox.checked) {
                        totalPrice += productPrice * productQty;
                        count++;
                    } else {
                        totalPrice -= productPrice * productQty;
                        count--;
                    }
                    // });
                    document.getElementById('count-checked').innerText = `${count}`;
                    document.getElementById('price-checked').innerText = `${totalPrice.toFixed(2)}`;
                }



                function decreaseQuantity(cartBox) {
                    const productPriceText = cartBox.querySelector('.product-price').innerText;
                    const productPrice = parseFloat(productPriceText.replace(/[^\d.]/g, ''));
                    const pickQtyInput = cartBox.querySelector('.pick-qty');
                    const checkbox = cartBox.querySelector('.product-checkbox');
                    let currentValue = parseInt(pickQtyInput.value);

                    if (currentValue > 1) {
                        pickQtyInput.value = currentValue - 1;
                        if (checkbox.checked) {
                            updateTotalPrice(-productPrice);
                        }
                    } else {
                        if (confirm("Do you want to remove this item?")) {
                            removeCart(pickQtyInput);
                        }
                    }
                }

                function increaseQuantity(cartBox) {
                    const productPriceText = cartBox.querySelector('.product-price').innerText;
                    const productPrice = parseFloat(productPriceText.replace(/[^\d.]/g, ''));
                    const pickQtyInput = cartBox.querySelector('.pick-qty');
                    const checkbox = cartBox.querySelector('.product-checkbox');
                    let currentValue = parseInt(pickQtyInput.value);

                    pickQtyInput.value = currentValue + 1;
                    if (checkbox.checked) {
                        updateTotalPrice(productPrice);
                    }
                }

                function updateTotalPrice(priceDifference) {
                    totalPrice += priceDifference;
                    document.getElementById('price-checked').innerText = `${totalPrice.toFixed(2)}`;
                }

                function updateCart(pickQtyInput) {
                    const cartBox = pickQtyInput.closest('.cart-box');
                    const product_id = cartBox.querySelector('.product-checkbox').value;

                    fetch('./controllers/cart_process.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `product_id=${product_id}&pick_qty=${pickQtyInput.value}&action=update`
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(data => {
                            console.log(data);
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                }

                function removeCart(pickQtyInput) {
                    const cartBox = pickQtyInput.closest('.cart-box');
                    const productPriceText = cartBox.querySelector('.product-price').innerText;
                    const productPrice = parseFloat(productPriceText.replace(/[^\d.]/g, ''));
                    const product_id = cartBox.querySelector('.product-checkbox').value;
                    const customer_id = cartBox.querySelector('.product-checkbox').value;

                    fetch('./controllers/cart_process.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `product_id=${product_id}&customer_id=${<?php echo $_SESSION["customer_id"]; ?>}&action=delete`
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(data => {
                            console.log(data);
                            cartBox.remove();
                            updateTotalPrice(-parseFloat(productPrice) * parseInt(pickQtyInput.value));
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                }

                function removeCheckedCart(checkbox) {
                    const cartBox = checkbox.closest('.cart-box');
                    const checkboxChecked = cartBox.querySelector(".product-checkbox");
                    const productPriceText = cartBox.querySelector('.product-price').innerText;
                    const productPrice = parseFloat(productPriceText.replace(/[^\d.]/g, ''));
                    const pickQtyInput = cartBox.querySelector(".pick-qty");
                    const product_id = cartBox.querySelector('.product-checkbox').value;
                    const customer_id = cartBox.querySelector('.product-checkbox').value;
                    fetch('./controllers/cart_process.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `product_id=${product_id}&customer_id=${<?php echo $_SESSION["customer_id"]; ?>}&action=delete`
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.text();
                        })
                        .then(data => {
                            console.log(data);
                            cartBox.remove();
                            updateTotalPrice(-parseFloat(productPrice) * parseInt(pickQtyInput.value));
                        })
                        .catch(error => {
                            console.error('There has been a problem with your fetch operation:', error);
                        });
                }
            </script>
</body>

</html>