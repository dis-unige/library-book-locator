<?php
require_once  __DIR__ . "/src/header.php";
require_once  __DIR__ . "/src/pdo.php";


/*
* TODO : 
faire des fonctions
faire les paddings pour les cotes
15.124.21 --> 15 / 124000 / 21000
*/

function pad($cote) {
    $el = explode('.', $cote);
    while (count($el) < 3) {
        array_push($el, '');
    }
    $x = $el[0];
    $y = $el[1] . str_repeat('0', 5 - strlen($el[1]));
    $z = $el[2] . str_repeat('0', 5 - strlen($el[2]));
    return intval($x . $y . $z);
}

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['batiment']) && isset($_GET['cote']) && isset($_GET['secteur'])) { // Vérification des paramètres
            // Premier cas. On vérifie si on a une correspondance exacte
            $cote = explode(" ", $_GET['cote']); // Retourne la cote seule.
            $stmt = $pdo->prepare(
                "SELECT 
                locator.longitude,
                locator.latitude, 
                locator.estAccessible,
                locator.etage AS 'etageLivre',   
                espaces.idBatiment,
                espaces.nomLong, 
                espaces.longitude, 
                espaces.latitude, 
                espaces.p1Latitude, 
                espaces.p1Longitude, 
                espaces.p2Latitude, 
                espaces.p2Longitude, 
                espaces.p3Latitude, 
                espaces.p3Longitude
                FROM 
                espaces, 
                locator 
                WHERE 
                espaces.idBatiment = locator.idBatiment  
                AND espaces.nomCourt = :bat 
                AND locator.secteur = :sect 
                AND locator.racineDeweyDebut = :racine_debut 
                AND locator.racineDeweyFin = :racine_fin"
            );
            $stmt->execute(array(
                ":bat" => $_GET['batiment'],
                ":sect" => $_GET['secteur'],
                ":racine_debut" => $cote[0],
                ":racine_fin" => $cote[0]
            ));
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($row)) { // Si on a pas de résultats pour la correspondance exacte
                if (is_numeric($cote[0])) { // Si c'est numérique on fait un range
                    /*$stmt2 = $pdo->prepare(
                        "" // todo
                    );
                    $stmt2->execute(array(
                        "" // todo
                    ));
                    $row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC); // Résultat de la query par range*/
                    if (empty($row2)) { // Si le range ne donne pas de résultats, on renvoie les informations sur le bâtiment + les images
                        $stmt4 = $pdo->prepare(
                            "SELECT 
                            locator.longitude,
                            locator.latitude, 
                            locator.estAccessible,
                            locator.etage AS 'etageLivre',   
                            espaces.idBatiment,
                            espaces.nomLong, 
                            espaces.longitude, 
                            espaces.latitude, 
                            espaces.p1Latitude, 
                            espaces.p1Longitude, 
                            espaces.p2Latitude, 
                            espaces.p2Longitude, 
                            espaces.p3Latitude, 
                            espaces.p3Longitude
                            FROM 
                            espaces, 
                            locator 
                            WHERE 
                            espaces.idBatiment = locator.idBatiment  
                            AND espaces.nomCourt = :bat 
                            AND locator.secteur = :sect"
                        );
                        $stmt4->execute(array(
                            ":bat" => $_GET['batiment'],
                            ":sect" => $_GET['secteur']
                        ));
                        $row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                        $stmt3 = $pdo->prepare(
                            "SELECT 
                            espacesimages.url 
                            FROM 
                            espacesimages
                            WHERE 
                            espacesimages.idBatiment = " . $row4[0]['idBatiment']
                        );
                        $stmt3->execute();
                        $row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                        /**Ajouter les images au résultat et renvoyer*/
                        echo (json_encode($row4[0]));
                        $result4 = $row4[0];
                        $result4[0]['urls'] = $row3;
                        echo (json_encode($result4[0]));
                    } else { //La range retourne un résultat donc on renvoie le résultats + les images
                        /**Ajouter les images au résultat et renvoyer*/
                        echo (json_encode(array($row2)));
                    }
                } else {
                    // Si la cote n'est pas numérique et n'a pas de match, renvoyer les infos du bâtiment + les images
                    $stmt4 = $pdo->prepare(
                        "SELECT 
                        locator.longitude,
                        locator.latitude, 
                        locator.estAccessible,
                        locator.etage AS 'etageLivre',   
                        espaces.idBatiment,
                        espaces.nomLong, 
                        espaces.longitude, 
                        espaces.latitude, 
                        espaces.p1Latitude, 
                        espaces.p1Longitude, 
                        espaces.p2Latitude, 
                        espaces.p2Longitude, 
                        espaces.p3Latitude, 
                        espaces.p3Longitude
                        FROM 
                        espaces, 
                        locator 
                        WHERE 
                        espaces.idBatiment = locator.idBatiment  
                        AND espaces.nomCourt = :bat 
                        AND locator.secteur = :sect"
                    );
                    $stmt4->execute(array(
                        ":bat" => $_GET['batiment'],
                        ":sect" => $_GET['secteur']
                    ));
                    $row4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
                    /**Rajouter les images et renvoyer le résultat */
                    echo (json_encode($row4[0]));
                }
            } else {
                //On a une correspondance exacte, concaténation des urls au JSON et envoit des résultats
                $stmt3 = $pdo->prepare(
                    "SELECT 
                    espacesimages.url 
                    FROM 
                    espacesimages
                    WHERE 
                    espacesimages.idBatiment = " . $row[0]['idBatiment']
                );
                $stmt3->execute();
                $row3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                $result = $row;
                $result[0]['urls'] = $row3;
                echo (json_encode($result[0]));
            }
        } else {
            //Paramètres invalides, on renvoit une erreur
            echo (json_encode(array("Error" => "Missing parameters")));
        }
        break;
    default:
        echo (json_encode(array("message" => "Method not supported")));
        break;
}
