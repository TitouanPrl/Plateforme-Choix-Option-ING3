<?php include "haut.php"; ?>
<link rel="stylesheet" href="/css/profil.css">
  <div class="content">
    <?php
    /* On vérifie qu'un mdp a bien été rentré (évite qu'on dodge la page de connexion) */
    if (!isset($_SESSION["login"])){
      header('Location: connex.php?=error3');
      exit();
    }

    echo "<p>Bienvenue <span style='color:#b9ffff;'>".$_SESSION['prenom']." ". $_SESSION['nom']."</span></p>";
    echo "<p>Ici, vous avez accès aux logs et vous pouvez créer les identifiants des étudiants</p>";

    //PARTIE CREATION COMPTES ETUDIANTS
    ?>
      <form method="POST" action="creationComptesEleves.php" class="formModif" style="width:30%;margin: 0 auto;">
        <label class="loadf" onclick="document.getElementById('liste').click()">Charger le fichier étudiant</label> <input type='file' id='liste' name='liste' hidden>
        <br>
        <input type="submit" id="submitF" name="submit" value="Confirmer" onclick="return confirm(\'Etes-vous sûr de vouloir uploader ce fichier ?\');">
      </form>

    <?php


    //PARTIE AFFICHAGE LOGS ET ERREURS
    $log_fic = "logs";
    $error_fic = "errors";
    $linkLogs = fopen("logs", "r");
    $linkErrors = fopen("errors", "r");



    /* On affiche les logs */
    $logs = file_get_contents($log_fic);
    $nbLignesLogs = substr_count($logs, "\n");  /* On compte le nombre de lignes du fichier logs */

    echo "<div class='gaucheLog infos'>";
    for ($i=0; $i < $nbLignesLogs; $i++) {  /* On affiche le fichier ligne par ligne */
      echo fgets($linkLogs) . "<br>";
    }
    echo "</div>";

    /* On affiche les erreurs */
    $errors = file_get_contents($error_fic);
    $nbLignesErrors = substr_count($errors, "\n");  /* On compte le nombre de lignes du fichier erreurs */

    echo "<div class='droiteErreur infos'>";
    for ($i=0; $i < $nbLignesErrors; $i++) {  /* On affiche le fichier ligne par ligne */
      echo fgets($linkErrors) . "<br>";
    }
    echo "</div>";

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
