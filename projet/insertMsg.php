<?php

        $data = file_get_contents('./conv/'.$_POST["adresse"]);
        $json = json_decode($data);

        $array = array(
            'emetteur' => $_POST['emetteur'],
            'message' => $_POST['message'],
            'state' => "visible"
        );

        $json[] = $array;

        $json = json_encode($json, JSON_PRETTY_PRINT);

        file_put_contents('./conv/'.$_POST["adresse"], $json);

        echo $_POST['message'];

?>
