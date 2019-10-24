<?php
	//verwendete Variablen
	//
	//$_SESSION['userID']		globale Variable, enthält userID, wenn eingeloggt
	//$_COOKIE['identifier']	Ziffernfolge aus Cookie
	//$_COOKIE['security']		Ziffernfolge aus Cookie
	//$securityNew				enthält neu zu setzten Wert für security-cookie und Datenbankeintrag
	//
	include('db/database.php');

	//random zeichenfolge um cookies zu füllen
	function rndCode() {
        if (phpversion() == '5.6.36') {
			$bytes = openssl_random_pseudo_bytes(16, $cstrong);
			return bin2hex($bytes);
		} else {
			return bin2hex(random_bytes(16));
		}
    }

	//user ist eingeloggt, wird also weitergleitet zu vertragsuebersicht
	if(isset($_SESSION['userID'])) {
		header('refresh:0, vertragsUebersicht.php');
	}
	//ein user ist nicht eingeloggt, und die cookies sind gesetzt
	if(!isset($_SESSION['userID']) && isset($_COOKIE['identifier']) && isset($_COOKIE['security'])) {
		
		$statement = $pdo->prepare("SELECT * FROM user_securitytoken WHERE Identifier = ?");
		$statement->execute(array($_COOKIE['identifier']));
		$security = $statement->fetch();

		//pruefen ob der security-token der richtige, zum identifier passend, ist
		if(sha1($_COOKIE['security']) !== $security['Securitytoken']) {
			die('Falscher Securitytoken!');

		//wenn ja, dann cookies neu setzen und nutzer einloggen 	
		} else {
			$securityNew = rndCode();
			$statementInsert = $pdo->prepare("UPDATE user_securitytoken SET Securitytoken = ? WHERE Identifier = ".$_COOKIE['identifier']);
			$statementInsert->execute(array($securityNew));
			setcookie("identifier", $_COOKIE['identifier'], time()+3600*24*7*365);
            setcookie("security", $securityNew, time()+3600*24*7*365); 
			$_SESSION['userID'] = $security['ID'];
		}
		//weiterleitung zu vertragsübersicht nach updaten des securitytokens
		header('refresh:0, vertragsUebersicht.php');
	}
	//kein Nutzer eingeloggt, d.h. Seite wird angezeigt
	if(!isset($_SESSION['userID'])) {
?>
<!DOCTYPE html>
<html>
   <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Index Vertragsengel</title>
			<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="all">  <!--  Bootstrap -->
			<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="all">  <!--  Bootstrap -->
			<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css" rel="stylesheet" media="all">  <!--  Bootstrap -->
			<link href="vendor/bootstrap/css/bootstrap-touch-slider.css" rel="stylesheet" media="all">   <!--  Bootstrap -->
			<link rel="stylesheet" href="css/index.css">  <!--  Hier kann auf den style der index zugegriffen werden -->
    </head>

    <body>
		<div class="row" style="max-height: 50px;">
		<!--  Die Buttons -->
		<!-- Navigation 1. Registrieren (register.php) / 2. Einloggen (page-login.php) -->
				<a id="btnLeft" href="forms/register.php"><p class="btn-text">Registrieren</p></a>
				<a id="btnRight" href="forms/page-login.php"><p class="btn-text">Einloggen</p></a>
		</div>
		<div class="row" style="width: 100%; height: 90vh;">

		<div class="col-lg-12" style="margin: 0 0 0 0;">
            <div id="my-slider" class="carousel slide" data-ride="carousel" style="width: 100%;" >
              <!--  Indikatoren definiert, class activ auf wert 0 (Erstes Bild) gesetzt. -->			
   
                 <ol class="carousel-indicators" style="background-color: #a4338a;">
                    <li data-target="#my-slider" data-slide-to="0" class="active"></li>
                    <li data-target="#my-slider" data-slide-to="1"></li>
                    <li data-target="#my-slider" data-slide-to="2"></li>
					<li data-target="#my-slider" data-slide-to="3"></li>
                    <li data-target="#my-slider" data-slide-to="4"></li>
                 </ol>
                <!--  Erstes Bild und Text im Silder, durch  class= item activ definiert -->
 
                <div class="carousel-inner" role="listbox" style="position: relative;">
                     <div class="item active">
                         <img class="center-block" style="width:auto; height:auto;" src="img/slider1_5.jpg" alt="carousel" />
                         <div class="carousel-caption" style="position: absolute;">
						 	<h3><p class="carousel-text" style="color: black;">Herzlichen Glückwunsch</p></>
							<h3><p style="color: black;">zu deinem digitalen Haushaltsordner</p></h3>
                         </div>
                     </div>
					 <!--  Zweites Bild und Text im Silder -->

                     <div class="item">
                         <img class="center-block" style="width:auto; height:auto;" src="img/slider2_5.jpg" alt="carousel" />
                         <div class="carousel-caption">
                             <h3><p style="color: black;">Ab heute hast du alles übersichtlich</p></h3>
							 <h3><p style="color: black;">in deiner Hosentasche</p></h3>
                         </div>
                     </div>
					 <!--  Drittes Bild und Text im Silder -->				

                        <div class="item">
                         <img class="center-block" style="width:auto; height:auto;" src="img/slider3_5.jpg" alt="carousel" />
                         <div class="carousel-caption">
                             <h3><p style="color: black;">Durch den Vertragswecker verpasst</p></h3>
							 <h3><p style="color: black;">du keine Kündigungsfrist mehr</p></h3>
                         </div>
                     </div>
					 <!--  Viertes Bild im Slider -->			

					 <div class="item">
                         <img class="center-block" style="width:auto; height:auto;" src="img/slider4_5.jpg" alt="carousel" />
                         <div class="carousel-caption">
                             <h3><p style="color: black;">Wir suchen dir Verträge raus,</p></h3>
							 <h3><p style="color: black;">die zu dir passen</p></h3>
                         </div>
                     </div>
					 <!--  Fünftes Bild im Slider -->				

					 <div class="item">
                         <img class="center-block" style="width:auto; height:auto;" src="img/slider5_5.jpg" alt="carousel" />
                         <div class="carousel-caption">
                             <h3><p style="color: black;">Dabei brauchst nicht auf</p></h3>
							 <h3><p style="color: black;">persönliche Beratung verzichten</p></h3>
                         </div>
                     </div>
                 </div>
         
                   
               </div>
            </div>

        
<!-- Einbindung der Bootstrap-Slider Scripts -->
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.18/jquery.touchSwipe.min.js"></script>
			
			
<!-- Haupt JS File für den Slider. Hier findet man die Funktionen -->
			<script src="js/bootstrap-touch-slider.js"></script>
				<script type="text/javascript">
					$('#bootstrap-touch-slider').bsTouchSlider();
				</script>
		</div>
<!-- Navigation 1. Registrieren (register.php) / 2. Einloggen (page-login.php) -->
				
							   
<!--  Scripts zu den Bootstrap template -->
				<script src="vendor/jquery/jquery.min.js"></script>
				<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
				<script src="vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
				<script src="js/klorofil-common.js"></script>
					
    </body>
</html>
<?php } ?>
<!-- End -->
