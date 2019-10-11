<?php

    include('../db/database.php');

?>



<!doctype html>

<html lang="en" class="fullscreen-bg">



<head>

    <title>Registrieren</title>

    <?php include('include/meta.php'); ?>

	 <meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

	<!-- VENDOR CSS -->

	<link rel="stylesheet" href="../css/bootstrap.min.css">

	<link rel="stylesheet" href="../vendor/font-awesome/css/font-awesome.min.css">

	<link rel="stylesheet" href="../vendor/linearicons/style.css">

	<!-- MAIN CSS -->

	<link rel="stylesheet" href="../css/main.css">

	<!-- GOOGLE FONTS -->

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">

	<!-- ICONS -->

	<link rel="apple-touch-icon" sizes="76x76" href="../img/apple-icon.png">

	<link rel="icon" type="image/png" sizes="96x96" href="../img/favicon.png">

	<style>

       @font-face { font-family: 'meine-schrift';
             src: url('../fonts/Raleway-Medium.ttf') format('truetype'); }

	   body{
			background-color: white;
			font-size: 1.2em;
			font-family: meine-schrift;
			color: black;
		}

		.text-primary{
			padding-left: 14%;
			color: #383838;
		}

		.lead{
		}

		input{
			margin-left: 14.5%;
		}

		.form-control{
			width: 70%;
			margin-top: 1.5%;
		}

		#all{
			margin-top: 5%;
			font-size: 12px;
		}

		.left{
			text-align: center;
		}

		.wrapper{
			margin-top: 0%;
		}

		#loginBtn{
			width: 30%;
			height: 30px;
			font-size: 12px;
			margin-left: 35%;
			float: left;
			color: #fff;
			margin-top: 5%;
			background-color: #a4338a;
			border-radius: 5%;
		}

/* linker Button*/

		#btnLeft{
			float:left;
			margin-left: 10%;
			background-color: Honeydew;
		}

/* Rechter Button*/

		#btnRight{
			float:right;
			margin-right: 10%;
			background-color: Honeydew;
		}

/* Links und rechts */

		#btnRight,#btnLeft{
			text-align: center;
			width: 30%;
			height: 25px;
			font-size: 12px;
			color: #a4338a;
			background-color: #ffffff;
			border-radius: 5%;
			box-shadow: 0 5px 5px -5px #333;
			position: relative;
			margin-bottom: 2%;
		}

		#btnRight:hover, #btnLeft:hover{
			transition: background 2s #383838;
			-webkit-box-shadow: 0px 9px 2px #a4338a;
			-moz-box-shadow: 0px 9px 2px #a4338a;
			box-shadow: 0px 0px 9px #a4338a;
		}

		#rM, #bId, #email, #pw0, #pw1{
			font-size: 12px;
			padding-top: 7px;
		}

		.control-label sr-only{
			font-size: 12px;
			padding-left: 7px;
		}

		#signin-email{
			font-size: 12px;
			padding-left: 7px;
		}

		#signin-password{
			font-size: 12px;
			padding-left: 7px;
		}

		.text-left{
			margin-left: 15%;
			font-size: 12px;
		}

		.form-group{
			margin-top: -15px;
		}

		.cursor{
			position: absolute;
			top: 5%;
			right: 25%;
			left: 25%;
			bottom: 5%;
			font-size: 25px;
		}

		</style>
</head>

