<?php
	header('Location: ../tdloc.php');
	session_start();
	use src\Factory\ConnectionFactory as Connection;
	Connection::setConfig();
	$bdd = Connection::connexion();

	$res = "";

	$q = $bdd->prepare('Select no_imm, modele From Vehicule Where code_categ = ? and date_achat between ? and ?');
	$q->bindParam(1, $_POST['categ']);
	$q->bindParam(2, $_POST['date1']);
	$q->bindParam(3, $_POST['date2']);
	$q->execute();

	while($data=$q->fetch()){
		$res = $res . $data['no_imm']. '	' . $data['modele'].'<br>'."\n";
	}

	$_SESSION['req'] = $res;
?>