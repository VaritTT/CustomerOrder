<?php
session_start();
require_once "../config/connectDB.php";
if (!isset($_SESSION['customer_id']) || !isset($_SESSION['user_type'])) {
    // die(header("Location: homepage_customer.php"));
} else if (isset($_GET['logout'])) {
    session_destroy();
    // die(header("Location: homepage_customer.php"));
}
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .container-homepage-customer {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .form-select {
            margin-top: 20px;
        }

        .input-submit {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            transition: background-color 0.3s ease;
        }

        .input-submit:hover {
            background-color: #45a049;
        }

        .main {
            margin-top: 20px;
        }

        @media screen and (max-width: 600px) {
            .container-homepage-customer {
                padding: 0 10px;
            }

            .input-submit {
                padding: 10px 20px;
            }
        }

        .banner-image1,
        .banner-image2 {
            display: none;
            width: 100%;
            position: relative;
        }

        .banner-image1 img,
        .banner-image2 img {
            vertical-align: middle;
            width: inherit;
        }

        .slideshow-banner {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            width: 100%;
        }

        .slideshow-banner img {
            width: 100%;
        }

        .prev,
        .next {
            cursor: pointer;
            position: absolute;
            top: 50%;
            width: auto;
            padding: 16px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
            border-radius: 0 3px 3px 0;
            border-radius: 3px 0 0 3px;

        }

        .prev {
            left: 0;
        }

        .next {
            right: 0;
        }

        .prev:hover,
        .next:hover {
            background-color: #000;
            color: white;
        }

        .img-fluid {
            width: 80%;
        }

        .categories-suggest a {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .categories-suggest a:hover {
            filter: drop-shadow(0 0 0.75rem #cccccc);
        }
    </style>
</head>
<?php
$directory = dirname($_SERVER['REQUEST_URI']);
?>

<body>
    <?php include './menu_user.php'; ?>
    <?php if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
        $select_id = mysqli_query($conn, "SELECT * FROM customer WHERE customer_id = $customer_id");
        $row = mysqli_fetch_assoc($select_id);
    } ?>


    <div class="container-homepage-customer">
        <div class="slideshow-banner">
            <div class="banner-image1">
                <img src="../assets/img/banner1.jpg" alt="banner1">
            </div>
            <div class="banner-image1">
                <img src="../assets/img/banner2.jpg" alt="banner2">
            </div>
            <div class="banner-image1">
                <img src="../assets/img/banner3.jpg" alt="banner3">
            </div>
            <a class="prev" onclick="plusSlides(-1, 0)">&#10094;</a>
            <a class="next" onclick="plusSlides(1, 0)">&#10095;</a>
        </div>
        <div class="container mt-4 categories-suggest">
            <div class="row">
                <a href="order.php?category_id=1" class="col">
                    <img src="../assets/img/stationery.jpg" class="img-fluid rounded-circle">
                    <p>Stationery</p>
                </a>
                <a href="order.php?category_id=2" class="col">
                    <img src="../assets/img/men_clothing.jpg" class="img-fluid rounded-circle">
                    <p>Men's Clothing</p>
                </a>
                <a href="order.php?category_id=3" class="col">
                    <img src="../assets/img/women_clothing.jpg" class="img-fluid rounded-circle">
                    <p>Women's Clothing</p>
                </a>
                <a href="order.php?category_id=4" class="col">
                    <img src="../assets/img/book.jpg" class="img-fluid rounded-circle">
                    <p>Books: Textbooks, Novels, Comics, Magazines</p>
                </a>
                <a href="order.php?category_id=5" class="col">
                    <img src="../assets/img/electronic.jpg" class="img-fluid rounded-circle">
                    <p>Electronics: Computers and Accessories</p>
                </a>
            </div>
        </div>
    </div>

    <script>
        let slideIndex = [1, 1];
        let slideId = ["banner-image1", "banner-image2"];
        showSlides(1, 0);
        showSlides(1, 1);

        function plusSlides(n, no) {
            showSlides(slideIndex[no] += n, no);
        }

        function showSlides(n, no) {
            let i;
            let x = document.getElementsByClassName(slideId[no]);
            if (n > x.length) {
                slideIndex[no] = 1;
            }
            if (n < 1) {
                slideIndex[no] = x.length;
            }
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";
            }
            x[slideIndex[no] - 1].style.display = "block";
        }
    </script>
</body>

</html>