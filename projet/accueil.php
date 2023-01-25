<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>OwOption - CY-Tech</title>
    <link rel="stylesheet" href="/css/accueil.css">
  </head>
  <body>
    <img id="logo" src="img/logo.png" alt="">
    <div class="content">
      <p class="textacc">Bienvenue</p>
      <p class="textacc">Vous vous trouvez sur notre projet super mignon <br>de repartition des options à CY-Tech.</p>
      <div id="selectbox">
        <div class="vertical-center">
          <button id="log" class="btn" type="button" name="button" onclick="location.href = 'connex.php';">Connexion</button>
          <button id="reg" class="btn" type="button" name="button">Le projet</button>
        </div>
        <img draggable="false" id="arrow" src="img/icons/png/004-arrow-right.png" onclick="opentab()">
      </div>
    </div>
  </body>

  <script type="text/javascript">
  function opentab() {
    document.getElementById("arrow").style = "transform: rotate(180deg);margin-left: 15em;";
    document.getElementById("selectbox").style = "width: 18em; transform: scale(1.2);";
    document.getElementById('arrow').setAttribute( "onClick", "closetab();" );
    document.getElementById('log').style = "opacity: 100%;";
    document.getElementById('reg').style = "opacity: 100%;";
  }

  function closetab() {
    document.getElementById("arrow").style = "transform: rotate(0deg);margin-left: 0em;";
    document.getElementById("selectbox").style = "width: 4em;";
    document.getElementById('arrow').setAttribute( "onClick", "opentab();" );
    document.getElementById('log').style = "opacity: 0%;";
    document.getElementById('reg').style = "opacity: 0%;";

  }
  </script>

</html>
