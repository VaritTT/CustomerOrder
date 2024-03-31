<?php
session_start();
session_destroy();
header("Location: homepage_customer.php");
