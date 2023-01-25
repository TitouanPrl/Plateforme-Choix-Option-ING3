<?php
    echo $_POST['id'];
    $id = $_POST['id'];

    $data = file_get_contents("./conv/".$_POST["adress"]);
    $json = json_decode($data);
    
    unset($json[$id]);

    $json = json_encode(array_values($json));
    file_put_contents('./conv/'.$_POST["adress"], $json);

?>
