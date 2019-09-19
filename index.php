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
        <div id="bootstrap-touch-slider" class="carousel bs-slider fade  control-round indicators-line" data-ride="carousel" data-pause="hover" data-interval="false" >
            
<!--  Indikatoren definiert, class activ auf wert 0 (Erstes Bild) gesetzt. -->			
			<ol class="carousel-indicators">
                <li data-target="#bootstrap-touch-slider" data-slide-to="0" class="active"></li>
                <li data-target="#bootstrap-touch-slider" data-slide-to="1"></li>
                <li data-target="#bootstrap-touch-slider" data-slide-to="2"></li>
				<li data-target="#bootstrap-touch-slider" data-slide-to="3"></li>
				<li data-target="#bootstrap-touch-slider" data-slide-to="4"></li>
				<li data-target="#bootstrap-touch-slider" data-slide-to="5"></li>
			</ol>
           
<!--  Erstes Bild und Text im Silder, durch  class= item activ definiert -->
		   <div class="carousel-inner" role="listbox">
                <div class="item active">
                   <!--  Verlinkung zum 1.Bild -->
				   <img src="img/slider1_5.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <div class="container">
                        <div class="row">
                            <div class="slide-text slide_style_center">
                               <div class="txt"> 
									</br> </br> 
									<!--  Textbereich -->
									<p>Herzlichen Glückwunsch</p>
									<p>zu deinem digitalen Haushaltsordner</p>
							   </div>
							   </br>
							</div>
                        </div>
                    </div>
                </div>

<!--  Zweites Bild und Text im Silder -->
                <div class="item">
                    <!--  Verlinkung zum 2.Bild -->
					<img src="img/slider2_5.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <div class="row">
							<div id="second" class="slide-text slide_style_center">
								<div class="txt"> 
								</br> </br> 
								 <!--  Textbereich -->
								 <p>Ab heute hast du alles übersichtlich</p>
								 <p>in deiner Hosentasche</p>
							</div>
					
						</div>
					</div>
				</div>


<!--  Drittes Bild und Text im Silder -->				
				<div class="item">
                    <!--  Verlinkung zum 3.Bild -->
					<img src="img/slider3_5.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <div class="row">
						<div id="second" class="slide-text slide_style_center">
							 <div class="txt"> 
								</br> </br> 
								 <!--  Textbereich -->
								 <p>Durch den Vertragswecker verpasst</p>
								 <p>du keine Kündigungsfrist mehr</p>
							 </div>
						</div>
					</div>
				</div>
			

<!--  Viertes Bild im Slider -->			
				<div class="item">
                    <!--  Verlinkung zum 4.Bild -->
					<img src="img/slider4_5.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <div class="row">
						<div id="second" class="slide-text slide_style_center">
							<div class="txt"> 
								 </br></br>
								 <!--  Textbereich -->
								 <p>Wir suchen dir Verträge raus,</p>
								 <p>die zu dir passen</p> 
							</div>						
						
						</div>
					</div>
				</div>


<!--  Fünftes Bild im Slider -->				
				<div class="item">
                    <!--  Verlinkung zum 5.Bild -->
					<img src="img/slider5_5.jpg" alt="Bootstrap Touch Slider"  class="slide-image"/>
                    <div class="row">
						<div id="second" class="slide-text slide_style_center">
						  <div class="txt">
								</br></br>
								<!--  Textbereich -->
								<p>Dabei brauchst nicht auf </p>
								<p>persönliche Beratung verzichten</p>
						  </div>
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

<!--  Footer mit Navigation 1. Registrieren (register.php) / 2. Einloggen (page-login.php) -->
			<footer>
				<div class="butns"> <!--  Die Buttons -->
					<a id="btnLeft"   href="forms/register.php" >Registrieren</a>
					<a id="btnRight" href="forms/page-login.php" >Einloggen</a>
				</div>
							   
<!--  Scripts zu den Bootstrap template -->
				<script src="vendor/jquery/jquery.min.js"></script>
				<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
				<script src="vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
				<script src="js/klorofil-common.js"></script>
			</footer>			
    </body>
</html>
<?php } ?>
<!-- End -->
