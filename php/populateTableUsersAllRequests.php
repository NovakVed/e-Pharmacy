<?php

include_once './templates/baza.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$user = Sesija::dajKorisnika();
$userValue = $user['korisnik']; //korisnikov username
//ZA SORTIRANJE TABLICE
if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'naziv_zahtjeva';
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}


$connect = new Baza();
$connect->spojiDB();

//TODO: UPIT

$query = "SELECT lijek.naziv_lijeka, zahtjev.naziv_zahtjeva, zahtjev.opis_zahtjeva, zahtjev.datum, zahtjev.kolicina, status_zahtjeva.status_zahtjeva "
        . "FROM lijek, korisnik, narucivanje_lijeka, zahtjev, stavka_zahtjev, status_zahtjeva "
        . "WHERE korisnik.korisnicko_ime = 'vednovak' "
        . "AND korisnik.idkorisnik = narucivanje_lijeka.korisnik_idkorisnik "
        . "AND narucivanje_lijeka.lijek_idlijek = lijek.idlijek "
        . "AND zahtjev.idzahtjev = narucivanje_lijeka.zahtjev_idzahtjev "
        . "AND status_zahtjeva.idstatus_zahtjeva = stavka_zahtjev.status_zahtjeva_idstatus_zahtjeva "
        . "AND stavka_zahtjev.zahtjev_idzahtjev = zahtjev.idzahtjev "
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
                <th><a href='usersAllRequests.php?order=naziv_lijeka&&sort=$sort'>Naziv lijeka</a></th>
                <th><a href='usersAllRequests.php?order=naziv_zahtjeva&&sort=$sort'>Naziv zahtjeva</a></th>
                <th><a href='usersAllRequests.php?order=opis_zahtjeva&&sort=$sort'>Opis zahtjeva</a></th>
                <th><a href='usersAllRequests.php?order=datum&&sort=$sort'>Datum</a></th>
                <th><a href='usersAllRequests.php?order=kolicina&&sort=$sort'>kolicina</a></th>
                <th><a href='usersAllRequests.php?order=status_zahtjeva&&sort=$sort'>Status</a></th>
            </tr>"
    . "<tbody id='myTable'>";

    //TODO: pozivanje tasblice!!
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>"
        . "<td>" . $row['naziv_lijeka'] . "</td>"
        . "<td>" . $row['naziv_zahtjeva'] . "</td>"
        . "<td>" . $row['opis_zahtjeva'] . "</td>"
        . "<td>" . $row['datum'] . "</td>"
        . "<td>" . $row['kolicina'] . "</td>"
        . "<td>" . $row['status_zahtjeva'] . "</td>"
        . "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 result";
}

$connect->zatvoriDB();
?>