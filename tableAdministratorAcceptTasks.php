<?php

include_once './templates/baza.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$requestPayload = file_get_contents("php://input");

$object = json_decode($requestPayload);

$db_request = $object->idZahtjev;
$accept = $object->accepted;

$connect = new Baza();
$connect->spojiDB();

$query = "UPDATE stavka_zahtjev "
        . "SET status_zahtjeva_idstatus_zahtjeva = '{$accept}'"
        . "WHERE zahtjev_idzahtjev = '{$db_request}'";

$connect->updateDB($query);


if ($accept == 6) {
    AddAplicationLog("Korisniku odobren zahtjev lijeka na recept"); //dnevnik
}
if ($accept == 2) {
    AddAplicationLog("Korisniku odobren zahtjev lijeka na recept"); //dnevnik
}

include_once './php/populateTableAdministratorAcceptTasks.php';

$connect->zatvoriDB();
?>
