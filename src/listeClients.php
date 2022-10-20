<?php

    use src\Factory\ConnectionFactory;
    require_once 'Factory/ConnectionFactory.php';

    session_start();
    use src\Factory\ConnectionFactory as Connection;

    class listeClients{
        #header('Location: ../src/index.php?action=liste-clients');

        Connection::setConfig();
        $bdd = Connection::connexion();

        $res = "";

        $q = $bdd->query('Select nom, ville, codpostal From (Client C Inner Join Dossier D on C.code_cli = D.code_cli) Inner Join Vehicule V on D.no_imm = V.no_imm Group by nom, ville, codpostal Having Count(Distinct V.modele) >= 2');

        while($data=$q->fetch()){
            $res = $res . $data['nom'] . '	' . $data['ville']. '	' . $data['codpostal']. "<br>\n";
        }

        $_SESSION['res'] = $res;
	}
?>