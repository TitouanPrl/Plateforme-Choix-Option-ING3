<?php
session_start();

/* On écrit dans la session les variables rentrées */
$_SESSION['login'] = $_POST['login'];
$_SESSION['mdp'] = $_POST['password'];


/* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
if (!isset($_SESSION["login"])){
  header('Location: connex.php');
  exit();
}

//PARTIE VERIFICATION IDENTITE
$linkFile = "csv/ListeEtudiants.csv";
$linkFileAdmission = "csv/ListeAdmission.csv";
$linkFileAdmin = "csv/ListeAdmin.csv";
$file = fopen("csv/ListeEtudiants.csv", "r");
$fileAdmission = fopen("csv/ListeAdmission.csv", "r");
$fileAdmin = fopen("csv/ListeAdmin.csv", "r");
$verif = false;


if (!filesize($linkFileAdmission) || !filesize($linkFileAdmin)) {     /* Si un fichier n'existe pas on renvoit une erreur */
  echo "Un des fichiers n'existe pas UwU";
  fclose($file);
  fclose($fileAdmission);
  fclose($fileAdmin);
}
else {
  /* On vérifie que l'élève existe dans le fichier */
  while ((($data = fgetcsv($file, 1000, ";")) != FALSE) && !$verif) {

    /* On écrit les var dans la session */
    $_SESSION['prenom'] = $data[0];
    $_SESSION['nom'] = $data[1];
    $_SESSION['pp'] = $data[2];
    $_SESSION['date'] = $data[3];
    $_SESSION['adresse'] = $data[4];
    $_SESSION['num'] = $data[5];
    $_SESSION['login_fic'] = $data[6];
    $_SESSION['mdp_fic'] = $data[7];

    if ($_SESSION['login'] == $_SESSION['login_fic'] && $_SESSION['mdp'] == $_SESSION['mdp_fic']){
      $verif = true;
      header('Location: AccueilEleves.php'); /* Si les infos de connexion correspondent on envoie les infos de l'élève */
      $_SESSION['module'] = "etu";
      exit();
    }
  }
  fclose($file);

  /* On vérifie que le responsable admission existe dans le fichier */
  while ((($data = fgetcsv($fileAdmission, 1000, ";")) != FALSE) && !$verif) {

    /* On écrit les var dans la session */
    $_SESSION['prenom'] = $data[0];
    $_SESSION['nom'] = $data[1];
    $_SESSION['pp'] = $data[2];
    $_SESSION['date'] = $data[3];
    $_SESSION['adresse'] = $data[4];
    $_SESSION['num'] = $data[5];
    $_SESSION['login_fic'] = $data[6];
    $_SESSION['mdp_fic'] = $data[7];

    if ($_SESSION['login'] == $_SESSION['login_fic'] && $_SESSION['mdp'] == $_SESSION['mdp_fic']){
      $verif = true;
      header('Location: AccueilAdmission.php'); /* Si les infos de connexion correspondent on envoie l'interface admission */
      $_SESSION['module'] = "admi";
      exit();
    }
  }
  fclose($fileAdmission);

  /* On vérifie que l'admin existe dans le fichier */
  while ((($data = fgetcsv($fileAdmin, 1000, ";")) != FALSE) && !$verif) {

    /* On écrit les var dans la session */
    $_SESSION['prenom'] = $data[0];
    $_SESSION['nom'] = $data[1];
    $_SESSION['login_fic'] = $data[2];
    $_SESSION['mdp_fic'] = $data[3];

    if ($_SESSION['login'] == $_SESSION['login_fic'] && $_SESSION['mdp'] == $_SESSION['mdp_fic']){
      $verif = true;
      header('Location: AccueilAdmin.php'); /* Si les infos de connexion correspondent on envoie l'interface admin */
      $_SESSION['module'] = "admin";
      exit();
    }
  }
  fclose($fileAdmin);
  session_destroy();
  header('Location: connex.php?error=2');
}

  ?>
