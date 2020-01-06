<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="js/leaflet/leaflet.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
<form action="index.php" method="post">
<label for="adresse">Votre adresse </label>
<?php if(isset($_POST['adresse'])){
    ?>
<input type="text" name="adresse" id="adresse" value="<?php echo $_POST['adresse']?>">
<?php
}
else
{
    ?>
    <input type="text" name="adresse" id="adresse">
    <?php
}
?>
<input type="submit" value="Envoyez">
</form>
<?php 
/* Géocoding */
if(isset($_POST['adresse'])){
    
    $data = array(
        'q' => $_POST['adresse'],
        'format'     => 'json',
    );
    $url = 'https://nominatim.openstreetmap.org/?' . http_build_query($data);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
    $geopos = curl_exec($ch);
    $geopos = json_decode($geopos);
    $positions = $geopos[0]->boundingbox;
    $NE = [ 'lat' => $positions[1], 'lon' => $positions[3] ];
    $SW = [ 'lat' => $positions[0], 'lon' => $positions[2] ];
    
    $longe = ($positions[0]+$positions[1])/2;
    $lati = ($positions[2]+$positions[3])/2;
    
}
include_once('netatmo.php');
?>
<h1><?php echo $_POST['adresse'] ?> </h1>
    <div id="map" class="map"></div>
        <div class="resultat ">
            <p>
                <strong>Latitude NE :</strong> <?php echo $positions[1]?><br>
                <strong>Longitude NE :</strong> <?php echo $positions[3]?><br>
                <strong>Latitude SW :</strong> <?php echo $positions[0]?><br>
                <strong>Longitude SW :</strong> <?php echo $positions[2]?><?php echo $count?><br>
                <strong>Température Moyenne :</strong> <?php echo round($temp,2)?> °C.<br>
                <strong>Altitude Moyenne :</strong> <?php echo round($alti,2)?> mètres.<br>
                <strong>Nombre de stations :</strong> <?php echo $count?> <br>
            </p>
        </div>
    <script src="js/leaflet/leaflet.js"></script>
    <script >
    ////////////// MAP //////////////
// Création de la carte
// SetView(Position, puissance du zoom)
let map = L.map('map').setView([<?php echo $longe ?>, <?php echo $lati?>], 11);
// Mentions aux développeurs
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);
    </script>
</body>
</html>