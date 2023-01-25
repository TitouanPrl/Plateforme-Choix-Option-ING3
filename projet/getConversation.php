<?php

$data = file_get_contents('conv.json');
$json = json_decode($data);

$res = "";
foreach ($json as $key => $value) {
  $res .= json_encode($value, JSON_PRETTY_PRINT) . '|';
}

if($res != "")echo rtrim($res, '|');
else          echo "Empty";

?>
