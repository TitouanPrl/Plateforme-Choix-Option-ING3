<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>OwOption - Cy-tech</title>
    <link rel="icon" href="img/icon.svg">
    <link rel="stylesheet" href="/css/haut.css">
  </head>
  <body>
    <p id="devweeb" onclick="location.href = 'https://youtu.be/dQw4w9WgXcQ'">Les Devs Weebs</p>
    <img src="img/logo.png" alt="cytech" id="cylogo" draggable="false" unselectable="on">
    <div class="contentTop">
      <div class="haut" id="hautdeP">
        <div class="link" id="proj" onmousemove="entering(this)" onmouseout="leaving(this)" onclick="location.href = 'projet.php';"draggable="false" unselectable="on">
          <p>LE PROJET</p>
        </div>
        <div class="link" id="prof" onmousemove="entering(this)" onmouseout="leaving(this)" onclick="location.href = 'profil.php';"draggable="false" unselectable="on">
          <p>PROFIL</p>
        </div>
        <div class="link" id="mess" onmousemove="entering(this)" onmouseout="leaving(this)" onclick="location.href = 'messagerie.php'"draggable="false" unselectable="on">
          <p>MESSAGERIE</p>
        </div>
        <div class="link" id="connex" onmousemove="entering(this)" onmouseout="leaving(this)" onclick="location.href = 'connex.php';"draggable="false" unselectable="on">
          <p>CONNEXION</p>
        </div>
        <?php
        session_start();
        if (!isset($_SESSION["login"])){
          echo '<input type="hidden" id="eraseConnex" name="eraseConnex" value="0">';
        }else{
          $dec = "'deconnexion.php';";
          echo "<div class='info'>";
          echo "<p>Connecté en tant que : <span style='color:#b9ffff;'>".$_SESSION["prenom"]."</span></p>";
          echo '<button type="button" id="deco" onclick="location.href='.$dec.'">Se déconnecter</button>';
          echo "</div>";
          echo '<input type="hidden" id="eraseConnex" name="eraseConnex" value="1">';
        }
         ?>

        <script type="text/javascript">
        if (document.getElementById("eraseConnex").value == "1"){
          document.getElementById("connex").hidden ="true";
        }
        </script>
      </div>
    </div>
