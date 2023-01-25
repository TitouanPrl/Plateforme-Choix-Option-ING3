<?php include "haut.php" ?>
  <link rel="stylesheet" href="/css/connex.css">
  <div class="content">
    <div class="connexionBox">
      <h1>Connexion à votre compte</h1>
      <?php

      /* Envoie un message correspondant à l'erreur de manipulation */
      switch ($_GET['error']) {
        case '1':
          echo "<span id='notif'>Vous devez vous connecter pour accéder à votre profil!</span>";
          break;
        case '2':
          echo "<span id='notif'>Oh non... Nous n'avons pas trouvé vos identifiants... (✖╭╮✖)</span>";
          break;
        case '3':
          echo "<span id='notif'>Vous avez essayé d'outre-passer le système de connexion... ༼ つ ͠° ͟ ͟ʖ ͡° ༽つ</span>";
          break;
        case '4':
          echo "<span id='notif'>Vous devez vous connecter pour accéder à la messagerie!</span>";
          break;
        default:
          break;
      }

      ?>

      <!-- Formulaire de connexion -->
      <form class="connexForm" action="verifConnexion.php" method="post">
        <h4>Entrez vos identifiants de connexion  ૮₍ ˶ᵔ ᵕ ᵔ˶ ₎ა</h4>
        <input type="text" name="login" class="saisies" value="" placeholder="Identifiant" required><br>
        <input type="password" name="password" class="saisies" value="" placeholder="Mot de passe" required><br>
        <input type="submit" name="submit" class="submits" value="Connexion">
      </form>
    </div>
  </div>

  <script type="text/javascript">
    function entering(e) {
        e.style = "background-color : #BEE5BF;"
        e.firstElementChild.style = "color:  #35273F;"
    }
    function leaving(e) {
      if (e != document.getElementById("connex")) {
        e.style = "background-color : #35273F;"
        e.firstElementChild.style = "color:  #BEE5BF;"
      }
    }



  </script>
