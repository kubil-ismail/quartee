<?php
session_start();

if(!isset($_SESSION["login"]) ) {
	header("Location: ../login");
	exit;
}

require '../../config/guest-config.php';

if (isset($_POST['run']) && count($_POST['kategori']) > 1) {
	$lAr = 0;
	$produk = $antiXss->xss_clean($_POST["produk"]);
	$start = $antiXss->xss_clean($_POST["awal"]);
	$end = $antiXss->xss_clean($_POST["akhir"]);
	$month = array(
   0 => 0, //jan
   1 => 0, //feb
   2 => 0, //mar
   3 => 0, //apr
   4 => 0, //may
   5 => 0, //jun
   6 => 0, //jul
   7 => 0, //aug
   8 => 0, //sep
   9 => 0, //oct
   10 => 0, //nov
   11 => 0 //des
 	);
	$months = array(
   0 => 0, //jan
   1 => 0, //feb
   2 => 0, //mar
   3 => 0, //apr
   4 => 0, //may
   5 => 0, //jun
   6 => 0, //jul
   7 => 0, //aug
   8 => 0, //sep
   9 => 0, //oct
   10 => 0, //nov
   11 => 0 //des
 	);
	for ($i=0; $i < count($_POST['kategori']); $i++) {
		$kategori[$i] = $antiXss->xss_clean($_POST["kategori"][$i]);
		$query[$i] = "SELECT * FROM upload_data
		WHERE
		product_id = '$produk' AND
		kategori = '$kategori[$i]' AND
		created_at >= '$start' AND
		created_at <= '$end'
		";

		$result[$i] = mysqli_query($conn, $query[$i]);

		foreach($result[$i] as $row) {
		 if ($row['month'] == 'Jan') {
	     $month[0]++;
	   }
	   if ($row['month'] == 'Feb'){
	     $month[1]++;
	   }
	   if ($row['month'] == 'Mar') {
	     $month[2]++;
	   }
	   if ($row['month'] == 'Apr'){
	     $month[3]++;
	   }
	   if ($row['month'] == 'May') {
	     $month[4]++;
	   }
	   if ($row['month'] == 'Jun'){
	     $month[5]++;
	   }
	   if ($row['month'] == 'Jul') {
	     $month[6]++;
	   }
	   if ($row['month'] == 'Aug'){
	     $month[7]++;
	   }
	   if ($row['month'] == 'Sep'){
	     $month[8]++;
	   }
	   if ($row['month'] == 'Oct'){
	     $month[9]++;
	   }
	   if ($row['month'] == 'Nov'){
	     $month[10]++;
	   }
	   if ($row['month'] == 'Dec'){
	     $month[11]++;
	   }
		}
		$lAr++;
  }
}
elseif (isset($_POST['run']) && count($_POST['kategori']) < 2) {
	$lAr = 0;
	$produk = $antiXss->xss_clean($_POST["produk"]);
  $kategori = $antiXss->xss_clean($_POST["kategori"][0]);
  $start = $antiXss->xss_clean($_POST["awal"]);
  $end = $antiXss->xss_clean($_POST["akhir"]);

  $query = "SELECT * FROM upload_data
  WHERE
  product_id = '$produk' AND
  kategori = '$kategori' AND
  created_at >= '$start' AND
  created_at <= '$end'
  ";
	$result = mysqli_query($conn, $query);

	$month = array(
   0 => 0, //jan
   1 => 0, //feb
   2 => 0, //mar
   3 => 0, //apr
   4 => 0, //may
   5 => 0, //jun
   6 => 0, //jul
   7 => 0, //aug
   8 => 0, //sep
   9 => 0, //oct
   10 => 0, //nov
   11 => 0 //des
 );

 foreach($result as $row) {
	 if ($row['month'] == 'Jan') {
     $month[0]++;
   }
   if ($row['month'] == 'Feb'){
     $month[1]++;
   }
   if ($row['month'] == 'Mar') {
     $month[2]++;
   }
   if ($row['month'] == 'Apr'){
     $month[3]++;
   }
   if ($row['month'] == 'May') {
     $month[4]++;
   }
   if ($row['month'] == 'Jun'){
     $month[5]++;
   }
   if ($row['month'] == 'Jul') {
     $month[6]++;
   }
   if ($row['month'] == 'Aug'){
     $month[7]++;
   }
   if ($row['month'] == 'Sep'){
     $month[8]++;
   }
   if ($row['month'] == 'Oct'){
     $month[9]++;
   }
   if ($row['month'] == 'Nov'){
     $month[10]++;
   }
   if ($row['month'] == 'Dec'){
     $month[11]++;
   }
  }
}

// Get First value month
foreach ($month as $key) {
  if ($key !== 0) {
    $start_data = $key;
    break;
  } 
  else {
    $start_data = 0;
  }
}

// Get Last value month
for ($i=11; $i > 0; $i--) { 
  if ($month[$i] !== 0) {
    $end_data = $month[$i];
    break;
  }
  else {
    $end_data = 0;
  }
}

