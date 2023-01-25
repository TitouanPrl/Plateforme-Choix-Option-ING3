
  <?php include "haut.php"; ?>
  <link rel="stylesheet" href="css/profil.css">
  <div class="content">
<?php
  /* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
  if (!isset($_SESSION["login"])){
    header('Location: connex.php?error=3');
    exit();
  }


  //PARTIE PROFIL, MARIAGE STABLE
  echo "<p>Bienvenue <span style='color:#b9ffff;'>".$_SESSION['prenom']." ". $_SESSION['nom']."</span></p>";
  echo "<p>Vous pouvez lancer l'attribution des options aux élèves à partir de l'encadré ci-dessous :</p>";
  ?>
  <form name="charger" action="csv/Mariage_Stable.php" method="POST" class="formModif" style="text-align: left;">
    <label class="loadf" onclick="document.getElementById('nbPlace').click()">Charger du nombres de places</label><br><input type='file' id='nbPlace' name='nbPlace' required hidden><br>
    <label class="loadf" onclick="document.getElementById('GSI').click()">Charger le fichier GSI</label><br><input type='file' id='GSI' name='GSI' required hidden><br>
    <label class="loadf" onclick="document.getElementById('MI').click()">Charger le fichier MI</label><br><input type='file' id='MI' name='MI' required hidden><br>
    <label class="loadf" onclick="document.getElementById('MF').click()">Charger le fichier MF</label><br><input type='file' id='MF' name='MF' required hidden><br>

    <input type="submit" value="Lancer l'algo des mariages stables" style="color:black;margin-top:1em;width:20%;">
  </form>

  <?php
  //PARTIE AFFICHAGE DONNEES

  if (file_exists("csv/Option_Stats.csv")) {
   $fic_options = fopen('csv/Option_Stats.csv', 'r');

   echo "<div class='resT'>";
   echo  "<table>";
    $options = fgetcsv($fic_options, 1000, ";");
    echo "<tr><th>Option</th><th>Nombre d'étudiant</th><th>La moyenne des moyennes</th><th>Moyenne des rangs</th><th>Moyenne dernier admis</th>";
    while (($options = fgetcsv($fic_options, 1000, ";")) != FALSE) {
      echo "<tr>";
        echo "<td> ".$options[0] . "</td><td>$options[4]</td><td>$options[1]</td><td>$options[2]</td><td>$options[3]</td>";
      echo "</tr>";
      }
    fclose($fic_options);
    echo "</table>";
    echo "</div>";
    fclose($fic_options);

   $fic_eleves = fopen('csv/Mariage_res.csv', 'r');

   /* on lit le fichier ligne par ligne en comptant le nombre de premier voeux, second voeux, etc... */
   $voeux1 = 0;
   $voeux2 = 0;
   $voeux3 = 0;
   $voeux4 = 0;    /* On ne va pas plus loin car le pire voeux attribué dans notre cas est le 4ième */

   while (($eleves = fgetcsv($fic_eleves, 1000, ";")) != FALSE) {
       if ($eleves[6] == 1) {    /* Si le voeux attribué est le premier choix, on augmente le compteur de 1 */
           $voeux1++;
       }
       if ($eleves[6] == 2) {    /* Si le voeux attribué est le deuxième choix, on augmente le compteur de 1 */
           $voeux2++;
       }
       if ($eleves[6] == 3) {    /* Si le voeux attribué est le troisième choix, on augmente le compteur de 1 */
           $voeux3++;
       }
       if ($eleves[6] == 4) {    /* Si le voeux attribué est le quatrième choix, on augmente le compteur de 1 */
           $voeux4++;
       }
   }
   fclose($fic_eleves);

   /* On affiche combien d'étudiants ont eu leur i-ième voeux */
   echo "<br>";
   for ($i=1; $i < 5; $i++) {
       $voeuxEnCours = ${'voeux' . $i};
       echo "<p>$voeuxEnCours élèves ont eu leur voeux $i. </p>";
   }
  }
 ?>
    <p>Vous pouvez modifier vos informations personnelles, corrigez les directement ici :</p>

    <div class="formModif">
      <form method="POST" action="ModifInfosAdmission.php">
        <div class="droite">
          <label>Prénom :</label><br><input type='text' id='prenom' name='prenom' value="<?php echo $_SESSION['prenom'] ?>"><br>
          <label>Nom :</label><br><input type='text' id='nom' name='nom' value="<?php echo $_SESSION['nom'] ?>"><br>
          <label>Date de naissance :</label><br><input type='date' id='date' name='date' value="<?php echo $_SESSION['date'] ?>"><br>
          <input type='file' id='pp' name='pp' hidden value="<?php echo $_SESSION['pp'] ?>"><br>
          <img id='ppImg' src="img/<?php if($_SESSION['pp'] == ""){echo "anime1.png";}else{echo $_SESSION['pp'];}?>" onclick="document.getElementById('pp').click();"><br>
        </div>
        <div class="gauche">
          <label>Adresse postale :</label><br><input type='text' id='adresse' name='adresse' value="<?php echo $_SESSION['adresse'] ?>"><br>
          <label>Numéro de téléphone :</label><br><input type='text' id='num' name='num' value="<?php echo $_SESSION['num'] ?>"><br>
          <label>Identifiant :</label><br><input type='text' id='login' name='login_fic' value="<?php echo $_SESSION['login_fic'] ?>"><br>
          <label>Mot de passe :</label><br><input type='text' id='mdp' name='mdp_fic' value="<?php echo $_SESSION['mdp_fic'] ?>"><br>
        </div>
        <input type="submit" id="submit" name="submit" value="Confirmer les modifications" onclick="return confirm(\'Etes-vous sûr de vouloir changer ces informations ?\');">
      </form>
    </div>


  <?php

  //PARTIE ERREURS
  echo "Souhaitez-vous remonter une erreur ?";
  echo '<form method="POST" action="remonterErreur.php">';
  echo "<input type='text' id='erreur' name='erreur' class='erreurTicket'>";
  echo '<input type="submit" id="submitError" name="submitError" value="Confirmer" onclick="return confirm(\'Etes-vous sûr de vouloir remonter cette erreur ?\');">';    /* Demande confirmation avant d'envoyer l'erreur */
  echo '</form>';

  ?>
  </div>

</body>
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
</html>
