<?php

use src\Factory\ConnectionFactory;
require 'Factory/ConnectionFactory.php';

ConnectionFactory::setConfig();
$bdd = ConnectionFactory::connexion();

$html='';
$action=isset($_GET['action'])?$_GET['action']:null;

session_start();

  switch ($action) {
    case 'listeVehicules':
      $html.="<h1>Liste des véhicules</h1>";
      if($_SERVER['REQUEST_METHOD']==='GET'){
        $html.=<<<END
        <form method="post" action="?action=listeVehicules">

          <label>Catégorie
          <input type="text"
                 name="categorie"
                 placeholder="<categorie>">
          </label>

          <label>Date de début
          <input type="date"
                 name="dateD"
                 placeholder="<dateD>">
          </label>

          <label>Date de fin
          <input type="date"
                 name="dateF"
                 placeholder="<dateF>">
          </label>

          <button type="submit">
          Confirmer
          </button>
        </form>
        END;
        if(isset($_SESSION['listeVehicules']))
            $html.="<br><h2>Récemment recherché :</h2>".$_SESSION['listeVehicules'];
      }
      else{
                $q = $bdd->prepare('Select no_imm, modele From Vehicule Where code_categ = ? and date_achat between ? and ?');
                $q->bindParam(1, $_POST['categorie']);
                $q->bindParam(2, $_POST['dateD']);
                $q->bindParam(3, $_POST['dateF']);
                $q->execute();
                $res = '';
                while($data=$q->fetch()){
                    $res .= $data['no_imm']. '	' . $data['modele'].'<br>'."\n";
                }

                $_SESSION['listeVehicules'] = $res;
                $html.=$_SESSION['listeVehicules'];
      }

      break;

    case 'reservations':
       if($_SERVER['REQUEST_METHOD']==='GET'){
              $html.=<<<END
              <h1>Réservations</h1>
              <form method="post" action="?action=reservations">

                <label>Immatriculation
                <input type="text"
                       name="immatriculation"
                       placeholder="<immatriculation>">
                </label>

                <label>Date de début
                <input type="date"
                       name="dateD"
                       placeholder="<dateD>">
                </label>

                <label>Date de fin
                <input type="date"
                       name="dateF"
                       placeholder="<dateF>">
                </label>

                <button type="submit">
                Confirmer
                </button>
              </form>
              END;
            }
            else{
                $q=$bdd->prepare('Update Calendrier set paslibre = \'x\' Where no_imm = ? and datejour between ? and ?');
                            $q->bindParam(1,$_POST['immatriculation']);
                            $q->bindParam(2,$_POST['dateD']);
                            $q->bindParam(3,$_POST['dateF']);
                            $q->execute();

                            $res = 'Modifications effectuées';

                            $_SESSION['reservations'] = $res;
                $html .= $_SESSION['reservations'];
            }
      break;

    case 'location':
    $html.="<h1>Coût d'une location</h1>";
       if($_SERVER['REQUEST_METHOD']==='GET'){
              $html.=<<<END
              <form method="post" action="?action=location">
                <label>Modèle
                <input type="text"
                       name="modele"
                       placeholder="<modele>">
                </label>

                <label>Nombre de jours
                <input type="number"
                       name="nbJours"
                       placeholder="<nbJours>">
                </label>

                <button type="submit">
                Confirmer
                </button>
              </form>
              END;
              if(isset($_SESSION['location']))
                $html.="<br><h2>Récemment recherché</h2>".$_SESSION['location'];
            }
            else{

        #Select ?*tarif_jour From (Vehicule V Inner join Categorie C On V.code_categ=C.code_categ) Inner join Tarif T On C.code_tarif = T.code_tarif Where modele=?
                        $q = $bdd->prepare("select tarif_jour*? as montant
                                            from vehicule, categorie, tarif
                                            where vehicule.code_categ=categorie.code_categ
                                            and categorie.code_tarif=tarif.code_tarif
                                            and modele=?");
                        $q->bindParam(1, $_POST['nbJours']);
                        $q->bindParam(2,$_POST['modele']);
                        $q->execute();

                        while($data=$q->fetch()){
                            $res=$data['montant']." €";
                        }

                        $_SESSION['location'] = $res;
                $html.=$_SESSION['location'];
            }
      break;

    case 'listeAgences':

                $res="";
                $q = $bdd->query('Select A.code_ag as code From Agence A Inner Join Vehicule V on A.code_ag = V.code_ag Group by A.code_ag Having Count(Distinct V.code_categ) = (Select Count(code_categ) From Categorie)');
                $q->execute();
                while($data=$q->fetch()){
                    $res.=$data['code']."<br>\n";
                }

                $_SESSION['listeAgences'] = $res;
                $html.="<br><h1>Liste des agences</h1>".$_SESSION['listeAgences'];
        break;

    case 'listeClients':
         $res = "";

                $q = $bdd->query('Select nom, ville, codpostal From (Client C Inner Join Dossier D on C.code_cli = D.code_cli) Inner Join Vehicule V on D.no_imm = V.no_imm Group by nom, ville, codpostal Having Count(Distinct V.modele) >= 2');

                while($data=$q->fetch()){
                    $res = $res . $data['nom'] . '	' . $data['ville']. '	' . $data['codpostal']. "<br>\n";
                }

                $_SESSION['listeClients'] = $res;
         $html="<br><h1>Liste des clients</h1>".$html.$_SESSION['listeClients'];
        break;

    default:
      $html .='<h1>Bienvenue</h1>'.'<p>Retrouvez toutes nos offres immobilières dès maintenant</p>';
      break;
  }

  echo <<<END
  <!DOCTYPE html>
  <html lang="fr">
    <head>
      <title>Location Véhicule</title>
      <meta charset="utf-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1 /"
    </head>
    <body>
      <h1>Location de Véhicules</h1>
      <nav><ul>
        <li><a href=".">Accueil</a></li>
        <li><a href="?action=listeVehicules">Liste des véhicules</a></li>
        <li><a href="?action=reservations">Réservations</a></li>
        <li><a href="?action=location">Coût d'une location</a></Li>
        <li><a href="?action=listeAgences">Liste des agences</a></Li>
        <li><a href="?action=listeClients">Liste des clients</a></Li>
    </ul></nav><br>
    $html
  </body>
</html>
END;

#echo '<script>alert("'.$_SESSION['res'].'")</script>';