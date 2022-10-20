<?php
	header('Location: ../src/index.php?action=location');
	session_start();
	use src\Factory\ConnectionFactory as Connection;

	class location{
        Connection::setConfig();
        $bdd = Connection::connexion();

        $res = "";

        $q = $bdd->prepare('Select Sum(?*tarif_jour) as montant From (Vehicule V Inner join Categorie C On V.code_categ=C.code_categ) Inner join Tarif T On C.code_tarif = T.code_tarif Where modele=?');
        $q->bindParam(array($_POST['nb']),$_POST['modele']);
        $q->execute();
        while($data=$q->fetch()){
            $res = $res . $data['montant'] . ' € <br>'."\n";
        }

        $_SESSION['res'] = $res;
	}
?>