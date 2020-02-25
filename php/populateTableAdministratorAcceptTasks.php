<?php

include_once '../templates/baza.class.php';
include_once '../templates/aplicationLog.php';
include_once '../templates/sesija.class.php';

$user = Sesija::dajKorisnika();
$userValue = $user['korisnik']; //korisnikov username

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'idzahtjev';
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'DESC';
}

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT zahtjev.idzahtjev, zahtjev.naziv_zahtjeva, "
        . "zahtjev.opis_zahtjeva, zahtjev.datum, zahtjev.kolicina, "
        . "status_zahtjeva.status_zahtjeva, status_zahtjeva.idstatus_zahtjeva "
        . "FROM zahtjev, status_zahtjeva, stavka_zahtjev "
        . "WHERE stavka_zahtjev.zahtjev_idzahtjev = zahtjev.idzahtjev "
        . "AND stavka_zahtjev.status_zahtjeva_idstatus_zahtjeva = status_zahtjeva.idstatus_zahtjeva "
        . "ORDER BY $order $sort";

$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {
    if ($sort == 'DESC') {
        $sort = 'ASC';
    } else {
        $sort = 'DESC';
    }
    echo "<table id='table' class = 'tableScrollUser'>
            <caption>Lista zahtjeva</caption>
            <tr>
                <th onclick='sort(1)'>IDzahtjeva</th>
                <th onclick='sort(2)'>Naziv zahtjeva</a></th>
                <th onclick='sort(3)'>Opis zahtjeva</th>
                <th onclick='sort(4)'>Datum</th>
                <th onclick='sort(5)'>Količina</th>
                <th onclick='sort(6)'>Status zahtjeva</th>
                <th onclick='sort(7)'>Uplati</th>
                <th onclick='sort(8)'></th>
            </tr>"
    . "<tbody id='myTable'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $db_status = $row['idstatus_zahtjeva'];
        $db_idZahtjev = $row['idzahtjev'];
        if ($db_status == 4) {
            $payed = "Administrator mora odobriti";

            $myObjectAccept = new \stdClass();
            $myObjectDecline = new \stdClass();

            $myObjectAccept->idZahtjev = "$db_idZahtjev";
            $myObjectAccept->accepted = 6;

            $myObjectDecline->idZahtjev = "$db_idZahtjev";
            $myObjectDecline->accepted = 2;

            $JSONAccept = json_encode($myObjectAccept);
            $JSONDecline = json_encode($myObjectDecline);

            echo "<tr>"
            . "<td>" . $row['idzahtjev'] . "</td>"
            . "<td>" . $row['naziv_zahtjeva'] . "</td>"
            . "<td>" . $row['opis_zahtjeva'] . "</td>"
            . "<td>" . $row['datum'] . "</td>"
            . "<td>" . $row['kolicina'] . "</td>"
            . "<td>" . $row['status_zahtjeva'] . "</td>"
            . "<td>" . $payed . "</td>"
//        . "<td><input type='checkbox' name='idZahtjev[]' id='idZahtjev' value='" . $db_idZahtjev . " $disabled'></td>"
            . "<td><select name='selectArgument[]' onchange='changeDatabase(this.value)'>"
            . "<option value = ''>Odaberi</option>"
            . "<option value = '$JSONAccept'>Odobreno</option>"
            . "<option value = '$JSONDecline'>Odbijeno</option>"
            . "</select></td>"
            . "</tr>";
        }
        echo "</tbody></table>";
    }
} else {
    echo "0 result";
}

$connect->zatvoriDB();
?>