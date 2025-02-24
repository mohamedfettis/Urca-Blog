<?php  
require_once '../config/database.php';

if(isset($_GET['id'])){
    $mysqli = getConnection();
    $stmt = $mysqli->prepare('DELETE FROM news WHERE idn = ?');
    $stmt->bind_param('i', $_GET['id']);
    $stmt->execute();
    $stmt->close();
    $mysqli->close();

}
header('location: news-list.php');
exit;



?>