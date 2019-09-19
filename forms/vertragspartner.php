<?php
	include('../db/database.php');
	include('include/logged.php');
?>

<!DOCTYPE html>
<html lang="de">
	<head>    
		<title>Partner hinzufügen</title>
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
			margin-top: 10%;
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
			text-align: left;
			margin-left: 3%;
		}
		.main{
			margin-bottom: 20%;
		}
		.wrapper{
			text-align: left;
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


<body>
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div><h1>Vertragspartner hinzufügen</h1></div>
		</nav>
		<div class="col-md-4">
		  <div class="main-content">
			<form action="../db/sendRequest.php" method="post">
				<p>E-Mail</p>
				<!--noch sicherstellen, dass es sich wirklich um legitime Adresse handelt (regulärer Ausdruck)-->
				<input type="email" id="email" name="email" placeholder="username@vertragsengel.de">
				<?php
					include('./include/profilBasis.php');
				?>
				<input type="hidden" value="<?php echo $_GET['type']; ?>" name="type">
				<input id="btnRight"type="submit" name="submit_vertragspartner" value="Fertig">
			</form>
		  </div>
		</div>
	</div>
	
	<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>

	<?php include("include/footer.php");?>
	</body>
</html>

