<?php
session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])){
  header('Location: connex.php?=error3');
  exit();
}

date_default_timezone_set('UTC+2'); /* Définition du fuseau horaire */
$date = date("m/d/y") . " at " . date("H:i:s"); /* Format de type Mois/Jour/An at Heure:Min:Sec */

/* On écrit l'erreur remontée dans le fichier */
$error_fic = fopen('errors', 'a+');
$error = $_POST['erreur'];
$identite = $_SESSION['prenom'] . " " . $_SESSION['nom']; /* On définit l'identité de la personne qui a remonté l'erreur */

$new_error = "$date : \n REMONTEE PAR $identite : \"$error\" \n\n";
fputs($error_fic, $new_error);

fclose($error_fic);
switch ($_SESSION["module"]) {
  case 'etu':
    header('Location: AccueilEleves.php');
    exit();
    break;
  case 'admi':
    header('Location: AccueilAdmission.php');
    exit();
    break;
  case 'admin':
    header('Location: AccueilAdmin.php');
    exit();
    break;
  default:
    break;
}
?>
