<?php

$check_if_match =
"SELECT 
    locator.longitude as etagereLongitude,
    locator.latitude as etagereLatitude, 
    locator.estAccessible,
    locator.etage AS 'etageLivre',
    locator.salle,
    locator.secteur,   
    espaces.idBatiment,
    espaces.nomLong, 
    espaces.longitude as batimentLongitude, 
    espaces.latitude as batimentLatitude, 
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
    AND locator.racineDeweyFin = :racine_fin";

$check_range = 
"SELECT 
    locator.longitude as etagereLongitude,
    locator.latitude as etagereLatitude, 
    locator.estAccessible,
    locator.etage AS 'etageLivre',
    locator.salle,
    locator.secteur,   
    espaces.idBatiment,
    espaces.nomLong, 
    espaces.longitude as batimentLongitude, 
    espaces.latitude as batimentLatitude, 
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
    AND :racine < PADDING(locator.racineDeweyFin)
    AND :racine > PADDING(locator.racineDeweyDebut)";

$check_range_fail =
"SELECT 
    locator.estAccessible,
    locator.etage AS 'etageLivre',
    espaces.idBatiment,
    espaces.nomLong, 
    espaces.longitude as batimentLongitude, 
    espaces.latitude as batimentLatitude,  
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
    AND locator.secteur = :sect";

$check_imgs =  
"SELECT 
    espacesimages.url,
    espacesimages.etage 
FROM 
    espacesimages
WHERE 
    espacesimages.idBatiment = :bat";