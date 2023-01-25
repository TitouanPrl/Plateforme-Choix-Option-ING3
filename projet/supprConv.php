<?php
    

    $data = file_get_contents('conv.json');
    $json = json_decode($data);

    foreach ($json as $key => $value) {
        if($value->address == $_POST["address"]) unset($json[$key]);
    }

    $json = json_encode(array_values($json));
    file_put_contents('conv.json', $json);

    unlink('./conv/'.$_POST["address"]);


    
    

    




?>