<body>

    <?php

    function rndCode() {
        if (phpversion() == '5.6.36') {
			$bytes = openssl_random_pseudo_bytes(16, $cstrong);
			return bin2hex($bytes);
		} else {
			return bin2hex(random_bytes(16));
		}
    }

    if(isset($_GET['register'])) {
        $error = false;
        $email = $_POST['email'];
        $passwort1 = $_POST['passwort1'];
        $passwort2 = $_POST['passwort2'];
		$beraterID = $_POST['beraterID'];
		echo $error."   ".$email."<br>".$passwort1."   ".$beraterID;

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Bitte eine gültige E-Mail-Adresse eingeben<br>';
            $error = true;
        }

        //Überprüfe, dass die E-Mail-Adresse noch nicht registriert wurde
        if(!$error) {
            $statement = $pdo->prepare("SELECT E_Mail FROM user WHERE E_Mail = :email");
            $result = $statement->execute(array('email' => $email));
            $user = $statement->fetch();
			
			if($user !== false) {
               	echo "<script type=text/javascript>";
            	echo "if(confirm('Diese E-Mail-Adresse ist bereits vergeben, hast du dein Passwort vergessen?')){window.location.href = 'vergessen.php';}";
            	echo "</script>";
                $error = true;
            }
        }

        //pruefe ob Passwort1 = Passwort2

        if($passwort1 != $passwort2) {
            $error = true;
            echo "<script type=text/javascript>";
            echo "if(!alert('Passwörter sind nicht identisch!')){window.location.href = 'register.php';}";
            echo "</script>";
        } else {
            //Keine Fehler, wir können den Nutzer registrieren
            if(!$error) {
                $passwort_hash = password_hash($passwort1, PASSWORD_DEFAULT);
                $code = rndCode();
                // Eintrag in user wird erstellt
				$statement = $pdo->prepare("INSERT INTO user (ID, E_Mail, BeraterID) VALUES (?,?,?)");
				$result1 = $statement->execute(array(null ,$email, $beraterID));
				if($result1) {
                	// Eintrag in user_passwort wird erstellt
                    $statement = $pdo->prepare("INSERT INTO user_passwort (ID, Passwort, Bestaetigung) VALUES (?,?,?)");
					$result2 = $statement->execute(array(null ,$passwort_hash, $code));
                    if($result2) {
                    	// Eintrag in user_passwortvergessen
						$statement = $pdo->prepare("INSERT INTO user_passwortvergessen (ID,Code) VALUES (?,?)");
						// print_r($statement);
						$result3 = $statement->execute(array(null,null));
                        // Eintrag in user_interessen
                        // Werte auf 0 gesetzt, abgesehen von ID, die standardmäßig auf auto increment steht
                        $statement2 = $pdo->prepare("INSERT INTO user_interessen (ID, Vorsorge, Versicherung, Foerderung, Policen) VALUES (?,?,?,?,?)");
                        $result4 = $statement2->execute(array(null,0,0,0,0));
                        if($result3 && $result4) {
// !!!!!!!!!
                        	//alert gibt bestätigung
                        	//weiterleitung wird ausgelöst durch deaktiveieren des alerts
                        	//mögliche probleme -> deaktiviertes javascript
                        	echo "<script type=text/javascript>";
                            echo "if(!alert('Bitte bestätige den Link, der dir soeben mit einer E-Mail zugeschickt wurde umd die Registrierung abzuschließen.')){window.location.href = 'page-login.php';}";

                            echo "</script>";

                            $betreff = 'Willkommen bei Vertragsengel';
                            $absender = "Mika Engel <it@vertragsengel.de>";
                            // $text = "Hallo, <br>um deine Registrierung abzuschließen, bestätige bitte folgenden Link: <br><br>
                         // <a href='http://app.vertragsengel.de/forms/register2.php?code=".$code;
                         // above link will change to bellow temporarly
                         $text = "Hallo, <br>um deine Registrierung abzuschließen, bestätige bitte folgenden Link: <br><br>
                      <a href='localhost/va/forms/register2.php?code=".$code;
                         	$text .= "'>Bestätigung</a> <br><br> Vielen Dank, <br>Dein Vertragsengel-Team";
                         	$text .= "<p style='font-size:0.5em'>Diese E-Mail wurde automatisch erstellt.";
                         	//header
                         	$headers   = array();
							$headers[] = "MIME-Version: 1.0";
							$headers[] = "Content-type: text/html; charset=utf-8";
							$headers[] = "From: {$absender}";
							// falls Bcc benötigt wird
							// $headers[] = "Bcc: Der Da <mitleser@example.com>";
							$headers[] = "Reply-To: {$absender}";
							$headers[] = "Subject: {$betreff}";
							$headers[] = "X-Mailer: PHP/".phpversion();
                            mail($email, $betreff, $text, implode("\r\n",$headers));
                        } else {
                        	echo "<script type=text/javascript>";
                            echo "alert('Beim Abspeichern ist leider ein Fehler aufgetreten')";
                            echo "</script>";
                        }
                    }
                }
            }
        }
    } ?>

	<div class="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="left">
					<div class="content">
						<div class="header">
								<div id="logo" class="logo text-center"><img src="../img/logo2.png" alt="Vertragsengel Logo" width="180" height="70"></div>
						</div>
						<form id="all" action="?register=1" method="post">
								<div class="form-group">
										<p class="text-left">Bitte eine gültige Email-Adresse eingeben:</p>
										<input id="email" class="form-control" type="email" name="email" placeholder="E-Mail-Adresse"><br>
								</div>
								<div class="form-group">
										<p class="text-left">Berater ID</p>
										<input id="bId" class="form-control" type="beraterID" name="beraterID" placeholder="Wer hat dich beraten?"><br>
								</div>
								<div class="form-group clearfix">
										<p class="text-left">Bitte Passwort eingeben und wiederholen:</p>
										<input id="pw0" class="form-control" type="password" name="passwort1" placeholder="Passwort eingeben">
										<input id="pw1" class="form-control" type="password" name="passwort2" placeholder="Passwort bestätigen"><br>
									<button id="loginBtn" id="btnS" type="submit" value="Abschicken" >Registrieren</button>
								</div>
						</form>
						<a  id="btnLeft"  href="../index.php" ><i class="fa fa-arrow-circle-left cursor"></i></a>
						<a  id="btnRight" href="page-login.php">Einloggen</a>
					</div>
				<div class="clearfix"></div>
			</div>
		</div>
		</div>
	</div>
			<script src="../vendor/jquery/jquery.min.js"></script>
			<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
			<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
			<script src="../js/klorofil-common.js"></script>
    </body>
</html>