<?php

if (isset($_GET['pharmacy'])) {
    $idPharmacy = $_GET['pharmacy'];

    require '../templates/baza.class.php';

    $connect = new Baza();
    $connect->spojiDB();

    $query = "SELECT * FROM ljekarna "
            . "WHERE idljekarna = '$idPharmacy'";

    $result = $connect->selectDB($query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo "<div class ='show_pharmacy'>"
        . "<p>Id ljekarne: " . $row['idljekarna'] . "</p>"
        . "<p>Naziv ljekarne: " . $row['naziv_ljekarne'] . "</p>"
        . "<p>Email: " . $row['email'] . "</p>"
        . "<p>Kontakt broj: " . $row['kontakt_broj'] . "</p>"
        . "<p>Grad: " . $row['grad'] . "</p>"
        . "<p>Poštanski broj: " . $row['postanski_broj'] . "</p>"
        . "<p>Adresa ljekarne: " . $row['adresa_lijekarne'] . "</p>"
        . "<p>OIB: " . $row['OIB'] . "</p>"
        . "</div>";
    }
    $connect->zatvoriDB();
}
?>