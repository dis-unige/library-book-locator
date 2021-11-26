<?php
require_once  __DIR__ . "/src/header.php";
require_once  __DIR__ . "/src/pdo.php";

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['batiment']) && isset($_GET['cote']) && isset($_GET['secteur'])) {
            $cote = explode(" ", $_GET['cote']);
            //echo (json_encode(array("Error DB" =>  $cote[0])));
            $stmt = $pdo->prepare(
                "SELECT locator.longitude, locator.latitude, locator.estAccessible, espaces.nomLong, espaces.longitude, espaces.latitude, espaces.p1Latitude, espaces.p1Longitude, espaces.p2Latitude, espaces.p2Longitude, espaces.p3Latitude, espaces.p3Longitude, espacesimages.etage, espacesimages.url  FROM espacesimages, espaces, locator WHERE espaces.idBatiment = locator.idBatiment AND espacesimages.idBatiment = espaces.idBatiment AND espaces.nomCourt = :bat AND locator.secteur = :sect AND locator.racineDeweyDebut = :racine_debut AND locator.racineDeweyFin = :racine_fin"
            );
            $stmt->execute(array(
                ":bat" => $_GET['batiment'],
                ":sect" => $_GET['secteur'],
                ":racine_debut" => $cote[0],
                ":racine_fin" => $cote[0]
            ));
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($row === false) {
                echo (json_encode(array("Error DB" => "Error query")));
            } else {
                echo (json_encode(array("message" => $row)));
            }
        } else {
            echo (json_encode(array("Error" => "Missing parameters")));
        }
        break;
    default:
        echo (json_encode(array("message" => "Method not supported")));
        break;
}
