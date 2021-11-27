<?php
$library_code = $_GET['library_code'];
$location_code = $_GET['location_code'];
$location_name = $_GET['location_name'];
$call_number = $_GET['call_number'];
$title = $_GET['title'];
$lang_code = $_GET['lang_code'];

// appel au service Web 
// http://10.20.18.116/lbl-backend/gps.php?batiment=library_code&secteur=$location_name&cote=$call_number
// extraire Lat et Long du JSON
// JSON de test : https://dis.unige.ch/slsp/locator/test.json

$json = file_get_contents('test.json');
$data = json_decode($json);

$lat = $data->latitude;
$long = $data->longitude;
$accessible = $data->estAccessible;



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioMap</title>
    <link rel="stylesheet" href="assets/js/leaflet/leaflet.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
</head>
<body>
    <header>
        <div class="header">
        </div>
    </header>
    <main style="display: flex;">
        <div id="map"></div>
        <div class="rightside">bla bla bla</div>
    </main>

    <script src="assets/js/leaflet/leaflet.js"></script>

    <script>
    
    var mymap = L.map('map').setView([46.2020, 6.1286], 13);
    
    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(mymap);


	var biblioIcon = L.Icon.extend({
		options: {
			iconSize:     [60, 60],
			iconAnchor:   [30, 61],
			popupAnchor:  [-3, -76]
		}
	});
    
    var bookIcon = new biblioIcon({iconUrl: 'marqueur.png'});
    var noBook = new biblioIcon({iconUrl: 'nobook.png'});
    
    if(<?php echo $accessible; ?> == "1"){
        L.marker([<?php echo $lat; ?>, <?php echo $long; ?>], {icon: bookIcon}).addTo(mymap);
    }else{
        L.marker([<?php echo $lat; ?>, <?php echo $long; ?>], {icon: noBook}).addTo(mymap);
    }
    </script>
    
</body>
</html>