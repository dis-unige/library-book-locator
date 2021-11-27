<?php 
// center_lat=&center_long=&point1_lat=&point1_long=&point2_lat=&point2_long=&point3_lat=&point3_long=&url=&point1_long=&images=
// require 'conn.php';
$nomLong = $_GET["nomLong"];
$nomCourt = $_GET["nomCourt"];
$codeUnige = $_GET["codeUnige"];
$center_lat = $_GET["center_lat"];
$center_long = $_GET["center_long"];
$point1_lat = $_GET["point1_lat"];
$point1_long = $_GET["point1_long"];
$point2_lat = $_GET["point2_lat"];
$point2_long = $_GET["point2_long"];
$point3_lat = $_GET["point3_lat"];
$point3_long = $_GET["point3_long"];
$images = $_GET["images"];
// $now = date("Y-m-d H:i:s");

// require 'conn.php';
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
        <h3 class="text-primary">Creation du bâtiment</h3>
        <ul>
            <li>nomLong : <?php echo $nomLong; ?></li>
            <li>nomCourt : <?php echo $nomCourt; ?></li>
            <li>codeUnige : <?php echo $codeUnige; ?></li>
            <li>center_lat : <?php echo $center_lat; ?></li>
            <li>center_long : <?php echo $center_long; ?></li>
            <li>point1_lat : <?php echo $point1_lat; ?></li>
            <li>point1_long : <?php echo $point1_long; ?></li>
            <li>point2_lat : <?php echo $point2_lat; ?></li>
            <li>point2_long : <?php echo $point2_long; ?></li>
            <li>point3_lat : <?php echo $point3_lat; ?></li>
            <li>point3_long : <?php echo $point3_long; ?></li>
            <li>images : <?php echo $images; ?></li>
        </ul>

<?php
if(ISSET($_GET["center_lat"])&&ISSET($_GET["center_long"])){
    //mysqli_query($conn, "INSERT INTO `locator` VALUES('', '$barcode', '$lat', '$long', '$ip', '$now')") or die(mysqli_error());
    echo "<br/><b>Données OK</b><br/>";
}
else{
    echo "<b>Error</b>\n";
    echo "<br/><br/>\n";
    echo "<a href=\"index.php\">Retour à la page d'accueil</a>";
    echo "<br/><br/>\n";
}
?>
		<div class="col-md-12">
	</div>	
</body>
</html>