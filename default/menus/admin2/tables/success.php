<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel="shortcut icon" href="./img/favicon.jpg" type="image/x-icon">
  <?php 
	include ('../required.php');
	session_start();
  ?>

  <title>Check-In | JH Tjok Hove</title>

  <link rel="stylesheet" href="./css/reset.css">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="./plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="./dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
	
<body>
	<div class="wrapper">
    		<div class="content-header">
      			<div class="container-fluid">
        			<div class="row mb-2">
        				<div class="col-sm-6">
         					<h1 class="m-0 text-dark">check-In JH Tjok Hove</h1>
          					</div>
          					<div>
								<p>Beste Tjok bezoeker, vanwege de corona maatregelen die de veiligheidsraad heeft voorgelegd, zijn wij verplicht om uw gegevens op te vragen en deze gedurende 4 weken bij te houden voor de contacttracing.</p>
        					</div>
        				</div>
      				</div>
    			</div>

    			<div class="content">
					<div class="container-fluid">
						<div class="card card-default">
							<div class="card-body">
            					<div>
									<div class="alert alert-success">
                						<?php echo $_SESSION['message'];
										?>
            					</div>
									<div class="alert alert-danger">
										<h2>Wij sommen alle maatregelen die hier gelden in JH Tjok voor u nog eens op:</h2>
										<ul>
											<li>- Men zit per 5 aan een tafel. Houd in tussen jezelf en mensen die niet aan je tafel zitten <strong>minstens 1.5 meter</strong> afstand. Deze mag tot maximum 10 personen uitgebreid worden indien het mogeijk is om 2 tafes bij elkaar te zetten.</li>
											<li>- Bestel niet aan de toog. De tappers komen om de zoveel tijd langs uw tafel om uw bestelling op te nemen of u kan altijd de tapper roepen om te bestellen.</li>
											<li>- Laat je drank ten allen tijden op tafel staan als u naar het WC gaat. Dit laat ook zien dat de tafel al bezet is.</li>
											<li>- Mondmaskers zijn verplicht bij aankomst, vertrek of wanneer u naar het WC gaat. U mag deze alleen afzetten als u aan een tafel zit.</li>
											<li>- Onderling mengen is niet toegestaan. Eens dat je aan een tafel zet blijf je aan die tafel zitten en wissel je niet van tafel.</li>
											<li>- Was regelmatig je handen met de alcoholgel die wij aanbieden in de gang.</li>
										</ul>
										
									</div>
									Hier kan u zien wat wij allemaal hebben van consumpties in ons Jeugdhuis: <a href="./drinks.php">Dranklijst</a>
        					</div>
						</div>
					</div>	
  				</div>
			</div>
	<footer class="main-footer">
    	<?php include('./required/footer.php');?>
	</footer>

	<script src="./dist/js/adminlte.min.js"></script>
</body>
</html>