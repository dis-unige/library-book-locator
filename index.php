<?php
$library_code = $_GET['library_code'];
$location_code = $_GET['location_code'];
$location_name = $_GET['location_name'];
$call_number = $_GET['call_number'];
$title = $_GET['title'];
$lang_code = $_GET['lang_code'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
    <title>Library Book Locator</title>

</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <a class="navbar-brand">Library Book Locator</a>
        </div>
    </nav>
    <div class="col-md-3"></div>
    <div class="col-md-6 well">
        <h3 class="text-primary">Localisation du document</h3>
        <ul>
            <li>Titre : <?php echo $title; ?></li>
            <li>Langue: <?php echo $lang_code; ?></li>
            <li>Bibliothèque: <?php echo $library_code; ?></li>
            <li>Localisation : <?php echo $location_name . " (" . $location_code . ")"; ?></li>
            <li>Cote : <?php echo $call_number; ?></li>
        </ul>
        <input type="button" value="GET JSON" onclick="window.location.href='/lbl-backend/gps.php?batiment=Mail&secteur=<?php echo $location_name; ?>&cote=<?php echo $call_number; ?>'"/>
        <!-- <input type="button" value="LOCALISATION" onclick="window.location.href='https://dis.unige.ch/slsp/locator/Leaflet/main.html'"/> -->
        <br/><hr/>
        <iframe src="https://dis.unige.ch/slsp/locator/Leaflet/main.html" title="Localisation" width="100%" height="500" style="border:none;></iframe>
        <div class="col-md-12">
        </div>
    </div>
</body>
</html>