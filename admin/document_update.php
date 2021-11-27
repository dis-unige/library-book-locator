<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
	</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<a class="navbar-brand">Locator</a>
		</div>
	</nav>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<h3 class="text-primary">Locator Book</h3>
		<hr style="border-top:1px dotted #ccc;"/>
		<div class="col-md-12">
<?php
require 'conn.php';
if(ISSET($_POST['register'])){

    $barcode = $_POST['barcode'];
    $lat = $_POST['lat'];
    $long = $_POST['long'];
    $ip = $_POST['ip'];
    $now = date("Y-m-d H:i:s");
    
    mysqli_query($conn, "INSERT INTO `locator` VALUES('', '$barcode', '$lat', '$long', '$ip', '$now')") or die(mysqli_error());
    
    echo "<h4>Document enregistré avec succès</h4>\n";
    echo "<br/>\n";
    echo "<ul>\n";
    echo "<li>Barcode : " . $barcode . "</li>\n";
    echo "<li>Lat : " . $lat . "</li>\n";
    echo "<li>Long : " . $long . "</li>\n";
    echo "<li>Enregistré le : " . $now . "</li>\n";
    echo "</ul>\n";
    echo "<hr style=\"border-top:1px dotted #ccc;\"/>\n";
    echo "<br/>\n";
    echo "</div>\n";
    echo "</div>\n";
}
else {
    echo "<b>Error</b>\n";
    echo "<br/><br/>\n";
    echo "<a href=\"index.php\">Retour à la page d'accueil</a>";
    echo "<br/><br/>\n";
    echo "</div>\n";
    echo "</div>\n";
}

?>
	</div>	
</body>
</html>