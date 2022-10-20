<?php

session_start();


$html='';
$action=isset($_GET['action'])?$_GET['action']:null;

  switch ($action) {
    case 'liste-vehicules':
      if($_SERVER['REQUEST_METHOD']==='GET'){
        $html.=<<<END
        <h1>Liste des véhicules</h1>
        <form method="post" action="../scripts/ex1.php">

          <label>Catégorie
          <input type="text"
                 name="categorie"
                 placeholder="<categorie>"/>
          </label>

          <label>Date de début
          <input type="date"
                 name="dateD"
                 placeholder="<dateD>"/>
          </label>

          <label>Date de fin
          <input type="date"
                 name="dateF"
                 placeholder="<dateF>"/>
          </label>

          <button type="submit">
          Confirmer
          </button>
        </form>
        END;
      }
      else{
        $html =  $html.$_SESSION['res'];
      }
      break;

    case 'reservations':
       if($_SERVER['REQUEST_METHOD']==='GET'){
              $html.=<<<END
              <h1>Réservations</h1>
              <form method="post" action="../scripts/ex2.php">

                <label>Immatriculation
                <input type="text"
                       name="immatriculation"
                       placeholder="<immatriculation>"/>
                </label>

                <label>Date de début
                <input type="date"
                       name="dateD"
                       placeholder="<dateD>"/>
                </label>

                <label>Date de fin
                <input type="date"
                       name="dateF"
                       placeholder="<dateF>"/>
                </label>

                <button type="submit">
                Confirmer
                </button>
              </form>
              END;
            }
            else{
                $html =  $html.$_SESSION['req'];
            }
      break;

    case 'location':
       if($_SERVER['REQUEST_METHOD']==='GET'){
              $html.=<<<END
              <h1>Coût d'une location</h1>
              <form method="post" action="../scripts/ex3.php">
                <label>Modèle
                <input type="text"
                       name="modele"
                       placeholder="<modele>"/>
                </label>

                <label>Nombre de jours
                <input type="number"
                       name="nbJours"
                       placeholder="<nbJours>"/>
                </label>

                <button type="submit">
                Confirmer
                </button>
              </form>
              END;
            }
            else{
                $html=$html.$_SESSION['req'];
            }
      break;

    case 'liste-agences':
        $html=$html.$_SESSION['req'];
        break;

    case 'liste-clients':
         $html=$html.$_SESSION['req'];
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
        <li><a href="../scripts/ex4.php">Liste des agences</a></Li>
        <li><a href="../scripts/ex5.php">Liste des clients</a></Li>
    </ul></nav><br>
    $html
  </body>
</html>
END;

echo '<script>alert("'.$_SESSION['res'].'")</script>';