<?php

define('HOST', 'localhost');
define('DB_NAME', 'petersonqvpitou');
define('USER', 'root'); //erreur nom utilisateur
define('PASS', '');

function getDB(){
    $DB = false;
    try{
        //erreur trouvé : invertion entre USER et PASS
        $DB = new PDO(
            'mysql:host='.HOST.';dbname='.DB_NAME.';charset=utf8',
            USER,
            PASS
        );
    }catch(Exception $e){
        var_dump($e);
    }
    return $DB;
}