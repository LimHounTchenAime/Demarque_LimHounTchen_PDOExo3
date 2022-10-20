<?php

    use src\Factory\ConnectionFactory;
    require_once 'Factory/ConnectionFactory.php';

    #header('Location: ../src/index.php?action=reservations');

    class reservations{

        static function test():string{

            try{
            ConnectionFactory::setConfig();
            $bdd = ConnectionFactory::connexion();

            $q=$bdd;

            $q->prepare('Update Calendrier set paslibre = \'x\' Where no_imm = ? and datejour between ? and ?');
            $q->bindParam(1,$_POST['immatriculation']);
            $q->bindParam(2,$_POST['dateD']);
            $q->bindParam(3,$_POST['dateF']);


            $res = $res . $q->execute() . ' ligne(s) total modifiée(s) <br>'."\n";

            $_SESSION['res'] = $res;

             }
                catch(Exception $e){
                    print "<p>Erreur données</p>";
                }



                return $_SESSION['res'];
            }
    }
?>