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

		#name, #vorname, #geburtsdatum, #beruf, #hiddenBeruf, #mobil, #telefon, #strasse, #plz, #ort
		{
			height: 30%;
			width: 60%;
			margin-left: 2%;
			margin-bottom: 3%;
			border: 1px solid #383838;
			padding-left: 2%;
		}
		
		#geburtsdatum, #beruf{
			background-color: white;
		}
		
		#anzahlKinder, #beraterID, #field1, #field2, #field3, #field4, #field5, 
		#field6, #field7, #field8, #field9, #field10, #field11, #field12, #field13, #field14, #field15, #field16 {
			margin-left: 15%;
			border-radius: 5px 20px 5px;
			border-color: #a4338a;
			text-align: center;
			width: 35%;  
		}

		.fertig-button{
			border-radius: 15px;
			border-color: #92F567;
		}
		.fertig-button:hover{
			border-radius: 15px;
			background-color: #92F567;
			border-color: black;
		}	
	</style>	
	</head>
<body>
	<div>
		<span>
			<h1 class="alert alert-success" style="width: 100vw;">Persönliche Daten</h1>  <!-- Anzeige im Header -->
		</span>
	</div>
	<div id="wrapper" style="display: flex;">
	<div class="navbar-collapse navbar-ex1-collapse" style="min-width: 20%; z-index: 1; padding-right: 20px;">
                <ul class="nav navbar-nav side-nav" style="display: flex; flex-direction: column;">
                    <li>
                        <a href="../vertragsAuswahl.php"><i class="glyphicon glyphicon-th"></i><span class="text">Vertrag Auswahl</span><i class="fa fa-fw fa-caret-down"></i></a>
                    </li>                    
                    <li>
                        <a href="../vertragsUebersicht.php"><i class="glyphicon glyphicon-list-alt"></i><span class="text">Vertrag Ubersicht</span><i class="fa fa-fw fa-caret-down"></i></a>
                    </li>
                    <li>
						<a href="javascript:;" data-toggle="collapse" data-target="#demo1"><i class="glyphicon glyphicon-user"></i><span class="text">Profil</span><i class="fa fa-fw fa-caret-down"></i></a>
							<ul id="demo1" class="collapse">
								<li class="nav-item"><a href="forms/pDaten.php"><i class="glyphicon glyphicon-pushpin"></i><span>Mein Profil</span></a></li>
								<li class="nav-item"><a href="forms/profil.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Alle Daten bearbaiten</span></a></li>
								<li class="nav-item"><a href="vertragspartner.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Partner hinzufügen</span></a></li>
							</ul>
						</li>
                     <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#demo"><i class="glyphicon glyphicon-cog"></i><span class="text">Einstellungen</span><i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="demo" class="collapse">
							<li class="nav-item"><a href="vertragspartner.php"><i class="glyphicon glyphicon-pushpin"></i> <span>Partner hinzufügen</span></a></li>
							<li class="nav-item"><a href="datenschutz.php"><i class="glyphicon glyphicon-info-sign"></i> <span>Datenschutz</span></a></li>
							<li class="nav-item"><a href="agb.php"><i class="glyphicon glyphicon-info-sign"></i> <span>AGB</span></a></li>
							<li class="nav-item"><a href="faq.php"><i class="glyphicon glyphicon-info-sign"></i> <span>FAQ</span></a></li>
							<li class="nav-item"><a href="logout.php"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                        </ul>
                    </li>
                </ul>
    	</div>
		<div class="row" id="profil" style="width: 100vw; display:flex;">
				<div class="col-md-12" style="display: flex; justify-content: center; position: relative; ">

					<?php 
						$statement = $pdo->prepare("SELECT * FROM user WHERE ID = ".$_SESSION['userID']);
						$statement->execute(array());
						$userData = $statement->fetch();
					?>
		
					<form style="display: flex; justify-content: center; flex-direction: column;" action="sendRequest.php" method="post">		
						<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
							<p class="text-1">E-Mail:</p>
							<h5 class="text-1" style="padding-left: 5%;"><?php echo "</br> ".$userData['E_Mail']; ?></h5>
						</div>
						
					<?php include('include/profilBasis.php'); ?>
							
					<div class="row" style="display: flex; width: 80vw; flex-direction: column;">
						<p class="text-1">Kinder</p>
						<!-- Inputfelder für die Angabe des Alters der jeweiligen Kinder werden über den +-Button hinzugefügt -->
						<!-- eventuell nicht die beste Lösung, sollte besser automatisch und ohne Button passieren -->
						<div id="kinderAnzahl">
							<input type="number" min="0" step="1" id="anzahlKinder" placeholder="Kinder?">
							<input type="button" value="+" class="addChild" onclick="insertInputFieldChild('kinderAnzahl')">
						</div>
					</div>
					<div class="row" style="display: flex; width: 80vw; flex-direction: column; margin-bottom: 10%; margin-top: 2%;">	
						<p class="text-1">Wer hat Sie beraten?</p>
							<input type="text" id="beraterID" name="beraterID" placeholder="Berater-ID">
					</div>
						<div class="row" style="display: flex; width: 80vw; flex-direction: column;">	
							<button class="fertig-button alert alert-success" type="submit" name="submit_profil" style=" width: 35%; position: absolute; left: 40%; right: 40%;">	
							Fertig</button>	
						</div>	
					</form>
				</div>
		</div>
	</div>
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>
</body>
</html>