<?php 
    include '../db/database.php'; 

		function rndCode() {
        if (phpversion() == '5.6.36') {
			$bytes = openssl_random_pseudo_bytes(16, $cstrong);
			return bin2hex($bytes);
		} else {
			return bin2hex(random_bytes(16));
		}
    }

	if(isset($_GET['login'])) {
	    $email = $_POST['email'];
	    $passwort = $_POST['passwort'];
	    
	    $statement = $pdo->prepare("SELECT ID FROM user WHERE E_Mail = :email");
	    $result = $statement->execute(array('email' => $email));
	    $user = $statement->fetch();
	    echo $userID;
	        
	    //Überprüfung des Passworts
	    $statement = $pdo->prepare("SELECT * FROM user_passwort WHERE ID = :id");
	    $result = $statement->execute(array('id' => $user['ID']));
	    $passwort_db = $statement->fetch();
	    
	    if ($passwort !== false && password_verify($passwort, $passwort_db['Passwort'])) {
	        
	    	if ($passwort_db['Bestaetigung'] !== "1") {
	    		die("Ihr Profil wurde noch nicht bestätigt!");
	    		header('refresh:2, pagelogin.php');

	    	} else {
		        $_SESSION['userID'] = $user['ID'];
		        
		        	if(isset($_POST['remember'])) {
		        		$security = rndCode();
		        		$identifier = rndCode();

		        		$statement = $pdo->prepare("SELECT Identifier FROM user_securitytoken WHERE UserID = ?");
		        		$statement->execute(array($user['ID']));
		        		$result = $statement->fetch();

		        		if($result) {
		        			$statement = $pdo->prepare("UPDATE user_securitytoken SET Securitytoken = ? WHERE UserID = ".$user['ID']);
			        		$statement->execute(array(sha1($security)));
			        		setcookie("identifier", $result['Identifier'], time()+3600*24*7*365);
			        		setcookie("security", $security, time()+3600*24*7*365); 
		        		} else {
			        		$statement = $pdo->prepare("INSERT INTO user_securitytoken (UserID, Identifier, Securitytoken) VALUES (?,?,?)");
			        		$statement->execute(array($user['ID'], $identifier, sha1($security)));
			        		setcookie("identifier", $identifier, time()+3600*24*7*365);
			        		setcookie("security", $security, time()+3600*24*7*365); 
			        	}
		        	}
		        holding();
		        
		        }
	    } 
	    else {
	        $errorMessage = "E-Mail oder Passwort war ungültig<br>"; 
	        echo $user['ID']."<br>";       
	    }
	}

	function holding() {
	    header("refresh:1; ../vertragsUebersicht.php");
	}


	if(isset($errorMessage)) {
	    echo $errorMessage;
	}
?>

<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
	<title>Login_VertragsengelApp</title>
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
			font-family: meine-schrift;
			color: black;
		}
		
		footer {
            background: #fff;
            width: 100%;
            height: 60px;
            padding-top: 1%;
            position: fixed;
            left: 0;
            bottom: 0;
			border: none;
        }
		main{
			padding-left: 10%;
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
		
		#logo{
			margin-top:-30px;
			margin-bottom: 15%;
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
			margin-left: 4%;
			background-color: Honeydew;
		}
/* Rechter Button*/		
		#btnRight{

			float:right; 
			margin-right: 2%;
			background-color: Honeydew;
		}

/* Links und rechts */			
		
		#btnRight,#btnLeft{
			text-align: center;
			width: 30%;
			height: 25px;
			padding-top: 1%;
			font-size: 12px;
			color: #a4338a;
			margin-top: 5%;
			background-color: #ffffff;
			border-radius: 5%;
			
			
			box-shadow: 0 5px 5px -5px #333;
		}
		
		#btnRight:hover, #btnLeft:hover{
			transition: background 2s #383838;
			-webkit-box-shadow: 0px 9px 2px #a4338a;
			-moz-box-shadow: 0px 9px 2px #a4338a;
			box-shadow: 0px 0px 9px #a4338a;
		}

		#rM{
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
		
		
		</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
					<div class="left">
						<div class="content">
							<div class="header">
								<div id="logo" class="logo text-center"><img src="../img/logo2.png" alt="Vertragsengel Logo" width="180" height="70"></div>
							</div>
							
								<form action="?login=1" method="post" class="form-auth-small">
									<div class="form-group">
										<label for="signin-email" class="control-label sr-only">Email</label>
										<input type="email" name="email" class="form-control" id="signin-email" placeholder="E-Mail" >
									</div>
									<div class="form-group">
										<label for="signin-password" class="control-label sr-only">Password</label>
										<input type="password" name="passwort" class="form-control" id="signin-password" placeholder="Passwort" >
									</div>
									<div class="form-group clearfix">
										</br></br>
										<label class="fancy-checkbox element-left">
											<input type="checkbox"	name="remember" value="1">
											<span id="rM">remember</span>
										</label>
									</div>
									<button id="loginBtn" type="submit" value="Abschicken" >LOGIN</button>
									
								</form>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<footer>
			<a  id="btnLeft"  href="../index.php" ><i class="fa fa-arrow-circle-left"></i></a>
			<a  id="btnRight" href="forms/register.php">Registrieren</a>
			
			<script src="../vendor/jquery/jquery.min.js"></script>
			<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
			<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
			<script src="../js/klorofil-common.js"></script>
		</footer>
	</body>
</html>
