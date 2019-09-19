<?php 
	include('../db/database.php');

	//Kunden
	$statement 	= $pdo->prepare("SELECT * FROM user WHERE ID = ?");
	$statement->execute(array($_SESSION['userID']));
	$user 		= $statement->fetch();

	//Vertragsdetails
	//Vertragssparten (v0) und VertragsID (v1) aus dem GET in Vertragsübersicht
	$statement 	= $pdo->prepare("SELECT * FROM vertrag_".$sparten[$_GET['v0']]." WHERE ID = ?");
	$statement->execute(array($_GET['v1']));
	$vertrag 	= $statement->fetch();

	$statement	= $pdo->prepare("SELECT Ort FROM postleitzahl WHERE PLZ = ?");
	$statement->execute(array($user['PLZ']));
	$ort 		= $statement->fetch();
	//array mit userid, vertragsid, sparte
	$idRay		= array('user'=>$_SESSION['userID'], 'vertragsID'=>$_GET['v1'], 'sparte'=>$_GET['v0']);
	// Array wird global gespeichert
	$_SESSION['test'] = $idRay;

?>

<!doctype html>
<html lang="de">
<head>
	<titel>Kündigung</titel>
	<?php include('include/meta.php'); ?>
	<style>
		/* sowas muss ausgelagert und fuer alle dokumente passend gemacht werden */
	   .wrapper{
		   margin-top: -20%;
	   }
	
	</style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div><h1>Vertrag kündigen</h1></div>
		</nav>
		<!-- END NAVBAR -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="col-md-2">
					<!-- ablage der Unterschrift in Datenbank mittels JavaScript onsubmit -->
					<form action="../db/sendRequest.php" method="post" enctype="multipart/form-data" onsubmit="submitForm()">
						<!-- aus dem Vertrag -->
						<input type="hidden" name="ids" value="<?php $idRay; ?>">
						<p>Kündigungsdatum: </p><input id="nowDate" type="date" name="datum" value=""></br>
						</br>
						<p>Kundennummer:</p><input id="knr" type="text" value="<?php echo $vertrag['Kundennummer'] ?>"></br>
						</br>
						<p>Details: </p><input type="text" id="details" value="<?php echo $vertrag['ID'] ?>"></br>
						</br>
						<p>Vorname: </p><input type="text" id="vorname" value="<?php echo $user['Vorname'] ?>"></br>
						</br>
						<p>Name: </p><input type="text" id="name" value="<?php echo $user['Nachname'] ?>"></br>
						</br>
						<p>Geburtsdatum: </p><input type="text" id="bdateK"  value="<?php echo $user['Geburtsdatum'] ?>"></br>
						</br>
						<p>Telefon: </p><input type="text" id="teleK"  value="<?php echo $user['Telefon'] ?>"></br>
						</br>
						<p>Adresse: </p><input type="text" id="adressK" value="<?php echo $user['Strasse']." ".$user['Hausnummer'] ?>"></br>
						</br>
						<p>Plz: </p><input type="text" id="plzK" value="<?php echo $user['PLZ'] ?>"></br>
						</br>
						<p>Ort: </p><input type="text"  id="ortK" value="<?php echo $ort[0] ?>"></br> 
						</br>
						<p>Grund: </p><textarea name="grund" id="reasonK" cols="4" rows="1">Pls insert nice Anschreiben here</textarea></br>
						</br>
						<p>Unterschrift</p>
						<div id="signature-pad" class="m-signature-pad">
							<div class='m-signature-pad--body'>
	               				<canvas></canvas>
	               				<!-- hier wird die Unterschrift eingefuegt -->
	                			<input type="hidden" name="signature" id="signature" value="">
	            			</div>
	            		</div>
						</br></br>
            			<button type="submit">Absenden</button>
        				<button type="button"onclick="signaturePad.clear();">Löschen</button>
						</br></br>
      					<div class="felder">
      						<p>E-Mail-Bestätigung</p>
      					</div>
							<label class="switch">
								  <input type="checkbox" name="email">
								  <span class="slider round"></span>
							</label>
						
					</form>
					
				</div>
			</div>
		</div>
    </form>
</div>


<!-- weitere Infos zum Unterschriftenfeld @ https://github.com/szimek/signature_pad -->

<script src="../js/signature_pad.js"></script>
<script type="text/javascript">
	var wrapper = document.getElementById("signature-pad"),
	   canvas = wrapper.querySelector("canvas"),
	   signaturePad;

	/**
	*  Behandlung der Größenänderung der Unterschriftenfelds
	*/
	function resizeCanvas() {
	    var oldContent = signaturePad.toData();
	    var ratio =  Math.max(window.devicePixelRatio || 1, 1);
	    canvas.width = canvas.offsetWidth * ratio;
	    canvas.height = canvas.offsetHeight * ratio;
	    canvas.getContext("2d").scale(ratio, ratio);
	    signaturePad.clear();
	    signaturePad.fromData(oldContent);
	}

	function submitForm() {
	    //Unterschrift in verstecktes Feld übernehmen
	    document.getElementById('signature').value = signaturePad.toDataURL();
	}


	var signaturePad = new SignaturePad(canvas);
	signaturePad.minWidth = 1; //minimale Breite des Stiftes
	signaturePad.maxWidth = 5; //maximale Breite des Stiftes
	signaturePad.penColor = "#000000"; //Stiftfarbe
	signaturePad.backgroundColor = "#FFFFFF"; //Hintergrundfarbe

	window.onresize = resizeCanvas;
	resizeCanvas();	

	Date.prototype.toDateInputValue = (function() {
    	var local = new Date(this);
    	local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    	return local.toJSON().slice(0,10);
	});
	document.getElementById("nowDate").value = new Date().toDateInputValue();
	
</script>    
	
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<?php include('include/footer.php'); ?>
	
	</div>	
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="../vendor/jquery/jquery.min.js"></script>
	<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../js/klorofil-common.js"></script>

	</div>
</body>
</html>
