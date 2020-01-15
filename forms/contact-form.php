<?php
include('../db/database.php');
    $statement = $pdo->prepare("SELECT * FROM user WHERE ID = ?");
	$statement->execute(array($_SESSION['userID']));
    $user = $statement->fetch();

        $to = "Bielin1964@interia.pl";
		$msg = wordwrap($_POST['msg'], 70);
		$titel = $_POST['titel'];
		$headers = 'From: ' . $user['E_Mail'] . "\r\n" .
        'Reply-To: ' . $user['E_Mail'] . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

		mail($to, $titel, $msg, $headers);
?>