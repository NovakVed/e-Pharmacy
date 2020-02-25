<?php

include_once './templates/baza.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$requestPayload = file_get_contents("php://input");

$myfile = fopen("time.txt", "r") or die("Nije moguće otvoriti datoteku!");
$hours = fread($myfile,filesize("time.txt"));

$current_time = date('Y-m-d H:i:s', time() + $hours * 60 * 60);

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT zahtjev.kolicina, lijek.cijena_lijeka "
        . "FROM zahtjev, korisnik, lijek, narucivanje_lijeka "
        . "WHERE zahtjev.idzahtjev = '$requestPayload' "
        . "AND zahtjev.idzahtjev = narucivanje_lijeka.zahtjev_idzahtjev "
        . "AND narucivanje_lijeka.lijek_idlijek = lijek.idlijek "
        . "AND narucivanje_lijeka.korisnik_idkorisnik = korisnik.idkorisnik";

$result = $connect->selectDB($query);

$row = mysqli_fetch_assoc($result);
$db_amount = $row['kolicina'];
$db_price = $row['cijena_lijeka'];

$priceSum = $db_amount*$db_price;

$queryUpdate = "INSERT INTO `racun` (`idracun`, `ukupna_cijena`, `datum_izdavanja`, `ostvareni_popust`, `nacin_placanja`, `status_racuna`) "
        . "VALUES( '', '$priceSum', $current_time, 0, 'Gotovina', 0)";

$connect->updateDB($queryUpdate);

$queryUpdateTask = "UPDATE stavka_zahtjev "
            . "SET status_zahtjeva_idstatus_zahtjeva = '10' "
            . "WHERE zahtjev_idzahtjev = '$requestPayload'";

$connect->updateDB($queryUpdateTask);

$connect->zatvoriDB();
AddAplicationLog("Korisniku je poslan dnevni račun");
?>