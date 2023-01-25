<?php
include "haut.php";
session_start();
if (!isset($_SESSION["login"])){
  header('Location: connex.php?error=4');
  exit();
}

?>
  <link rel="stylesheet" href="/css/messagerie.css">
  <div class="content" id="content">
      <div>
          <input type="hidden" name="e1" id=e1 value="<?php echo $_SESSION["login_fic"]; ?>">
          <input type="hidden" name="conv" id=conv value="NULL">
      </div>

      <div class="Utilisateur" id =Utilisateur>
        <input type="eleve2" name="e2" id=e2 class="newDest" value="" placeholder="Votre destinataire..."><input type="button" name="" id="newC" class="newDest" value="Créer une conversation" onclick="nouvelleConv()">
      </div>


        <input type="button" id="env" value="" onclick="message()" hidden>
        <div class="messagerie" id=messagerie>
          <!-- Les messages -->
          <input type="text" name="msg" id=msg value="" placeholder="Envoyer un message...">
      </div>
    </div>
  </body>
</html>

<script type="text/javascript">
    var saveInput = document.getElementById("msg");
    // Execute a function when the user presses a key on the keyboard
    saveInput.addEventListener("keypress", function(event) {
      // If the user presses the "Enter" key on the keyboard
      if (event.key === "Enter") {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById("env").click();
      }
    });

  function nouvelleConv(){

      let xhttp = new XMLHttpRequest();
      //================Change state============================//
      let e1 = document.getElementById('e1').value;
      let e2 = document.getElementById('e2').value;
      document.getElementById("e2").value = "";
      xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

          let answer = this.responseText.split('|')
          document.getElementById('conv').value = answer[1];

          if(answer[0] == "add"){

            let ajout = e2;
            let node = document.createElement("div");
            let textnode = document.createTextNode(ajout);
            node.appendChild(textnode);


            node.setAttribute("onclick", "aff('"+answer[1]+"')");
            node.setAttribute("id", answer[1]);
            node.setAttribute("class", "dest");

            document.getElementById("Utilisateur").appendChild(node);

            let button = document.createElement("img");
            button.setAttribute("onclick", "delConv(this)");
            button.setAttribute("class","trashcanConv");
            button.setAttribute("src", "img/icons/png/009-trash-can.png");
            button.setAttribute("id", answer[1]);
            document.getElementById("Utilisateur").appendChild(button);

            let button2 = document.createElement("img");
            button2.setAttribute("onclick", "alert('Cette personne à été bloquée')");
            button2.setAttribute("class","trashcanConv");
            button2.setAttribute("src", "img/icons/png/block.png");
            button2.setAttribute("name", answer[1]);
            document.getElementById("Utilisateur").appendChild(button2);


            aff(answer[1]);
          }

          else if(answer[0] == "Non"){
            alert("Cette personne n'exite pas");
          }

        }
      }

      xhttp.open("POST", "creerConv.php", true);

      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      if (e2 != "") {
        xhttp.send("eleve1=" + e1 + "&eleve2=" + e2);
      }
    }



    //==================================================================================================================//
    //==================================================================================================================//


    function message(){
        if(document.getElementById('conv').value == "NULL" ) return;


        let xhttp = new XMLHttpRequest();
        //================Change state============================//
        let e1 = document.getElementById('e1').value;
        let adress = document.getElementById('conv').value;

        xhttp.onreadystatechange = function () {
          if(this.readyState == 4 && this.status == 200){

            let ajout = this.responseText;
            let node = document.createElement("div");
            let pnode = document.createElement("p");
            let textnode = document.createTextNode(ajout);
            pnode.appendChild(textnode);
            pnode.setAttribute("class", "textMess");
            node.setAttribute("id", index);
            node.appendChild(pnode);
            node.setAttribute("class", "droite");



            document.getElementById("messagerie").appendChild(node);

            document.getElementById("msg").value = "";
            document.getElementById("messagerie").appendChild(document.getElementById("msg"));

            let button = document.createElement("img");
            button.setAttribute("src", "img/icons/png/009-trash-can.png");
            button.setAttribute("class", "trashcan");
            button.setAttribute("onclick", "del(this)");
            button.setAttribute("id", index);
            node.appendChild(button);

            document.getElementById("messagerie").scrollTop = document.getElementById("messagerie").scrollHeight;
            document.getElementById("msg").focus();
          }
        }

        xhttp.open("POST", "insertMsg.php", true);

        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send("emetteur=" + e1 + "&adresse=" + adress + "&message=" + document.getElementById('msg').value);
      }


  //==================================================================================================================//
  //==================================================================================================================//




  function aff(address) {
    document.getElementById('conv').value = address;
    document.getElementById("messagerie").remove();

    let node = document.createElement("div");
    node.setAttribute("id", "messagerie");
    node.setAttribute("class", "messagerie");
    document.getElementById("content").appendChild(node);

    let xhttp = new XMLHttpRequest();
    //================Change state============================//

    xhttp.onreadystatechange = function () {
      if(this.readyState == 4 && this.status == 200){
        if(this.responseText != "empty"){

          index = 0;
          if (this.responseText != "NULL"){
            let msgs = this.responseText.split('|');
            for(let test of msgs){
              let Message = JSON.parse(test);
              if(Message.state == "visible"){

                let ajout = Message.message;
                let node = document.createElement("div");
                let textnode = document.createTextNode(ajout);
                let pnode = document.createElement("p");
                pnode.appendChild(textnode);
                pnode.setAttribute("class", "textMess");
                node.appendChild(pnode);
                node.setAttribute("id", index);
                //document.getElementById('e1').value le nom du profil

                if(Message.emetteur == document.getElementById('e1').value){
                  node.setAttribute("class", "droite");
                  let button = document.createElement("img");
                  button.setAttribute("src", "img/icons/png/009-trash-can.png");
                  button.setAttribute("class", "trashcan");
                  button.setAttribute("onclick", "del(this)");
                  button.setAttribute("id", index);
                  node.appendChild(button);
                }else{
                  node.setAttribute("class", "gauche");
                  let button = document.createElement("button");
                  button.innerHTML = "!";
                  button.setAttribute("onclick", "signal(this)");
                  button.setAttribute("class", "sign");
                  button.setAttribute("id", index);
                  node.appendChild(button);
                }

                document.getElementById("messagerie").appendChild(node);
              }
              index++;
            }
          }
          document.getElementById("messagerie").appendChild(saveInput);
          document.getElementById("messagerie").scrollTop = document.getElementById("messagerie").scrollHeight;
        }

      }
    }

    xhttp.open("POST", "getDiscussion.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("adresse="+ address);
  }



  //==================================================================================================================//
  //==================================================================================================================//

  function del(that) {

    let xhttp = new XMLHttpRequest();
    //================Change state============================//


    xhttp.onreadystatechange = function () {
      if(this.readyState == 4 && this.status == 200){
        aff(document.getElementById('conv').value);
      }
    }

    xhttp.open("POST", "supprMsg.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("id="+ that.id +"&adress=" + document.getElementById('conv').value);
  }


  //==================================================================================================================//
  //==================================================================================================================//


  function signal(that){

    let xhttp = new XMLHttpRequest();
    //================Change state============================//


    xhttp.onreadystatechange = function () {
      if(this.readyState == 4 && this.status == 200){
      }
    }

    xhttp.open("POST", "signalement.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    let signal = window.prompt("Quelle est la raison du signalement ?");
    if(signal != null){
      xhttp.send("message="+ document.getElementById(that.id).children[0].innerHTML +"&signalement=" + signal);
    }
  }


  //==================================================================================================================//
  //==================================================================================================================//
  function delConv(that){
      let xhttp = new XMLHttpRequest();
      //================Change state============================//


      xhttp.onreadystatechange = function () {
        if(this.readyState == 4 && this.status == 200){

          if(that.id == document.getElementById("conv").value){
              document.getElementById("messagerie").remove();

              let node = document.createElement("div");
              node.setAttribute("id", "messagerie");
              node.setAttribute("class", "messagerie");
              document.getElementById("content").appendChild(node);

              document.getElementById("messagerie").appendChild(saveInput);
              document.getElementById("messagerie").scrollTop = document.getElementById("messagerie").scrollHeight;
          }
          let caca = that.id;
          document.getElementById(caca).remove();
          document.getElementsByName(caca)[0].remove();
          that.remove();

        }
      }

      xhttp.open("POST", "supprConv.php", true);
      xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhttp.send("&address=" + that.id);
    }


    //==================================================================================================================//
    //==================================================================================================================//


  var index = 0;
  let xhttp = new XMLHttpRequest();
  let moi = document.getElementById('e1').value;
  //================Change state============================//

  xhttp.onreadystatechange = function () {
    if(this.readyState == 4 && this.status == 200){
      let msgs = this.responseText.split('|');

      for(let test of msgs){

          let Message = JSON.parse(test);


          if(Message.bloque == "Non" && (Message.eleve1 == moi || Message.eleve2 == moi) ){

            let ajout = Message.eleve1 == moi ? Message.eleve2 : Message.eleve1;
            let node = document.createElement("div");
            let textnode = document.createTextNode(ajout);
            node.appendChild(textnode);
            node.setAttribute("id", Message.address);
            node.setAttribute("onclick", "aff('"+Message.address+"')");
            node.setAttribute("class", "dest");
            document.getElementById("Utilisateur").appendChild(node);

            let button = document.createElement("img");
            button.setAttribute("onclick", "delConv(this)");
            button.setAttribute("class", "trashcanConv");
            button.setAttribute("src", "img/icons/png/009-trash-can.png");
            button.setAttribute("id", Message.address);
            document.getElementById("Utilisateur").appendChild(button);


            let button2 = document.createElement("img");
            button2.setAttribute("onclick", "alert('Cette personne à été bloquée')");
            button2.setAttribute("class","trashcanConv");
            button2.setAttribute("src", "img/icons/png/block.png");
            button2.setAttribute("name", Message.address);
            document.getElementById("Utilisateur").appendChild(button2);

          }
      }
    }
  }

  xhttp.open("POST", "getConversation.php", true);
  xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
  xhttp.send();




</script>


<script type="text/javascript">
  function entering(e) {
      e.style = "background-color : #BEE5BF;"
      e.firstElementChild.style = "color:  #35273F;"
  }
  function leaving(e) {
    if (e != document.getElementById("mess")) {
      e.style = "background-color : #35273F;"
      e.firstElementChild.style = "color:  #BEE5BF;"
    }
  }



</script>
