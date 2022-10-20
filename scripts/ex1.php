<?php
	header('Location: ../src/index.php?action=liste-vehicules');
	include('../src/Factory/ConnectionFactory.php');
	use src\Factory\ConnectionFactory as Connection;
	Connection::setConfig();
	$bdd = Connection::connexion();
	$q = $bdd->prepare('Select no_imm, modele From Vehicule Where code_categ = ? and date_achat between ? and ?');
	$q->bindParam(1, $_POST['categorie']);
	$q->bindParam(2, $_POST['dateD']);
	$q->bindParam(3, $_POST['dateF']);
	$q->execute();
	$res = '';
	while($data=$q->fetch()){
		$res = $res . $data['no_imm']. '	' . $data['modele'].'<br>'."\n";
	}

	$_SESSION['res'] = $res;
?>