<?php
$library_code = $_GET['library_code'];
$location_code = $_GET['location_code'];
$location_name = $_GET['location_name'];
$call_number = $_GET['call_number'];
$title = $_GET['title'];
$lang_code = $_GET['lang_code'];
echo $library_code;
// appel au service Web 
// http://10.20.18.116/lbl-backend/gps.php?batiment=library_code&secteur=$location_name&cote=$call_number
// extraire Lat et Long du JSON
// JSON de test : https://dis.unige.ch/slsp/locator/test.json
$myurl = 'http://10.20.18.116/lbl-backend/gps.php?batiment=Mail&secteur=' . urlencode($location_name) . '&cote=' . urlencode($call_number) ;
$json = file_get_contents($myurl);
$data = json_decode($json);

$lat = $data->latitude;
$long = $data->longitude;
// echo '<pre>' . $myurl. '</pre><br/>';
// echo '<pre>' . $myurl2. '</pre><br/>';
// echo $location_name . ' - ' . $call_number;
// echo $lat . ', ' . $long;
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="./leaflet.css"/>
	<link rel="stylesheet" href="./main.css"/>

	<script src="./leaflet.js"></script>
	<script src="./Leaflet.ImageOverlay.Rotated.js"></script>
	<script src="./ors-js-client.js"></script>

	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
</head>
<body>
   <div id="map"></div>
   <div>
		<button id='buttonPlus' onclick='changeFloor(1)'></button>
		<button id='buttonMinus' onclick='changeFloor(-1)'></button>
		<button id='buttonFindMe' onclick='findMe()'></button>

   </div>
   
	<script type="text/javascript">

		//Defining variables
		var bookFloor = 0;
		var currentFloor = bookFloor;
		var isLocationFound = false;
		var userLocation = null;
		var userMarker = null;
		var userRadiusCircle = null;

		//JSON de test
		var example_JSON = [[{"longitude":"6.139237360858187",
		"latitude":"46.194986185964915",
		"estAccessible":"1",
		"nomLong":"Universit\u00e9 Mail",
		"p1Latitude":"46.19485999832131",
		"p1Longitude":"6.138750314712524",
		"p2Latitude":"46.19580687978871",
		"p2Longitude":"6.1397695541381845",
		"p3Latitude":"46.194210168266004",
		"p3Longitude":"6.140005588531495",
		"etage":"1",
		"url":"https://dis.unige.ch/locator/lbl-frontend/Leaflet/plan-1-01_App%20copie_page-0001.jpg"},
		{"longitude":"6.139895360858279",
		"latitude":"46.194927185965064",
		"estAccessible":"1",
		"nomLong":"Universit\u00e9 Mail",
		"p1Latitude":"46.19485999832131",
		"p1Longitude":"6.138750314712524",
		"p2Latitude":"46.19580687978871",
		"p2Longitude":"6.1397695541381845",
		"p3Latitude":"46.194210168266004",
		"p3Longitude":"6.140005588531495",
		"etage":"2",
		"url":"https://dis.unige.ch/locator/lbl-frontend/Leaflet/plan-2-01_App copie_page-0001.jpg"}]]

		//
		var libraryLoc = [example_JSON[0][0]["latitude"],example_JSON[0][0]["longitude"]]; // [46.194927185965064, 6.139895360858279]
		//console.log(libraryLoc);

		//Map creation
		var mymap = L.map('map').setView(libraryLoc, 20);
		L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
		    maxZoom: 30,
		    id: '',
		    tileSize: 512,
		    zoomOffset: -1
		}).addTo(mymap);

		//Defining points to display overlay
		var p1 = L.latLng(example_JSON[0][0]["p1Latitude"], example_JSON[0][0]["p1Longitude"]);
		var p2 = L.latLng(example_JSON[0][0]["p2Latitude"], example_JSON[0][0]["p2Longitude"]);
		var p3 = L.latLng(example_JSON[0][0]["p3Latitude"], example_JSON[0][0]["p3Longitude"]);
		var img_link = []
		for (i=0; i<example_JSON[0].length; i++){
			img_link.push(example_JSON[0][i]["url"])
		}

		//Creating library overlay
		var overlay = L.imageOverlay.rotated(img_link[currentFloor], p1, p2, p3, {
			opacity: 0.7,
			interactive: false,
			attribution: example_JSON[0][0]["nomLong"]
			});
		mymap.addLayer(overlay);
		
		//Creating icon for book marker
		var biblioIcon = L.Icon.extend({
			options: {
				iconSize:     [60, 60],
				iconAnchor:   [30, 61],
				popupAnchor:  [-3, -76]
				}
			});
		var bookIcon = new biblioIcon({iconUrl: 'images/marqueur.png'});
		var userIcon = new biblioIcon({iconUrl: 'images/bonhomme.png'});

		//Creating Book Marker
		var bookRadius = 3;
		var bookMarker = L.marker(libraryLoc, {icon: bookIcon});
		bookMarker.bindPopup("<b>Uni Mail</b><br><b>Lundi-Vendredi</b><br>7h30-23h00<br><b>Samedi</b><br>7h30-18h00<br><b>Dimanche</b><br>Ferm??").openPopup();
		bookMarker.addTo(mymap);
		bookRadiusCircle = L.circle(bookMarker._latlng, bookRadius, {color: '#CF0063'}).addTo(mymap);


		
		//track position in real time
		mymap.locate({watch: true})

		//linking events to functions
		mymap.on('locationfound', onLocationFound);
		// mymap.on('locationfound', travelPath);
		mymap.on('locationerror', onLocationError);

		//code to change displayed image in overlay
		function changeFloor(step) {
			if (currentFloor + step < 0)
				currentFloor = 0;
			else if (currentFloor + step > img_link.length - 1)
				currentFloor = img_link.length;
			else{
				currentFloor += step;
				overlay.setUrl(img_link[currentFloor])	
			}
		}

		//function called when position is found/updated		
		function onLocationFound(e){
			userLocation = e.latlng;

			//remove then add marker to avoid duplicates
			userMarker = L.marker(e.latlng, {icon: userIcon});
			userMarker.removeFrom(mymap);
			userMarker.addTo(mymap);
			
			//remove then add circle to avoid duplicates
			userRadiusCircle = L.circle(e.latlng, e.accuracy);
			userRadiusCircle.removeFrom(mymap);
			userRadiusCircle.addTo(mymap);

			//first time located or re-located
			if(!isLocationFound)
				document.getElementById("buttonFindMe").style.visibility = "visible"; //add location button
			isLocationFound = true;	
		}

		//function called when location isn't found or a timeout happen
		function onLocationError(e){
			console.log(e.message);
			isLocationFound = false;
			document.getElementById("buttonFindMe").style.visibility = "hidden"; //remove location button
		}

		//function to frame user and bookmark
		function findMe(){
			if (isLocationFound) {
				var corner1 = L.latLng(libraryLoc);
				var corner2 = userLocation;
				var boundaries = L.latLngBounds(corner1, corner2);
				mymap.fitBounds(boundaries);
			}
		}
			
	</script>

</body>
</html>