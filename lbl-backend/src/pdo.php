<?php
$servername = "localhost";
$username = "locator";
$password = "weztRTi%tzr452787*DSERuiue";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=locator", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $error_ms = $e->getMessage();
    echo (json_encode(array("Error DB" => $error_ms)));
    exit;
}

function pdo_query($query, $args, $db, $array = true) {
    $stmt = $db->prepare($query);
    $stmt->execute($args);
    if ($array) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
