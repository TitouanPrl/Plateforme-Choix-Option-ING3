<?php
session_start();
session_destroy();
header('Location: projet.php');
exit();
?>
