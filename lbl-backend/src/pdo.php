<?php
$servername = "localhost";
$username = "backend";
$password = "mdp123";
try {
    $pdo = new PDO("mysql:host=$servername;dbname=librarybooklocator", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_ms = $e->getMessage();
    echo (json_encode(array("Error DB" => $error_ms)));
    exit;
}
