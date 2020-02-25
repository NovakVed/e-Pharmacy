<?php

$idMedication = $_GET['medicatoin'];

require '../templates/baza.class.php';

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT l.idlijek, l.naziv_lijeka, l.opis_lijeka, l.direktorij_slike, l.cijena_lijeka, v.naziv_vrste, v.opis_vrste "
        . "FROM lijek AS l, vrsta_lijeka AS v "
        . "WHERE l.vrsta_lijeka_idvrsta_lijeka = v.idvrsta_lijeka AND l.idlijek = '$idMedication'";

$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $imageDir = $row['direktorij_slike'];
    echo "<div class ='show_medication'>"
    . "<img src='../multimedia/images/$imageDir'/>"
    . "<p>ID ljeka: " . $row['idlijek'] . "</p>"
    . "<p>Naziv ljeka: " . $row['naziv_lijeka'] . "</p>"
    . "<p>Opis ljeka: " . $row['opis_lijeka'] . "</p>"
    . "<p>" . $row['naziv_vrste'] . "</p>"
    . "<p>" . $row['opis_vrste'] . "</p>"
    . "</div>";
}
$connect->zatvoriDB();
?>