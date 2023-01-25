<?php
session_start();

date_default_timezone_set('UTC+2'); /* Définition du fuseau horaire */
$date = date("m/d/y") . " at " . date("H:i:s"); /* Format de type Mois/Jour/An at Heure:Min:Sec */

/* On écrit l'erreur remontée dans le fichier */
$signalement_fic = fopen('logs', 'a+');
$identite = $_SESSION['prenom'] . " " . $_SESSION['nom']; /* On définit l'identité de la personne qui a remonté l'erreur */

$new_signalement = $date." par ".$identite." : \nSignalement du message \"".$_POST['message']."\" avec pour raison \"".$_POST['signalement']."\" \n\n";
fputs($signalement_fic, $new_signalement);

fclose($signalement_fic);

?>
