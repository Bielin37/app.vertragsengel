<?php
	include('../db/database.php');
	// in database.php ist Variable $blacklist enhalten
	// die Elemente dieses Arrays enthalten die Namen der Spalten, die in den Vertragsdetails nicht angezeigt werden sollten
	// für Stromverträge sind beispielsweise auch die Werte der Engel ausgeklammert
	include('include/logged.php');
?>

<head>
	<title>VertragsDetails</title>
	<?php include('include/meta.php'); ?>
	<style>
		@font-face { font-family: 'meine-schrift';
				 src: url('../fonts/Raleway-Medium.ttf') format('truetype'); }
		
		
		h1{
			font-size: 		16px;
			font-family:	meine-schrift;
		}
		
		body{
			font-size: 		14px;
			font-family:	meine-schrift;
		}
		

		.col-md-4{
			margin-top: 15%;
			padding-left: 3%;
			font-size: 12px;
			width: 100%;
			margin-bottom: 10%;
		}
		
		.panel-body{
		
			width: 100%;
		}
		
		.panel-body{
			font-size: 12px;
		}
		
		.main-content{
			margin-top: -80px;
			text-align: left;
			margin-left: 2%;
		}
		.main{
			margin-bottom: 20%;
		}
		.wrapper{
			margin-top: 10%;
			text-align: left;
			padding-left: 3%;
		}
	
			#btnRight{		
			float:right; 		
			margin-right: 2%;	
			background-color: Honeydew;	
			}
			
			/* Links und rechts */	

			#btnRight,#btnLeft{		
			margin-top: -20%;
			text-align: center;		
			width: 40%;			
			height: 25px;		
			padding-top: 1%;
			font-size: 12px;	
			color: red;		
			margin-top: 5%;		
			background-color: #ffffff;		
			border-radius: 5%;			
			box-shadow: 0 5px 5px -5px #333;	
			z-index: 11;

			}	

			#btnRight:hover, #btnLeft:hover{	
			transition: background 2s #383838;	
			-webkit-box-shadow: 0px 9px 2px #a4338a;	
			-moz-box-shadow: 0px 9px 2px #a4338a;	
			box-shadow: 0px 0px 9px #a4338a;		
			}		
		
	</style>
</head> 

<body>	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div>
			<h1> Vertragsdetails</h1></div>
		</nav>
		<!-- END NAVBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<?php
					// Prüfung ob SESSION_ID gesetzt
					if(!isset($_SESSION['userID'])) {
						die('Bitte zuerst <a href="login.php">einloggen</a>');
					}	
					// $v0 - Sparte und $v1 - ID werden via GET übergeben und geben an, welche Vertragsnummer welcher Sparte abgefragt wird
					// SQL SELECT - $vertragsDetails (Daten)
					$statement = $pdo->prepare(
						"SELECT * FROM vertrag_".$sparten[$_GET['v0']]." WHERE ID = ".$_GET['v1']);
					$statement -> execute(array());					
					$vertragDetails = $statement->fetch();
					echo "<br>";
					// SQL SELECT - $columnNames (Spaltennamen)
					$statement = $pdo->prepare(
						"SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = 'vertrag_".$sparten[$_GET['v0']]."'");
					$statement -> execute(array());
					$columnNames = [];		
					while ($columnNames[] = $statement->fetch()) {};

					echo "<table>";
					for ($i=0;$i < count($columnNames)-1;$i++) {
						if(!in_array($columnNames[$i][0],$blacklist)) {
							echo "<tr>";
							echo "<td>".$columnNames[$i][0]."</td>";
							// Werte 0/1 werden durch ja/nein ersetzt
							if ($columnNames[$i][0] == 'Gekuendigt') {
								if ($vertragDetails[$i] == 0) {
									echo "<td>Nein</td>";
								} else {
									echo "<td>Ja</td>";
								}
							continue;
							} 
							// Werte 0/1 werden durch ja/nein ersetzt
							if ($columnNames[$i][0] == 'Jahresbonus') {
								if ($vertragDetails[$i] == 0) {
									echo "<td>Nein</td>";
								} else {
									echo "<td>Ja</td>";
								}
							continue;
							} 
							// Werte 0/1 werden durch ja/nein ersetzt
							if ($columnNames[$i][0] == 'Zusatzversicherung') {
								if ($vertragDetails[$i] == 0) {
									echo "<td>Nein</td>";
								} else {
									echo "<td>Ja</td>";
								}
							continue;

							} else {
								echo "<td>".$vertragDetails[$i]."</td>";
							}
							echo "</tr>";
						}

					}
					echo "</table>";
					$link = 'kuendigung.php?v0='.$_GET['v0'].'&v1='.$_GET['v1'];
					echo "<a href='".$link."'><p id='btnRight' >Vertrag kündigen</p></a>";

					//
					$statement = $pdo->prepare("SELECT Status FROM user_vertrag_".$sparten[$_GET['v0']]." WHERE VertragsID =".$_GET['v1']);
							$statement->execute(array());
							$status = $statement->fetch();
							if ($status[0] == 0 	) {
								echo "<td><p style='color:red'> Vertrag ist bereits gekündigt </p></td>";
							}
				?>
			</div>
		</div>
	</div>
	<!-- END MAIN -->	
	<div class="clearfix"></div>
		<?php include('../forms/include/footer.php'); ?>
			<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
	</body>
</html>