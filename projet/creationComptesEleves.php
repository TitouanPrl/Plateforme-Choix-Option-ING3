<?php
session_start();

/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])){
  header('Location: .connex.php?error=3');
  exit();
}

date_default_timezone_set('Europe/Paris'); /* Définition du fuseau horaire */
$date = date("m/d/y") . " at " . date("H:i:s"); /* Format de type Mois/Jour/An at Heure:Min:Sec */
$liste = $_POST['liste'];
$identite = $_SESSION['prenom'] . " " . $_SESSION['nom']; /* On définit l'identité de l'admin */

$fic = fopen('csv/' . $liste, 'r');
$count_fic = "csv/$liste";

/* On ajoute les étudiants un par un dans le fichier */
while (($ficEntree = fgetcsv($fic, 1000, ";")) != FALSE) {
  $verif = 1;   /* On initialise le compteur */
  $comptes = fopen('csv/ListeEtudiants.csv', 'a+');
  $mdpRandom = uniqid();    /*On génère un mdp aléatoire */

  while (($ListeEtudiants = fgetcsv($comptes, 1000, ";")) != FALSE) {

    if ((($ficEntree[0] == $ListeEtudiants[0]) && ($ficEntree[1] == $ListeEtudiants[1])) || ($ficEntree[0] == "prenom")) {  /* Si l'élève est  déjà dans la liste ou que la ligne est  la légende du tableau, alors on passe la vérif à faux */
      $verif = 0;
    }
    }
    if ($verif == 1) {    /* Si l'élève n'est pas déjà dans la liste ou que la ligne n'est pas la légende du tableau, alors on ajoute l'élève */
      $new_eleve = "$ficEntree[0];$ficEntree[1];;;;;$ficEntree[2];$mdpRandom\n";
      fputs($comptes, $new_eleve);
  }
  fclose($comptes);
}
fclose($fic);

/* On écrit la modification dans les logs */
$logs = fopen('logs', 'a+');
$new_log = "$date par $identite : \nLe fichier $liste a été uploadé \n\n";
fputs($logs, $new_log);
fclose($logs);


header('Location: AccueilAdmin.php');
exit();
?>
