<?php

session_start();
require_once 'tdloc.php';

$html='';
$action=isset($_GET['action'])?$_GET['action']:null;

  switch ($action) {
    case 'liste-vehicules':
      if($_SERVER['REQUEST_METHOD']==='GET'){
        $html.=<<<END
        <h1>Liste des véhicules</h1>
        <form method="post" action="?action=liste-vehicules"

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
      }
      else{
        $categorie=filter_var($_POST['categorie'], FILTER_SANITIZE_STRING);
        $dateD=$_POST['dateD'];
        $dateF=$_POST['dateF'];
        $html.="Catégorie : <b>$categorie</b> Date de début : <b>$dateD</b> Date de fin : <b>$dateF</b><br>";
      }
      break;

    case 'reservations':
       if($_SERVER['REQUEST_METHOD']==='GET'){
              $html.=<<<END
              <h1>Réservations</h1>
              <form method="post" action="?action=reservations"

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
                $immatriculation=filter_var($_POST['immatriculation'], FILTER_SANITIZE_STRING);
                $dateD=$_POST['dateD'];
                $dateF=$_POST['dateF'];

            }
      break;

    case 'location':
       if($_SERVER['REQUEST_METHOD']==='GET'){
              $html.=<<<END
              <h1>Coût d'une location</h1>
              <form method="post" action="?action=location"
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
            }
            else{
                $modele=filter_var($_POST['modele'], FILTER_SANITIZE_STRING);
                $nbJours=filter_var($_POST['nbJours'], FILTER_SANITIZE_NUMBER_INT);
            }
      break;

    case 'liste-agences':
         if($_SERVER['REQUEST_METHOD']==='GET'){
                $html.=<<<END
                <h1>Liste des agences</h1>
                END;
              }
              else{

              }
        break;

    case 'liste-clients':
         if($_SERVER['REQUEST_METHOD']==='GET'){
                $html.=<<<END
                <h1>Liste des clients</h1>
                <form method="post" action="?action=liste-clients"

                  <label>Modèle 1
                  <input type="text"
                         name="modele1"
                         placeholder="<modele1>">
                  </label>

                  <label>Modèle 2
                  <input type="text"
                         name="modele2"
                         placeholder="<modele2>">
                  </label>

                  <button type="submit">
                  Confirmer
                  </button>
                </form>
                END;
              }
              else{
                $modele1=filter_var($_POST['modele1'], FILTER_SANITIZE_STRING);
                $modele2=filter_var($_POST['modele2'], FILTER_SANITIZE_STRING);
              }
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
        <li><a href="?action=liste-vehicules">Liste des véhicules</a></li>
        <li><a href="?action=reservations">Réservations</a></li>
        <li><a href="?action=location">Coût d'une location</a></Li>
        <li><a href="?action=liste-agences">Liste des agences</a></Li>
        <li><a href="?action=liste-clients">Liste des clients</a></Li>
    </nav><br>
    $html
  </body>
</html>
END;
