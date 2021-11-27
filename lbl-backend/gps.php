<?php
require_once  __DIR__ . "/src/header.php";
require_once  __DIR__ . "/src/pdo.php";
require_once  __DIR__ . "/src/queries.php";
require_once  __DIR__ . "/src/utilities.php";

switch ($requestMethod) {
    case 'GET':
        if (isset($_GET['batiment']) && isset($_GET['cote']) && isset($_GET['secteur'])) { // Vérification des paramètres
            // Premier cas. On vérifie si on a une correspondance exacte
            $cote = explode(" ", $_GET['cote']); // Retourne la cote seule.
            $query_args_exact = array(
                ":bat" => "Mail", //$_GET['batiment'],
                ":sect" => "espace audiovisuel", //$_GET['secteur'],
                ":racine_debut" => "791.43", //$cote[0],
                ":racine_fin" => "791.43" //$cote[0]
            );
            $row_exact = pdo_query($check_if_match, $query_args_exact, $pdo);
            if (empty($row_exact) || is_null($row_exact)) { // Si on a pas de résultats pour la correspondance exacte
                if (is_numeric($cote[0])) { // Si c'est numérique on fait un range
                    $query_args_range = array(
                        ":bat" => $_GET['batiment'],
                        ":sect" => $_GET['secteur'],
                        ":racine" => pad($cote[0])
                    );
                    $row_range = pdo_query($check_range, $query_args_range, $pdo);
                    if (empty($row_range) || is_null($row_exact)) { // Si le range ne donne pas de résultats, on renvoie les informations sur le bâtiment + les images
                        $query_args_fail = array(
                            ":bat" => $_GET['batiment'],
                            ":sect" => $_GET['secteur']
                        );
                        $row_range_fail = pdo_query($check_range_fail, $query_args_fail, $pdo);

                        $query_args_imgs = array(
                            ":bat" => $row_range_fail[0]['idBatiment']
                        );
                        $row_imgs = pdo_query($check_imgs, $query_args_imgs, $pdo);

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
                        $query_args_imgs3 = array(
                            ":bat" => $row_range[0]['idBatiment']
                        );
                        $row_imgs3 = pdo_query($check_imgs, $query_args_imgs3, $pdo);
                        $result3 = $row_range;
                        $result3[0]['urls'] = $row_imgs3;
                        echo (json_encode($result3[0]));
                        echo (json_encode(array("ici" => "correspondance range")));
                    }
                } else {
                    // Si la cote n'est pas numérique et n'a pas de match, renvoyer les infos du bâtiment + les images
                    // DONE
                    $query_args_fail = array(
                        ":bat" => $_GET['batiment'],
                        ":sect" => $_GET['secteur']
                    );
                    $row_range_fail = pdo_query($check_range_fail, $query_args_fail, $pdo);

                    $query_args_imgs = array(
                        ":bat" => $row_range_fail[0]['idBatiment']
                    );
                    $row_imgs = pdo_query($check_imgs, $query_args_imgs, $pdo);
                    /**Ajouter les images au résultat et renvoyer*/;
                    $row_range_fail_imgs = $row_range_fail;
                    $row_range_fail_imgs[0]['urls'] = $row_imgs;
                    echo (json_encode(array("ici" => "querry pas num pas de match")));
                }
            } else {
                //On a une correspondance exacte, concaténation des urls au JSON et envoit des résultats
                $query_args_imgs2 = array(
                    ":bat" => $row_exact[0]['idBatiment']
                );
                $row_imgs2 = pdo_query($check_imgs, $query_args_imgs2, $pdo);
                $result = $row_exact;
                $result[0]['urls'] = $row_imgs2;
                echo (json_encode($result[0]));
                echo (json_encode(array("ici" => "correspondance exacte")));
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
