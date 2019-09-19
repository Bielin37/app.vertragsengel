<?php
	include('../db/database.php');

    function rndCode() {
        if (phpversion() == '5.6.36') {
			$bytes = openssl_random_pseudo_bytes(16, $cstrong);
			return bin2hex($bytes);
		} else {
			return bin2hex(random_bytes(16));
		}
    }
	
	$showForm = true;
 
	if(isset($_GET['send']) ) {

		if(!isset($_POST['email']) || empty($_POST['email'])) {
			$error = "<b>Bitte eine E-Mail-Adresse eintragen</b>";

		} else {
			$statement = $pdo->prepare("SELECT * FROM user WHERE E_Mail = :email");
			$result = $statement->execute(array('email' => $_POST['email']));
			$user = $statement->fetch(); 
			
			if($user === false) {
				$error = "<b>Kein Benutzer gefunden</b>";
			} else {
				$passwortcode = rndCode();
				$passwortSave = sha1($passwortcode);
				echo $passwortSave;

				//Überprüfe, ob der User schon einen Passwortcode hat oder ob dieser abgelaufen ist 
				$statement = $pdo->prepare("UPDATE user_passwortvergessen SET Code = ?, Zeit = NOW() WHERE ID = ?");
				$result = $statement->execute(array($passwortSave, $user['ID']));
				
				$empfaenger = $user['E_Mail'];
				$betreff = "Neues Passwort für deinen Account bei den vertragsengeln";
				$from = "From: Vertragsengel <it@vertragsengel.de>";
				$url_passwortcode = 'http://app.vertragsengel.de/forms/vergessen2.php?userid='.$user['ID'].'&code='.$passwortcode; 
				$text = 'Hallo '.$user['Vorname'].', es wurde eine Änderung deines Passworts beantragt. Um ein neues Passwort zu wählen, klicke bitte auf '.$url_passwortcode.' und gebe ein neues Passwort an. Solltest nicht du eine Änderung beantragt haben, ignoriere diese E-Mail. Mit besten Grüßen, dein vertragsengelteam.';
				 
				mail($empfaenger, $betreff, $text, $from);
				 
				echo "Ein Link um dein Passwort zurückzusetzen wurde an deine E-Mail-Adresse gesendet."; 
				$showForm = false;
			}
		}
	}	 
	if($showForm):
?>
<?php
if(isset($error) && !empty($error)) {
 echo $error;
}
?>

<!doctype html>
<html lang="en">

<head>
	<title>Passwort vergessen</title>
	<?php include('include/meta.php'); ?>
	<style>
		body{
			background-color: white;
		}
		
		h2{
			padding-top: 15px;
			padding-bottom: -15px;
			text-align: center;
		}
		

		footer {
			position: fixed;
			left: 0;
			bottom: 0;
		}
	
		.logo{
			float: center;
		}
		
		.col-md-4{
			padding: 1%;
			font-size: 12px;
			margin-left: -20px;
			width: 120%;
		}
		
	
		
		.panel-body{
			font-size: 12px;
		}
		
	
		
		#wrapper{
			margin-top: 10%;
		}
	</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box lockscreen clearfix">
					<div class="content">
						<h1 class="sr-only">Vertragsengel - Dein Vertragsmanager</h1>
						<div class="logo text-center"><img src="../img/logo2.png" alt="Vertragsengel Logo" width="200" height="85" ></div>
						<div class="user text-center">
							<h2 class="name">Bitte gib deine E-Mail-Adresse ein</h2>
							<p class="text-center text-primary">Ein neues Passwort wird dir umgehend zugeschickt.</p>
						</div>
						<form action="?send=1" method="post">
							<div class="input-group">
								<input type="email" name="email" class="form-control" placeholder="E-Mail ...">
								<span class="input-group-btn"><button type="submit" class="btn btn-primary"><i class="fa fa-arrow-circle-right"></i></button></span>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<footer>
			<a class="btn" style="float:left; padding-left: 15px"  href="" data-animation="animated fadeInLeft">Registrieren</a>
			<a class="btn" style="float:right; padding-right: 15px" href="forms/page-login.php" data-animation="animated fadeInLeft">Einloggen</a>
			<script src="vendor/jquery/jquery.min.js"></script>
			<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
			<script src="vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
			<script src="js/klorofil-common.js"></script>
		</footer>
	<!-- END WRAPPER -->
<?php
	endif;
?>

</body>

</html>
