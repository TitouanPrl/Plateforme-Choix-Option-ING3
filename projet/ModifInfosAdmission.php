<?php
session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])){
  header('Location: connex.php?error=3');
  exit();
}

date_default_timezone_set('Europe/Paris'); /* Définition du fuseau horaire */
$date = date("m/d/y") . " at " . date("H:i:s"); /* Format de type Mois/Jour/An at Heure:Min:Sec */

if ($fic = fopen('csv/ListeAdmission.csv', 'r'))
{
  /* On met à jour les var dans la session */
  $_SESSION['prenom'] = $_POST['prenom'];
  $_SESSION['nom'] = $_POST['nom'];
  $_SESSION['pp'] = $_POST['pp'];
  $_SESSION['date'] = $_POST['date'];
  $_SESSION['adresse'] = $_POST['adresse'];
  $_SESSION['num'] = $_POST['num'];
  $_SESSION['login_fic'] = $_POST['login_fic'];
  $_SESSION['mdp_fic'] = $_POST['mdp_fic'];


  $newcontenu = "";
  $identite = $_SESSION['prenom'] . " " . $_SESSION['nom']; /* On définit l'identité de la personne qui a remonté l'erreur */


  /* Variable contenant la nouvelle ligne : */
  $nouvelle_ligne = array ($_SESSION['prenom'], $_SESSION['nom'], $_SESSION['pp'], $_SESSION['date'], $_SESSION['adresse'], $_SESSION['num'], $_SESSION['login_fic'], $_SESSION['mdp_fic']);
  $nouvelle_ligne = implode(";", $nouvelle_ligne); /* On convertit le tableau en chaine de char */

  /* On lit le fichier ligne par ligne en le réécrivant petit à petit : */
  while (($info = fgetcsv($fic, 1000, ";")) != FALSE) {
    $info_char = implode(";", $info); /* On convertit le tableau en chaine de char */
    if ($info[1] == $_SESSION['nom'] && $info[0] == $_SESSION['prenom']) {    /* On cherche l'élève dans le fichier */
      $newcontenu = $newcontenu . $nouvelle_ligne . "\n";  /* Si on le trouve on remplace la ligne par les nouvelles infos */

      /* On écrit la modification dans les logs */
      $logs = fopen('logs', 'a+');
      $new_log = "$date par $identite : \n\"$info_char\" HAS BEEN CHANGED INTO \"$nouvelle_ligne\" \n\n";
      fputs($logs, $new_log);
    }
    else {
      $newcontenu = $newcontenu . $info_char . "\n";  /* Si on ne le trouve pas on réécrit la ligne */
    }
  }
  fclose($logs);
  fclose($fic);

  $fichierecriture = fopen('csv/ListeAdmission.csv', 'w+');
  fputs($fichierecriture, $newcontenu);   /* On remplace le fichier par celui modifié */
  fclose($fichierecriture);
}


header('Location: AccueilAdmission.php');
exit();
?>
