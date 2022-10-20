<?php
	header('Location: ../src/index.php?action=reservations');
	session_start();
	use src\Factory\ConnectionFactory as Connection;
	Connection::setConfig();
	$bdd = Connection::connexion();

	$q->prepare('Update Calendrier Set paslibre = 'x' Where no_imm = ? and datejour between ? and ?');
	$q->bindParam(1,$_POST['immatriculation']);
	$q->bindParam(2,$_POST['dateD']);
	$q->bindParam(3,$_POST['dateF']);

	$res = $res . $q->execute() . ' ligne(s) total modifiée(s) <br>'."\n";

	$_SESSION['res'] = $res;

?>