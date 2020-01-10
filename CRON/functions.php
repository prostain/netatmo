<?php
require 'db_connect.php';

$bdd = getDB();

//liste des Villes 
$res = $bdd->query('SELECT * FROM cities WHERE department_code = \'05\'');
$villes = $res->fetchAll(PDO::FETCH_ASSOC);

if($villes) {

    foreach($villes as $ville) {
        $data = array(
            'q' => $ville['name'],
            'format'     => 'json',
        );
        $url = 'https://nominatim.openstreetmap.org/?' . http_build_query($data);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
        $geopos = curl_exec($ch);
        $geopos = json_decode($geopos);
        var_dump($geopos);

        $positions = $geopos[0]->boundingbox;
        $NE = [ 'lat' => $positions[1], 'lon' => $positions[3] ];
        $SW = [ 'lat' => $positions[0], 'lon' => $positions[2] ];
        
        $longe = ($positions[0]+$positions[1])/2;
        $lati = ($positions[2]+$positions[3])/2;

        include_once('netatmo.php');

        //erreur trouvé
        $req = $bdd->prepare('INSERT INTO temperarures (`Date`, tempAVG, altiAVG, latNE, LonNE, latSW, lonSW, idCity) 
        VALUES (NOW(),:tempAVG, :altiAVG,:latNE, :LonNE, :latSW, :lonSW,:idCity');

        $req->bindValue('tempAVG', round($temp,2), PDO::PARAM_STR);
        $req->bindValue('altiAVG', round($alti,2), PDO::PARAM_STR);
        $req->bindValue('latNE', $positions[1], PDO::PARAM_STR);
        $req->bindValue('LonNE', $positions[3], PDO::PARAM_STR);
        $req->bindValue('LonNE', $positions[0], PDO::PARAM_STR);
        $req->bindValue('lonSW', $positions[2], PDO::PARAM_STR);
        $req->bindValue('idCity', $ville['id'], PDO::PARAM_STR);
        $req->execute();

    }


}