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
<input type="text" name="adresse" id="adresse">
<br />
<br />
<input type="submit" value="Envoyez">
</form>
<br>
<br>
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