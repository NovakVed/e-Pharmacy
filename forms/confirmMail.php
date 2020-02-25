<?php

require '../templates/baza.class.php';

$username = $_GET['username'];
$code = $_GET['code'];

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT * FROM korisnik "
        . "WHERE korisnicko_ime = '$username'";

$result = $connect->selectDB($query);

$row = mysqli_fetch_assoc($result); //vraca cijeli red dobivenog upita
$db_code = $row['confirmed_code']; //u db_code postavljamo string iz celije(stupca confirmed_code)
$db_expire = $row['email_sent_expires'];

if ($db_code == "0") {
    echo "<h2>Već ste se registrirali!</h2>";
    $connect->zatvoriDB();
    exit;
}

if ($db_expire < date('Y-m-d H:i:s', time())) {
    echo "<h2>Vaš aktivacijski link je ugašen!<br>"
    . "Molimo Vas, registrirajte se ponovno!</h2>";

    $queryDeleteRow = "DELETE korinik WHERE confirmed_code = '{$db_code}'";
    $connect->updateDB($queryDeleteRow);
    $connect->zatvoriDB();
    exit;
}

if ($code == $db_code) {
    $queryUpdateConfirmedCode = "UPDATE korisnik "
            . "SET confirmed_code = '0'"
            . "WHERE korisnicko_ime = '{$username}'";
    $queryUpdateIsActive = "UPDATE korisnik "
            . "SET is_active = '1'"
            . "WHERE korisnicko_ime = '{$username}'";
    $queryUpdateEmailExpires = "UPDATE korisnik "
            . "SET email_sent_expires = '0000-00-00 00:00:00'"
            . "WHERE korisnicko_ime = '{$username}'";

    $connect->updateDB($queryUpdateConfirmedCode);
    $connect->updateDB($queryUpdateIsActive);
    $connect->updateDB($queryUpdateEmailExpires);

    include_once '../templates/aplicationLog.php';
    AddAplicationTask_User("Korisnikov email je potvrđen", $username); //dnevnik

    echo '<a href="login.php">Vaš email je potvrđen i možete se prijaviti!</a>';
} else {
    echo "<h2>Korisnicko ime i kod se ne poklapaju!</h2>";
}



$connect->zatvoriDB();
?>