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
        
    if (!isset($_SESSION['email'])) {
      $_SESSION['msg'] = "You must log in first";
      header('location: ../login.php');
    }
    if (isset($_GET['logout'])) {
      session_destroy();
      unset($_SESSION['email']);
      unset($_SESSION['success']);
      header("location: ../login.php");
    }
		
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
            <a href="../tables/" class="nav-link">
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
			<a href="./" class="nav-link active">
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
              <li class="breadcrumb-item active">Users</li>
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
          <?php echo $_SESSION['message'];?>
          <form action="<?php $_SERVER['PHP_SELF'] ;?>" method="post">
            <div class="box box-primary">
              <div class="box-header with-border">
                <h3 class="box-title">Lid Toevoegen</h3>
              </div>
              <div class="box-body">
                <div class="form-group">
                  <label for="naam" class="control-label">Naam</label>
                  <div>
                    <input type="text" autocomplete="off" name="naam" placeholder="Naam" class="form-control" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="voornaam" class="control-label">Voornaam</label>
                  <div>
                    <input type="text" autocomplete="off" name="voornaam" placeholder="Voornaam" class="form-control" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="email" class="control-label">Email</label>
                  <div>
                    <input type="email" autocomplete="off" name="email" placeholder="Email" class="form-control" required/>
                  </div>
                </div>
								<div class="form-group">
                  <label for="phone" class="control-label">Phone</label>
                  <div>
                    <input type="text" autocomplete="off" name="phone" placeholder="Phone" class="form-control" required/>
                  </div>
                </div>
								<div class="form-group">
                  <label for="paswoord" class="control-label">Paswoord</label>
                  <div>
                    <input type="password" autocomplete="off" name="paswoord" placeholder="Paswoord" class="form-control" required/>
                  </div>
                </div>
                <div class="form-group">
                  <label for="paswoord2" class="control-label">Verifiëer paswoord</label>
                    <div>
                      <input type="password" autocomplete="off" name="paswoord2" placeholder="Verifiëer paswoord" class="form-control" required/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="indienst" class="control-label">Actief op tapavond?</label>
                  <div>
                    <select name="indienst" class="form-control" required/>
											<option value="true">Ja</option>
											<option value="false">Nee</option>
										</select>
                  </div>
                </div>
                <div class="form-group">
                 	<label for="group" class="control-label">Group</label>
                  <div>
                    <select name="group" class="form-control">
                      <?php
                        $group = 'SELECT * FROM groups';
                        $groups = mysqli_query($conn, $group);

                        if(! $groups) {
                          die('Kon geen groepen inladen: '. mysqli_error($conn));
                        }
                        while($row = mysqli_fetch_assoc($groups)) {
                      ?>
                        <option value="<?php echo $row['groupid']; ?>"><?php echo $row['groupname']; ?></option>
                      <?php   }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="box-footer">
  								<button type="submit" class="btn btn-success btn-sm">Maak gebruiker aan</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
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
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if($_POST['paswoord'] == $_POST['paswoord2']) {
        $naam = $conn->real_escape_string($_POST['naam']);
        $voornaam = $conn->real_escape_string($_POST['voornaam']);
        $geboortdatum = $conn->real_escape_string($_POST['geboortedatum']);
		$email = $conn->real_escape_string($_POST['email']);
		
		$paswoord = $conn->password_hash($_POST['paswoord']);	
        $functie = $conn->real_escape_string($_POST['functie']);
		
        $adduser = "INSERT INTO users (first_name, last_name, email, password, phone, groupid)"
            . "VALUES ('$firstname', '$lastname', '$email', '$password', '$phone', '$groupid')";
		}

        if ($conn->query($adduser) === true) {
            $_SESSION['message'] = "$naam $voornaam has been added to the platform.";
            header("location: ./index.php");
        }
        else {
            $_SESSION['message'] = "Couldn't add user to the platform";
        }
        mysqli_close($conn);
    }

?>

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
</body>
</html>
