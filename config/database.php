<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog');

function getConnection() {
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    if ($mysqli->connect_error) {
        die("Erreur de connexion : " . $mysqli->connect_error);
    }
    
    $mysqli->set_charset("utf8");
    return $mysqli;
}
?>