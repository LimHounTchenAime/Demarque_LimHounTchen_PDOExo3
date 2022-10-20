<?php
	header('Location: ../tdloc.php');
	session_start();
	use src\Factory\ConnectionFactory as Connection;
	Connection::setConfig();
	$bdd = Connection::connexion();

	$q->prepare('Update Calendrier Set paslibre = 'x' Where no_imm = ? and datejour between ? and ?');
	$q->bindParam(1,$_POST['imm']);
	$q->bindParam(2,$_POST['date1']);
	$q->bindParam(3,$_POST['date2']);

	$res = $res . $q->execute() . ' ligne(s) total modifiée(s) <br>'."\n";

	$_SESSION['req'] = $res;

?>