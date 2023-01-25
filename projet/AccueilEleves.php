
  <?php include "haut.php"; ?>
  <link rel="stylesheet" href="css/profil.css">
  <div class="content">

  <?php
  /* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
  if (!isset($_SESSION["login"])){
    header('Location: connex.php?error=3');
    exit();
  }


  //PARTIE VERIFICATION IDENTITE ET AFFICHAGE MOYENNE, ECTS, OPTIONS
  $linkFile = "csv/ListeEtudiants.csv";
  $file = fopen("csv/ListeEtudiants.csv", "r");
  $verifGI = false;
  $verifGM = false;
  $verifGSI = false;

  echo "<p>Bienvenue <span style='color:#b9ffff;'>".$_SESSION['prenom']." ". $_SESSION['nom']."</span></p>";

  /* On cherche l'élève dans le fichier GI */
  $fileGI = fopen("csv/choixEtudiantsParcours1.csv", "r");
  while (($GI = fgetcsv($fileGI, 1000, ";")) != FALSE && !$verifGI) {
    if ($_SESSION['prenom'] == $GI[0] && $_SESSION['nom'] == $GI[1]) {
      $verifGI = true;
      echo "Votre moyenne est $GI[4], votre ECTS est $GI[3], et vos choix d'options dans l'ordre décroissant sont ";
      $i = 5; /* On initialise le curseur à la première option */
      while ($GI[$i]) {
        echo "$GI[$i], ";
        $i++;
      }
    }
  }
  fclose($fileGI);

  /* On cherche l'élève dans le fichier GM */
  $fileGM = fopen("csv/choixEtudiantsParcours2.csv", "r");
  while (($GM = fgetcsv($fileGM, 1000, ";")) != FALSE && !$verifGM && !$verifGI) {
    if ($_SESSION['prenom'] == $GM[0] && $_SESSION['nom'] == $GM[1]) {
      $verifGM = true;
      echo "<p>Votre moyenne est $GM[4], votre ECTS est $GM[3], et vos choix d'options dans l'ordre décroissant sont </p>";
      $i = 5; /* On initialise le curseur à la première option */
      while ($GM[$i]) {
        echo "$GM[$i], ";
        $i++;
      }
    }
  }
  fclose($fileGM);

  /* On cherche l'élève dans le fichier GSI */
  $fileGSI = fopen("csv/choixEtudiantsParcours3.csv", "r");
  while (($GSI = fgetcsv($fileGSI, 1000, ";")) != FALSE && !$verifGSI && !$verifGM && !$verifGI) {
    if ($_SESSION['prenom'] == $GSI[0] && $_SESSION['nom'] == $GSI[1]) {
      $verifGSI = true;
      echo "<p>Votre moyenne est $GSI[4], votre ECTS est $GSI[3], et vos choix d'options dans l'ordre décroissant sont :</p>";
      $i = 5; /* On initialise le curseur à la première option */
      while ($GSI[$i]) {
        echo "$GSI[$i], ";
        $i++;
      }
    }
  }
  fclose($fileGSI);

  /* On affiche une erreur si l'élève n'est trouvé dans aucun des fichiers */
  if (($verifGI == false) && ($verifGM == false) && ($verifGSI == false)) {
    echo "Erreur de chargement des infos.";
    exit();
  }


  //PARTIE PROFIL

?>
  <p>Vous pouvez modifier vos informations personnelles directement ci-dessous :</p>

  <div class="formModif">
    <form method="POST" action="ModifInfosEleve.php">
      <div class="droite">
        <label>Prénom :</label><br><input type='text' id='prenom' name='prenom' required='required' value="<?php echo $_SESSION['prenom'] ?>"><br>
        <label>Nom :</label><br><input type='text' id='nom' name='nom' required='required' value="<?php echo $_SESSION['nom'] ?>"><br>
        <label>Date de naissance :</label><br><input type='date' id='date' name='date' required='required' value="<?php echo $_SESSION['date'] ?>"><br>
        <p>Selectionnez uniquement une image présente dans le dossier "img/"</p>
        <input type='file' id='pp' name='pp' hidden value="<?php echo $_SESSION['pp'] ?>"><br>
        <img id='ppImg' src="img/<?php if($_SESSION['pp'] == ""){echo "anime1.png";}else{echo $_SESSION['pp'];}?>" onclick="document.getElementById('pp').click();"><br>
      </div>
      <div class="gauche">
        <label>Adresse postale :</label><br><input type='text' id='adresse' name='adresse' required='required' value="<?php echo $_SESSION['adresse'] ?>"><br>
        <label>Numéro de téléphone :</label><br><input type='text' id='num' name='num' required='required' value="<?php echo $_SESSION['num'] ?>"><br>
        <label>Identifiant :</label><br><input type='text' id='login' name='login_fic' required='required' value="<?php echo $_SESSION['login_fic'] ?>"><br>
        <label>Mot de passe :</label><br><input type='text' id='mdp' name='mdp_fic' required='required' value="<?php echo $_SESSION['mdp_fic'] ?>"><br>
      </div>
      <input type="submit" id="submit" name="submit" value="Confirmer les modifications" onclick="return confirm(\'Etes-vous sûr de vouloir changer ces informations ?\');">
    </form>
  </div>


<?php


  fclose($file);  //On ferme le fichier de données élève


  //PARTIE ERREURS
  echo "Souhaitez-vous remonter un ticket d'erreur ?";
  echo '<form method="POST" action="remonterErreur.php">';
  echo "<input type='text' id='erreur' name='erreur' class='erreurTicket'>";
  echo '<input type="submit" id="submitError" name="submitError" value="Envoyez le ticket" onclick="return confirm(\'Etes-vous sûr de vouloir remonter cette erreur ?\');">';    /* Demande confirmation avant d'envoyer l'erreur */
  echo '</form>';


  ?>
      <script type="text/javascript">
        function entering(e) {
            e.style = "background-color : #BEE5BF;"
            e.firstElementChild.style = "color:  #35273F;"
        }
        function leaving(e) {
          if (e != document.getElementById("prof")) {
            e.style = "background-color : #35273F;"
            e.firstElementChild.style = "color:  #BEE5BF;"
          }
        }



      </script>

    </div>
  </body>
</html>
