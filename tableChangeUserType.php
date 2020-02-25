<?php

include_once './templates/baza.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$requestPayload = file_get_contents("php://input");

$object = json_decode($requestPayload);

$db_user = $object->idKorisnik;
$db_type = $object->idUloga;

$connect = new Baza();
$connect->spojiDB();

$query = "UPDATE korisnik "
        . "SET 	uloga_iduloga = '{$db_type}'"
        . "WHERE idkorisnik = '{$db_user}'";

$connect->updateDB($query);


if ($db_type == 2) {
    AddAplicationLog("Korisnik prebačen u moderatora"); //dnevnik
}
if ($db_type == 3) {
    AddAplicationLog("Korisnik prebačen u registriranog korisnika"); //dnevnik
}

$connect->zatvoriDB();
?>
