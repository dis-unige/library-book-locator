<?php
require_once  __DIR__ . "/src/header.php";
require_once  __DIR__ . "/src/pdo.php";

switch ($requestMethod) {
    case 'GET':
        $stmt = $pdo->prepare("SELECT * FROM espaces WHERE idBatiment = :id");
        $stmt->execute(array(":id" => $_GET['id']));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row === false) {
            echo (json_encode(array("Error DB" => "Error query")));
        } else {
            echo (json_encode(array("message" => $row)));
        }
        break;
    default:
        echo (json_encode(array("message" => "Method not supported")));
        break;
}
