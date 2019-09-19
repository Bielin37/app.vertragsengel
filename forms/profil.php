<?php
	include('../db/database.php');
	include('include/logged.php');

?>

<!DOCTYPE html>
<html lang="de">
	<head>    
		<title>Profil vervollständigen</title>
		<?php include('include/meta.php'); ?>
	<style>
	@font-face { font-family: 'meine-schrift';
				 src: url('../fonts/Raleway-Medium.ttf') format('truetype'); }
		
		
		h1{
			font-size: 		16px;
			font-family:	meine-schrift;
		}
		
		h2{
			font-size: 		14px;
			font-family: 	meine-schrift;
		}
		
		body{
			font-family: 	meine-schrift;
			font-size: 		12px;
			color: 			#383838;
		}
		
	
		#wrapper{
			margin-top: 30%;
			margin-bottom: 30%;	
		}
			
		#name, #vorname, #geburtsdatum, #beruf, #hiddenBeruf
		{
			height: 30%;
			width: 80%;
			margin-left: 2%;
			margin-bottom: 3%;
			border: 1px solid #383838;
			padding-left: 2%;
			
		}
		
		#geburtsdatum, #beruf{
			background-color: white;
		}
		
		#kinderAnzahl, #beraterID {
			height: 30%;
			width: 60%;
			margin-left: 2%;
			margin-bottom: 3%;
			padding-left: 2%;
		}
		

	
	
	</style>
	
	</head>

<body>

	<div id="wrapper">
			<nav class="navbar navbar-default navbar-fixed-top">
			<div>
				<h1>persönliche Daten</h1>
			</div>
		</nav>
		<div class="row" id="profil">
				<div class="col-md-4">

					<?php 
						$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ".$_SESSION['userID']);
						$statement->execute(array());
						$userData = $statement->fetch();
					?>
		
    
					<form action="sendRequest.php" method="post">		
						
						<p>E-Mail:<?php echo "</br> ".$userData['E_Mail']; ?></p>
						
						
						<?php include('include/profilBasis.php'); ?>
						
						
						
						
						<p>Kinder</p>
						<!-- Inputfelder für die Angabe des Alters der jeweiligen Kinder werden über den +-Button hinzugefügt -->
						<!-- eventuell nicht die beste Lösung, sollte besser automatisch und ohne Button passieren -->
						<div id="kinderAnzahl">
							<input type="number" min="0" step="1" id="anzahlKinder" placeholder="Kinder?">
							<input type="button" value="+" class="addChild" onclick="insertInputFieldChild('kinderAnzahl')">
						</div>
						
						
						<p>Wer hat Sie beraten?</p>
						<input type="text" id="beraterID" name="beraterID" placeholder="Berater-ID">
						<input type="submit" name="submit_profil" value="Fertig">
						
						
					</form>
				</div>
		</div>
	</div>
	<?php
		include('include/footer.php');
	?>
</body>