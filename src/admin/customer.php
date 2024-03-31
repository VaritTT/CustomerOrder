<?php
session_start();
require_once '../config/connectDB.php';
if ($_SESSION['user_type'] != "admin") {
  die(header("Location: ../user/_404.php"));
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Report All</title>

  <!-- link css -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>

<body>
  <!-- menu -->
  <?php include 'menu.php'; ?>
  <?php

  $cus_num = 0;
  if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM customer WHERE user_type = 'user' AND CONCAT(customer_id, customer_name, sex) LIKE '%$search%' ORDER BY customer_id";
  } else {
    $sql = "SELECT * FROM customer WHERE user_type = 'user'";
  }
  $hand2 = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($hand2)) {
    $cus_num++;
  }
  ?>
  <!-- body -->

  <div class="container-fluid mt-4">
    <div class="row">

      <div class="col-6 mt-4">
        <h4 style="font-weight: 600;">ลูกค้าทั้งหมด <span class="badge text-bg-info"><?php echo $cus_num; ?></span></h4>
      </div>

      <form class="d-flex mt-4" role="search" action="" method="">
        <input class="form-control me-2" type="text" placeholder="ค้นหาลูกค้า" name="search" aria-label="Search" value="<?php if (isset($_GET['search'])) {
                                                                                                                          echo $_GET['search'];
                                                                                                                        } ?>">
        <button class="btn btn-info" type="submit">Search</button>
      </form>

      <div class="col-12 mt-4">
        <table class="table">
          <thead>
            <tr>
              <!-- <th>
                        <div class="checkbox d-inline-block">
                            <input type="checkbox" class="checkbox-input" id="checkbox1">
                            <label for="checkbox1" class="mb-0"></label>
                        </div>
                    </th> -->
              <th class="text-center" scope="col">รหัสลูกค้า</th>
              <th class="text-center" scope="col">ชื่อลูกค้า</th>
              <th class="text-center" scope="col">เพศ</th>
              <th class="text-center" scope="col">ที่อยู่</th>
              <th class="text-center" scope="col">เบอร์ติดต่อ</th>
              <th class="text-center" scope="col">วันเกิด</th>
              <th class="text-center" scope="col">ดำเนินการ</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $hand = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($hand)) {
            ?>
              <tr>
                <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['customer_id'] ?></td>
                <td class="col-2 text-center" style="vertical-align: middle;"><?= $row['customer_name'] ?></td>
                <td class="col-2 text-center" style="vertical-align: middle;"><?= $row['sex'] ?></td>
                <td class="col-3 text-center" style="vertical-align: middle;"><?= $row['addr'] ?></td>
                <td class="col-1 text-center" style="vertical-align: middle;"><?= $row['tel'] ?></td>
                <td class="col-2 text-center" style="vertical-align: middle;"><?= date('d-m-Y', strtotime($row['birthDate'])) ?></td>
                <td class="col-2 text-center" style="vertical-align: middle;">
                  <a href="edit_customer.php?id=<?= $row['customer_id'] ?>" class="btn btn-warning">แก้ไขข้อมูล</a>
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