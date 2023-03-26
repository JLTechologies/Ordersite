<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="../favicon.jpg" type="image/x-icon">
    <?php
        include ('../required.php');
        session_start();
		$_SESSION['message'] = '';
		
	include('../queries.php');
	
	$name = mysqli_query($conn, $sitename);
	if (! $name) {
		die('Kon site naam niet inladen: '.mysqli_error($conn));
	}
	while($row = mysqli_fetch_assoc($name)) {?>
		<title>Admin | <?php $site = htmlspecialchars($row['sitename']); echo $site ;?></title>
	<?php }
	?>


  <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" href="../">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../index.php" class="brand-link">
      <img src="../logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo $site; ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="../" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="../orders/" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Orders
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="./" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Tables
              </p>
            </a>
          </li>
		  <li class="nav-item">
			<a href="../settings.php" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Settings
				</p>
			</a>
			</li>
			<li class="nav-item">
			<a href="../users/" class="nav-link">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Users
				</p>
			</a>
			</li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="./">Admin</a></li>
              <li class="breadcrumb-item active">Tables</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <form action="<?php $_SERVER['PHP_SELF'];?>" method="post">
                <div class="card card-primary">
                    <div class="card-header with-border">
						<h3 class="card-title">Create Table</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="tablenumber" class="control-label">Table Number</label>
                            <div>
                                <input type="text" autocomplete="off" name="tablenumber" placeholder="Table Number" class="form-control" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <div>
                                <div>
									<input type="text" autocomplete="off" name="description" placeholder="Description" class="form-control" required/>
								</div>
                            </div>
                        </div>
                        <div class="box-footer">
    	        			<button type="submit" class="btn btn-success btn-sm">Add Table</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
	<?php include('../footer.php'); ?>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tablenumber = $conn->real_escape_string($_POST['tablenumber']);
    $description = $conn->real_escape_string($_POST['description']);
		
    $addtable = "INSERT INTO tables (number, description)"
            . "VALUES ('$tablenumber', '$description')";

	if ($conn->query($addtable) === true) {
		$_SESSION['message'] = "Tafel is succesvol toegevoegd";
				echo "<script>location.href = './success.php';</script>";
        	}
        	else {
           		echo "<script>location.href = './index.php';</script>";
        	}
  mysqli_close($conn);
}
?>
<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>