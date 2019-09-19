<?php
session_start();
session_destroy();
 
//Cookies entfernen
setcookie("identifier","",time()-(3600*24*365)); 
setcookie("security","",time()-(3600*24*365));

holding();


function holding() {
	header("refresh:1; ../index.php");
}
?>