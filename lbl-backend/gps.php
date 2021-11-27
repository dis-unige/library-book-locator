<?php
require_once  __DIR__ . "/src/header.php";
require_once  __DIR__ . "/src/mysqli.php";
require_once  __DIR__ . "/src/queries.php";
require_once  __DIR__ . "/src/utilities.php";

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['batiment']) && isset($_GET['cote']) && isset($_GET['secteur'])) { // Vérification des paramètres
            // Premier cas. On vérifie si on a une correspondance exacte
            $cote = explode(" ", $_GET['cote']); // Retourne la cote seule.
            $check_if_match = "SELECT locator.longitude as etagereLongitude, locator.latitude as etagereLatitude, locator.estAccessible, locator.etage AS 'etageLivre', locator.salle, locator.secteur, espaces.idBatiment, espaces.nomLong, espaces.longitude as batimentLongitude, espaces.latitude as batimentLatitude, espaces.p1Latitude, espaces.p1Longitude, espaces.p2Latitude, espaces.p2Longitude, espaces.p3Latitude, espaces.p3Longitude FROM espaces, locator WHERE espaces.idBatiment = locator.idBatiment AND espaces.nomCourt = \"" . $_GET['batiment'] . "\" AND locator.secteur = \"" . $_GET['secteur'] . "\" AND locator.racineDeweyDebut = \"" . $cote[0] . "\" AND locator.racineDeweyFin = \"" . $cote[0] . "\"";
            $row_exact = my_q($check_if_match, $conn);
            if (empty($row_exact) || is_null($row_exact)) { // Si on a pas de résultats pour la correspondance exacte
                if (is_numeric($cote[0])) { // Si c'est numérique on fait un range
                    $check_range = "SELECT locator.longitude as etagereLongitude, locator.latitude as etagereLatitude, locator.estAccessible, locator.etage AS 'etageLivre', locator.salle, locator.secteur, espaces.idBatiment, espaces.nomLong, espaces.longitude as batimentLongitude, espaces.latitude as batimentLatitude, espaces.p1Latitude, espaces.p1Longitude, espaces.p2Latitude, espaces.p2Longitude, espaces.p3Latitude, espaces.p3Longitude FROM espaces, locator WHERE espaces.idBatiment = locator.idBatiment AND espaces.nomCourt = \"" . $_GET['batiment'] . "\" AND locator.secteur = \"" . $_GET['secteur'] . "\" AND \"" . pad($cote[0]) . "\" < PADDING(locator.racineDeweyFin) AND  \"" . pad($cote[0]) . "\" > PADDING(locator.racineDeweyDebut)";
                    //$row_range = pdo_query($check_range, $query_args_range, $pdo);
                    $row_range = my_q($check_range, $conn);
                    if (empty($row_range) || is_null($row_exact)) { // Si le range ne donne pas de résultats, on renvoie les informations sur le bâtiment + les images
                        //$row_range_fail = pdo_query($check_range_fail, $query_args_fail, $pdo);
                        $check_range_fail = "SELECT locator.estAccessible, locator.etage AS 'etageLivre', espaces.idBatiment, espaces.nomLong, espaces.longitude as batimentLongitude, espaces.latitude as batimentLatitude, espaces.p1Latitude, espaces.p1Longitude, espaces.p2Latitude, espaces.p2Longitude, espaces.p3Latitude, espaces.p3Longitude FROM espaces, locator WHERE espaces.idBatiment = locator.idBatiment AND espaces.nomCourt = \"" . $_GET['batiment'] . "\" AND locator.secteur = \"" . $_GET['secteur'] . "\"";
                        $row_range_fail = my_q($check_range_fail, $conn);
                        //$row_imgs = pdo_query($check_imgs, $query_args_imgs, $pdo);
                        $check_imgs = "SELECT espacesimages.url, espacesimages.etage FROM espacesimages WHERE espacesimages.idBatiment = \"" . $row_range_fail[0]['idBatiment'] . "\"";
                        $row_imgs = my_q($check_imgs, $conn);
                        /**Ajouter les images au résultat et renvoyer*/
                        //echo (json_encode($row_range_fail[0]));
                        $row_range_fail_imgs = $row_range_fail;
                        $row_range_fail_imgs[0]['urls'] = $row_imgs;
                        echo (json_encode($row_range_fail_imgs[0]));
                        if (empty($row_range_fail) || is_null($row_exact)) {
                            echo (json_encode(array("Error" => "Empty Querry - query range fail")));
                        }
                    } else { //La range retourne un résultat donc on renvoie le résultats + les images
                        /**Ajouter les images au résultat et renvoyer*/
                        $check_imgs = "SELECT espacesimages.url, espacesimages.etage FROM espacesimages WHERE espacesimages.idBatiment = \"" . $row_range[0]['idBatiment'] . "\"";
                        //$row_imgs3 = pdo_query($check_imgs, $query_args_imgs3, $pdo);                        
                        $row_imgs3 = my_q($check_imgs, $conn);
                        $result3 = $row_range;
                        $result3[0]['urls'] = $row_imgs3;
                        echo (json_encode($result3[0]));
                    }
                } else {
                    // Si la cote n'est pas numérique et n'a pas de match, renvoyer les infos du bâtiment + les images
                    // DONE
                    $query_args_fail = array(
                        ":bat" => $_GET['batiment'],
                        ":sect" => $_GET['secteur']
                    );
                    $check_range_fail = "SELECT locator.estAccessible, locator.etage AS 'etageLivre', espaces.idBatiment, espaces.nomLong, espaces.longitude as batimentLongitude, espaces.latitude as batimentLatitude, espaces.p1Latitude, espaces.p1Longitude, espaces.p2Latitude, espaces.p2Longitude, espaces.p3Latitude, espaces.p3Longitude FROM espaces, locator WHERE espaces.idBatiment = locator.idBatiment AND espaces.nomCourt = \"" . $_GET['batiment'] . "\" AND locator.secteur = \"" . $_GET['secteur'] . "\"";
                    //$row_range_fail = pdo_query($check_range_fail, $query_args_fail, $pdo);
                    $row_range_fail = my_q($check_range_fail, $conn);
                    $query_args_imgs = array(
                        ":bat" => $row_range_fail[0]['idBatiment']
                    );
                    $check_imgs = "SELECT espacesimages.url, espacesimages.etage FROM espacesimages WHERE espacesimages.idBatiment = \"" . $row_range_fail[0]['idBatiment'] . "\"";                    //$row_imgs = pdo_query($check_imgs, $query_args_imgs, $pdo);
                    $row_imgs = my_q($check_imgs, $conn);
                    /**Ajouter les images au résultat et renvoyer*/;
                    $row_range_fail_imgs = $row_range_fail;
                    $row_range_fail_imgs[0]['urls'] = $row_imgs;
                }
            } else {
                //On a une correspondance exacte, concaténation des urls au JSON et envoit des résultats
                $query_args_imgs2 = array(
                    ":bat" => $row_exact[0]['idBatiment']
                );
                //$row_imgs2 = pdo_query($check_imgs, $query_args_imgs2, $pdo);
                $check_imgs = "SELECT espacesimages.url, espacesimages.etage FROM espacesimages WHERE espacesimages.idBatiment = \"" . $row_exact[0]['idBatiment'] . "\"";
                $row_imgs2 = my_q($check_imgs, $conn);
                $result = $row_exact;
                $result[0]['urls'] = $row_imgs2;
                echo (json_encode($result[0]));
            }
        } else {
            //Paramètres invalides, on renvoit une erreur
            echo (json_encode(array("Error" => "Missing parameters")));
        }
        break;
    default:
        echo (json_encode(array("Error" => "Method not supported")));
        break;
}
