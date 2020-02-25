<?php

include_once './templates/baza.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$user = Sesija::dajKorisnika();
$userValue = $user['korisnik']; //korisnikov username

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'datum_izdavanja';
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'DESC';
}

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT racun.idracun, racun.ukupna_cijena, racun.datum_izdavanja, racun.ostvareni_popust, racun.nacin_placanja, racun.status_racuna "
        . "FROM korisnik, racun, stavka_racuna WHERE korisnik.korisnicko_ime = '$userValue' "
        . "AND korisnik.idkorisnik = stavka_racuna.korisnik_idkorisnik "
        . "AND stavka_racuna.racun_idracun = racun.idracun "
        . "ORDER BY $order $sort";

$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {
    if ($sort == 'DESC') {
        $sort = 'ASC';
    } else {
        $sort = 'DESC';
    }
    echo "<table class = 'tableScrollUser'>
            <caption>Lista korisnika</caption>
            <tr>
                <th><a href='bills.php?order=idracun&&sort=$sort'>IDracun</a></th>
                <th><a href='bills.php?order=ukupna_cijena&&sort=$sort'>Ukupna cijena</a></th>
                <th><a href='bills.php?order=datum_izdavanja&&sort=$sort'>Datum izdavanja</a></th>
                <th><a href='bills.php?order=ostvareni_popust&&sort=$sort'>Ostvareni popust</a></th>
                <th><a href='bills.php?order=nacin_placanja&&sort=$sort'>Nacin placanja</a></th>
                <th><a href='bills.php?order=status_racuna&&sort=$sort'>Status placanja</a></th>
                <th>Uplati</th>
            </tr>"
    . "<tbody id='myTable'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $db_status = $row['status_racuna'];
        $db_idRacuna = $row['idracun'];
        if ($db_status == 0) {
            $payed = "Nije plačeno";
            $checked = "";
        } else {
            $payed = "Plačeno";
            $checked = "checked";
        }
        echo "<tr>"
        . "<td>" . $row['idracun'] . "</td>"
        . "<td>" . $row['ukupna_cijena'] . "</td>"
        . "<td>" . $row['datum_izdavanja'] . "</td>"
        . "<td>" . $row['ostvareni_popust'] . "</td>"
        . "<td>" . $row['nacin_placanja'] . "</td>"
        . "<td>" . $payed . "</td>"
        . "<td><input type='checkbox' $checked name='idRacuna[]' id='idRacuna' value='" . $db_idRacuna . "'></td>"
        . "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 result";
}

$connect->zatvoriDB();
?>
