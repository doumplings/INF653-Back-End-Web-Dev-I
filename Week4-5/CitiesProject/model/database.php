<?php
//Data source Network 
$dsn = "mysql:host=localhost;dbname=world";
$username = "root";
$password = "";

//PDO
try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $error_message = 'Database Error';
    $error_message .= $e->getMessage();
    echo $error_message;
    exit();

}
?>