if ($start_data == NULL && $end_data == NULL || $start_data == 0 && $end_data == 0) {
	$resultStatistik = 0;
} else {
  $resultStatistik = ($end_data / $start_data) - 2;
  $resultStatistik = round($resultStatistik,2);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="REPORTING PORTAL HALO BCA">
	<meta name="author" content="Quarte">
	<link rel="shortcut icon" href="../../resources/img/favicon.png">

  <title>Result | Quartee</title>

  <!-- Custom fonts for this template-->
  <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../resources/css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
    <i class="fas fa-bars"></i>
    </button>
    <a class="navbar-brand ml-1" href="../home">Quartee</a>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto">

      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i> <?= $_SESSION['data']['name']?>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="#"><?= $_SESSION['data']['name']?></a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="../home">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb mb-3">
          <li class="breadcrumb-item"><a href="../home">Back</a></li>
        </ol>

				<!-- MULTI ARRAY -->
        <?php if(count($_POST['kategori']) >1) : ?>
					<?php $kat = implode(",",$_POST['kategori']); ?>
					<a href="export.php?produk=<?=$produk ?>&kategori=<?= $kat ?>&awal=<?= $start?>&akhir=<?= $end?>" class="btn btn-primary mb-5" target="_blank">Export Excel</a>
        <!-- Area Chart Example-->
        <div class="card mb-5">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Statistik</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
        </div>

        <!-- Statistik -->
        <div class="row mb-5">
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Compl</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultData('COMPL/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Inf</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultData('INF/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Req</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultData('REQ/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Saran</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultData('SARAN/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
        </div>

        <div class="row mb-5">
          <div class="col-sm-6">
            <!-- Pencapaian dan Penurunan -->
            <div class="card">
              <div class="card-header">
                Pencapaian dan Penurunan
              </div>
              <div class="card-body py-5">
                <p>plus (+) adalah peningkatan , Minus (-) adalah penurunan</p>
                <h1><?= $resultStatistik; ?>%</h1>
              </div>
            </div>  
          </div>

          <!-- Recomendasi -->
          <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Recomendations
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>compl</b> <?= $produk ?></p>
                            <a href="compl.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>Req</b> <?= $produk ?></p>
                            <a href="req.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>Inf</b> <?= $produk ?></p>
                            <a href="inf.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>Saran</b> <?= $produk ?></p>
                            <a href="saran.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
          </div>
        </div>

        <div class="card mb-3" id="card">
            <div class="card-header">
            <i class="fas fa-table"></i>
            Result</div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Priode</th>
                            <th>Jumlah</th>
                            <th>Product</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
											<?php for ($i=0; $i < $lAr; $i++):  ?>
												<?php foreach ($result[$i] as $row): ?>
             
														<tr>
															<td><?php echo $row['month'] ?></td>
															<!-- Counting -->
                                <?php if($row['month'] == 'Jan') : ?>
                                <td><?= $month[0] ?></td>
                                <?php elseif($row['month'] == 'Feb') : ?>
                                <td><?= $month[1] ?></td>
                                <?php elseif($row['month'] == 'Mar') : ?>
                                <td><?= $month[2] ?></td>
                                <?php elseif($row['month'] == 'Apr') : ?>
                                <td><?= $month[3] ?></td>
                                <?php elseif($row['month'] == 'May') : ?>
                                <td><?= $month[4] ?></td>
                                <?php elseif($row['month'] == 'Jun') : ?>
                                <td><?= $month[5] ?></td>
                                <?php elseif($row['month'] == 'Jul') : ?>
                                <td><?= $month[6] ?></td>
                                <?php elseif($row['month'] == 'Aug') : ?>
                                <td><?= $month[7] ?></td>
                                <?php elseif($row['month'] == 'Sep') : ?>
                                <td><?= $month[8] ?></td>
                                <?php elseif($row['month'] == 'Oct') : ?>
                                <td><?= $month[9] ?></td>
                                <?php elseif($row['month'] == 'Nov') : ?>
                                <td><?= $month[10] ?></td>
                                <?php elseif($row['month'] == 'Dec') : ?>
                                <td><?= $month[11] ?></td>
                                <?php endif; ?>
															<td><?php echo $row['product_id'] ?></td>
															<td><?php echo $row['kategori'] ?></td>
														</tr>
												<?php endforeach;?>
											<?php endfor; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        <?php endif; ?>
				<!-- END MULTI ARRAY -->

				<!-- SINGLE ARRAY -->
				<?php if(count($_POST['kategori']) <2) : ?>
        <a href="export.php?produk=<?=$produk ?>&kategori=<?= $kategori?>,&awal=<?= $start?>&akhir=<?= $end?>" class="btn btn-primary mb-5" target="_blank">Export Excel</a>

        <!-- Area Chart Example-->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Statistik</div>
          <div class="card-body">
            <canvas id="myAreaChart" width="100%" height="30"></canvas>
          </div>
        </div>

        <!-- Statistik -->
        <div class="row mb-5">
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Compl</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultDataOne('COMPL/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Inf</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultDataOne('INF/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Req</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultDataOne('REQ/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
          <div class="col-lg-3">
              <div class="card">
                  <div class="card-header">
                      Statistik Pekembangan
                  </div>
                  <div class="card-body">
                      <p>Total <b>Saran</b> <?= $produk ?></p>
                      <h4 class="text-success"><?= getAllResultDataOne('SARAN/',$produk,$start,$end);?></h4>
                  </div>
              </div>
          </div>
        </div>


                <div class="row mb-5">
          <div class="col-sm-6">
            <!-- Pencapaian dan Penurunan -->
            <div class="card">
              <div class="card-header">
                Pencapaian dan Penurunan
              </div>
              <div class="card-body py-5">
                <p>plus (+) adalah peningkatan , Minus (-) adalah penurunan</p>
                <h1><?= $resultStatistik; ?>%</h1>
              </div>
            </div>  
          </div>

          <!-- Recomendasi -->
          <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Recomendations
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>compl</b> <?= $produk ?></p>
                            <a href="compl.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>Req</b> <?= $produk ?></p>
                            <a href="req.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>Inf</b> <?= $produk ?></p>
                            <a href="inf.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <p>TOP 10 <b>Saran</b> <?= $produk ?></p>
                            <a href="saran.php?produk=<?= $produk ?>">
                              <span class="badge badge-primary badge-pill">Klik Here</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
          </div>
        </div>

        <div class="card mb-3" id="card">
            <div class="card-header">
            <i class="fas fa-table"></i>
            Result</div>
            <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Priode</th>
                            <th>Jumlah</th>
                            <th>Product</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=0; foreach($result as $row) : ?>
                            <tr>
                                <td><?= $row['month']?></td>
                                <!-- Counting -->
                                <?php if($row['month'] == 'Jan') : ?>
                                <td><?= $month[0] ?></td>
                                <?php elseif($row['month'] == 'Feb') : ?>
                                <td><?= $month[1] ?></td>
                                <?php elseif($row['month'] == 'Mar') : ?>
                                <td><?= $month[2] ?></td>
                                <?php elseif($row['month'] == 'Apr') : ?>
                                <td><?= $month[3] ?></td>
                                <?php elseif($row['month'] == 'May') : ?>
                                <td><?= $month[4] ?></td>
                                <?php elseif($row['month'] == 'Jun') : ?>
                                <td><?= $month[5] ?></td>
                                <?php elseif($row['month'] == 'Jul') : ?>
                                <td><?= $month[6] ?></td>
                                <?php elseif($row['month'] == 'Aug') : ?>
                                <td><?= $month[7] ?></td>
                                <?php elseif($row['month'] == 'Sep') : ?>
                                <td><?= $month[8] ?></td>
                                <?php elseif($row['month'] == 'Oct') : ?>
                                <td><?= $month[9] ?></td>
                                <?php elseif($row['month'] == 'Nov') : ?>
                                <td><?= $month[10] ?></td>
                                <?php elseif($row['month'] == 'Dec') : ?>
                                <td><?= $month[11] ?></td>
                                <?php endif; ?>
                                <td><?= $row['product_id']?></td>
                                <td><?= $row['kategori']?></td>
                            </tr>
                            <?php $i++;?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        <?php endif; ?>
				<!-- END SINGLE ARRAY -->
      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Quartee 2019</span>
          </div>
        </div>
      </footer>

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout">Logout</a>
        </div>
      </div>
    </div>
  </div>


  <!-- Bootstrap core JavaScript-->
  <script src="../../vendor/jquery/jquery.min.js"></script>
  <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="../../vendor/chart.js/Chart.min.js"></script>
  <script src="../../vendor/datatables/jquery.dataTables.js"></script>
  <script src="../../vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../resources/js/sb-admin.min.js"></script>
   <script src="../../resources/js/demo/datatables-demo.js"></script>
   <script>
   // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#292b2c';

  // Area Chart Example
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [{
        label: "Sessions",
        lineTension: 0.3,
        backgroundColor: "rgba(2,117,216,0.2)",
        borderColor: "rgba(2,117,216,1)",
        pointRadius:7,
        pointBackgroundColor: "rgba(2,117,216,1)",
        pointBorderColor: "rgba(255,255,255,0.8)",
        pointHoverRadius: 5,
        pointHoverBackgroundColor: "rgba(2,117,216,1)",
        pointHitRadius: 50,
        pointBorderWidth: 2,
        data: [
        <?= $month[0] ?>, <?= $month[1] ?>, <?= $month[2] ?>,
        <?= $month[3] ?>, <?= $month[4] ?>, <?= $month[5] ?>,
        <?= $month[6] ?>, <?= $month[7] ?>, <?= $month[8] ?>,
        <?= $month[9] ?>, <?= $month[10] ?>, <?= $month[11] ?>
        ],
      }],
    },
    options: {
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 10
          },
          gridLines: {
            color: "rgba(0, 0, 0, .125)",
          }
        }],
      },
      legend: {
        display: false
      }
    }
  });

  </script>
</body>

</html>
