<?php

include_once './templates/baza.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$requestPayload = file_get_contents("php://input");

$object = json_decode($requestPayload);

$db_user = $object->idKorisnik;
$db_isActive = $object->is_active;

$connect = new Baza();
$connect->spojiDB();

$query = "UPDATE korisnik "
        . "SET 	is_active = '{$db_isActive}'"
        . "WHERE idkorisnik = '{$db_user}'";

$connect->updateDB($query);


if ($db_type == 0) {
    AddAplicationLog("Korisnik je blokiran"); //dnevnik
}
if ($db_type == 1) {
    AddAplicationLog("Korisnik je otključan"); //dnevnik
}

$connect->zatvoriDB();
?>
