<?php

        $data = file_get_contents('conv.json');
        $json = json_decode($data);

        $pass = TRUE;
        foreach ($json as $key => $value) {
          if(($value->eleve1 == $_POST["eleve1"] || $value->eleve2 == $_POST["eleve1"]) && ($value->eleve1 == $_POST["eleve2"] || $value->eleve2 == $_POST["eleve2"])) {
            $pass = FALSE;
            echo "Non|".$value->address;
          }
        }

        if($pass){
          $pass2 = FALSE;
          foreach(array("ListeAdmission.csv", "ListeAdmin.csv", "ListeEtudiants.csv") as $fichier){

            $i = 0;
            $arr = array();
            $file = fopen("./csv/".$fichier, 'r');
            while( ($line = fgetcsv($file, ";", "\n")) != FALSE ) $arr[$i++] = explode(';',  $line[0]); 
            fclose($file);

            foreach($arr as $etudiant){
              if($etudiant[6] == $_POST["eleve2"]) $pass2 = TRUE;
            }

          }

          if($pass2){
            $array = array(
                'eleve1' => $_POST["eleve1"],
                'eleve2' => $_POST["eleve2"],
                'address' => $_POST["eleve1"].$_POST["eleve2"].".json",
                'bloque' => "Non"
            );

            $json[] = $array;
            echo "add|".$_POST["eleve1"].$_POST["eleve2"].".json";
          }else{
            echo "Non|NULL";
          }

        }

        $json = json_encode($json, JSON_PRETTY_PRINT);
        file_put_contents('conv.json', $json);


?>
