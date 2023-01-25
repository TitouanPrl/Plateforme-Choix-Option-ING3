<?php
session_start();
if (!isset($_SESSION["login"])){
  header('Location: connex.php?error=1');
  exit();
}

switch ($_SESSION["module"]) {
  case 'etu':
    header('Location: AccueilEleves.php');
    break;
  case 'admi':
    header('Location: AccueilAdmission.php');
    break;
  case 'admin':
    header('Location: AccueilAdmin.php');
    break;
  default:
    break;
}
?>
