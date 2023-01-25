<?php

if( file_exists('./conv/'.$_POST["adresse"]) ){

  
  $data = file_get_contents('./conv/'.$_POST["adresse"]);
  $json = json_decode($data);

  if(count($json) == 0 ) echo "NULL";
  else{
    $res = "";
    foreach ($json as $key => $value) {
      $res .= json_encode($value, JSON_PRETTY_PRINT) . '|';
    }

    echo rtrim($res, '|');
  }
}

else{
  echo "NULL";
}

?>
