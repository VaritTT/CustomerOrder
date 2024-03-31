<?php
require_once '../config/connectDB.php';
if ($_SESSION['user_type'] != "admin") {
    die(header("Location: ../user/_404.php"));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar sticky-bottom navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="report_order_all.php">Admin Shopping</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link" href="report_order_all.php">Report Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="product.php">Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="customer.php">Customer</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Report</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="report_order_all.php">All Report Order</a></li>
                            <li><a class="dropdown-item" href="report_order_paid.php">Paid Order</a></li>
                            <li><a class="dropdown-item" href="report_order_unpaid.php">Unpaid Order</a></li>
                            <li><a class="dropdown-item" href="report_order_cancel.php">Cancel Order</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav ms-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="cart.php">Cart</a>
                    </li> -->
                    <?php if (isset($_SESSION['customer_id']) && isset($_SESSION['user_type'])) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="">Cust No: <?php echo $_SESSION['customer_id'] ?> (Admin) </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ms-2" href="../user/logout.php">Logout</a>
                        </li>
                    <?php } else { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../register.php">Register</a>
                        </li>
                    <?php } ?>
                </ul>

            </div>
        </div>
    </nav>
</body>

</html>