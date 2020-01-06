<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="css/style.css">
    <script type="text/javascript" src="js/app.js"></script>
</head>
<body>
<form action="index.php" method="get">
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
if(isset($_GET['adresse'])){
    
    $data = array(
        'q' => $_GET['adresse'],
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
    
}
include_once('netatmo.php');
?>
</body>
</html>