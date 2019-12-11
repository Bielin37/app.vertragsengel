<?php
	// in database.php ist Variable $blacklist enhalten
	// die Elemente dieses Arrays enthalten die Namen der Spalten, die in den Vertragsdetails nicht angezeigt werden sollten
	// für Stromverträge sind beispielsweise auch die Werte der Engel ausgeklammert
	include('../db/database.php');
	include('./include/logged.php');
?>

<head>
	<title>VertragsDetails</title>
	<?php include('../forms/include/meta.php'); ?>
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
		<!--<div class="main">-->
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
			<!-- Javascript -->
	<!--<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script> -->
	</body>
</html>