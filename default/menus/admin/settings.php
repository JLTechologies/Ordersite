<html lang="en">
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" href="./favicon.jpg" type="image/x-icon">
    <?php
        include ('./required.php');
        session_start();
		$_SESSION['message'] = '';
		
	include('./queries.php');
	
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
    <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
    <link rel="stylesheet" href="./dist/css/adminlte.min.css">
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
    <a href="./index.php" class="brand-link">
      <img src="./logo.jpg" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
            <a href="./" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="./orders/" class="nav-link">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>
                Orders
              </p>
            </a>
          </li>
		  <li class="nav-item">
            <a href="./tables/" class="nav-link">
              <i class="nav-icon fas fa-industry"></i>
              <p>
                Tables
              </p>
            </a>
          </li>
		  <li class="nav-item">
			<a href="./settings.php" class="nav-link active">
				<i class="nav-icon fas fa-th"></i>
				<p>
					Settings
				</p>
			</a>
			</li>
			<li class="nav-item">
			<a href="./users/" class="nav-link">
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
              <li class="breadcrumb-item active">Settings</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-6">
            <?php
			  $getsettings = "SELECT * FROM settings";
			  
			  $settings = mysqli_query($conn, $getsettings);
				if (! $settings) {
					die('Kon site naam niet inladen: '.mysqli_error($conn));
				}
				while($row = mysqli_fetch_assoc($settings)) {
					$sitename = htmlspecialchars($row['sitename']);
					$active = htmlspecialchars($row['active']);
				}
				?>
			  
			  <form role="form" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
              	<div>
                	<div class="card card-primary">
                		<div class="card-body">
							<div class="form-group">
                        		<label for="sitename" class="control-label">Sitename</label>
                        		<div>
                            		<input type="text" autocomplete="off" name="sitename" value="<?php echo $sitename;?>" class="form-control"/>
                            	</div>
							</div>
                            <div class="form-group">
                            	<label for="active" class="control-label">Site Active?</label>
                            	<div>
                            		<select name="active" class="form-control">
										<?php 
											if($active == "true") {?>
												<option value="true">Ja</option>
												<option value="false">Nee</option>
											<?php }
										else { ?>
											<option value="false">Nee</option>
											<option value="true">Ja</option>
										<?php }
										?>
									</select>
                                </div>
                            </div>							
                            <div class="box-footer">
								<button type="submit" class="btn btn-success btn-sm">Update Site</button>
                            </div>
						</div>
					</div>
				</div>
			  </form>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- Default to the left -->
	<?php include('./footer.php'); ?>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="./plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="./plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>
<?php
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		$newsitename = $conn->real_escape_string($_POST['sitename']);
		$newactive = $conn->real_escape_string($_POST['active']);
			
        $updatesetting = "UPDATE settings SET sitename = '$newsitename', active = '$newactive'";
		
		if ($conn->query($updatesetting) === true) {
            header("location: ./settings.php");
        }
        else {
            $_SESSION['message'] = "Update kon niet worden uitgevoerd.";
			header("location: ./settings.php");
        }
        mysqli_close($conn);
	}
	?>
</html>