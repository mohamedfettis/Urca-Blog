<?php 
session_start();

// detruire de la session 

$_SESSION = [];
session_destroy();

header('location: ../index.php');

exit;



?>