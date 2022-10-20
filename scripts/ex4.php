<?php
	header('Location: ../src/index.php?action=liste-agences');
	session_start();
	use src\Factory\ConnectionFactory as Connection;
	Connection::setConfig();
	$bdd = Connection::connexion();

	$res = "";

	$q = $bdd->query('Select A.code_ag From Agence A Inner Join Vehicule V on A.code_ag = V.code_ag Group by A.code_ag Having Count(Distinct V.code_categ) = (Select Count(code_categ) From Categorie)');

	while($data=$q->fetch()){
		$res = $res . $data['A.code_ag']."<br>\n";
	}

	$_SESSION['res'] = $res;

?>