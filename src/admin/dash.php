<?php
$orderAll = 0;
$order1 = 0;
$order2 = 0;
$order3 = 0;
$sql2 = "SELECT * FROM order_header";
$result2 = mysqli_query($conn, $sql2);
while ($row2 = mysqli_fetch_array($result2)) {
  $orderAll++;
}

// Paid
$sql3 = "SELECT * FROM order_header WHERE order_status_id = 1 ";
$result3 = mysqli_query($conn, $sql3);
while ($row3 = mysqli_fetch_array($result3)) {
  $order1++;
}

// Unpaid
$sql4 = "SELECT * FROM order_header WHERE order_status_id = 2 ";
$result4 = mysqli_query($conn, $sql4);
while ($row4 = mysqli_fetch_array($result4)) {
  $order2++;
}

// Cancel Order
$sql5 = "SELECT * FROM order_header WHERE order_status_id = 3 ";
$result5 = mysqli_query($conn, $sql5);
while ($row5 = mysqli_fetch_array($result5)) {
  $order3++;
}
?>
<!-- body -->

<div class="container-fluid mt-4">
  <div class="row">

    <?php
    $current_time = strtotime(date('Y-m-d H:i:s'));
    $midnight = strtotime(date('Y-m-d 00:00:00'));
    if ($current_time >= $midnight) {
      $daily_target = 10000;
    }

    // Calculate total sales for the current day
    $sql6 = "SELECT SUM(total_price) AS total_sales FROM order_header WHERE DATE(order_datetime) = CURDATE()";
    $result6 = mysqli_query($conn, $sql6);
    $row6 = mysqli_fetch_assoc($result6);
    $total_sales = $row6['total_sales']; // Retrieve total sales directly from the query result

    $progress_percentage = ($total_sales / $daily_target) * 100; // Calculate progress percentage

    // Output the daily target and progress bar
    ?>
    <div class="col-xl-12 col-sm-12 mb-xl-0 mb-4">
      <h6>เป้าหมายวันนี้ <b><?php echo number_format($daily_target); ?> บาท</b></h6>
      <div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="<?php echo $progress_percentage; ?>" aria-valuemin="0" aria-valuemax="100">
        <?php
        if ($progress_percentage >= 100) {
          // If the progress percentage is 100% or more, change progress bar color to green
          echo '<div class="progress-bar bg-success" style="width: ' . $progress_percentage . '%">' . number_format($total_sales) . ' บาท (สำเร็จแล้ว!)</div>';
        } else {
          // Otherwise, keep the progress bar blue
          echo '<div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: ' . $progress_percentage . '%">' . number_format($total_sales) . ' บาท</div>';
        }
        ?>
      </div>
    </div>

    <br><br><br>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">ออเดอร์ทั้งหมด</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo $orderAll; ?>
                </h5>
              </div>
            </div>
            <!-- image -->
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">ออเดอร์ที่ชำระแล้ว</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo $order1; ?>
                </h5>
              </div>
            </div>
            <!-- image -->
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">
              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">ออเดอร์ที่ยังไม่ได้ชำระ</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo $order2; ?>
                </h5>
              </div>
            </div>
            <!-- image -->
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php
    // Get the number of orders today
    $sql_today_orders = "SELECT COUNT(*) AS today_orders FROM order_header WHERE DATE(order_datetime) = CURDATE()";
    $result_today_orders = mysqli_query($conn, $sql_today_orders);
    $row_today_orders = mysqli_fetch_assoc($result_today_orders);
    $today_orders = $row_today_orders['today_orders'];

    // Get the number of orders yesterday
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $sql_yesterday_orders = "SELECT COUNT(*) AS yesterday_orders FROM order_header WHERE DATE(order_datetime) = '$yesterday'";
    $result_yesterday_orders = mysqli_query($conn, $sql_yesterday_orders);
    $row_yesterday_orders = mysqli_fetch_assoc($result_yesterday_orders);
    $yesterday_orders = $row_yesterday_orders['yesterday_orders'];

    // Output the number of orders yesterday
    ?>
    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
      <div class="card">
        <div class="card-body p-3">
          <div class="row">
            <div class="col-8">

              <div class="numbers">
                <p class="text-sm mb-0 text-capitalize font-weight-bold">ออเดอร์วันนี้</p>
                <h5 class="font-weight-bolder mb-0">
                  <?php echo $today_orders;
                  if ($yesterday_orders > $today_orders) {
                    echo "<span class='text-danger text-sm font-weight-bolder'>  (เมื่อวาน $yesterday_orders)</span>";
                  } else if ($yesterday_orders < $today_orders) {
                    echo "<span class='text-success text-sm font-weight-bolder'> (เมื่อวาน $yesterday_orders)</span>";
                  } else {
                    echo "<span class='text-dark text-sm font-weight-bolder'> (เมื่อวาน $yesterday_orders)</span>";
                  }
                  ?>
                </h5>
              </div>
            </div>
            <!-- image -->
            <div class="col-4 text-end">
              <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>