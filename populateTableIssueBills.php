<?php

include_once './templates/baza.class.php';
include_once './templates/sesija.class.php';

$user = Sesija::dajKorisnika();
$userValue = $user['korisnik']; //korisnikov username

$requestPayload = "";
$requestPayload = file_get_contents("php://input");

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'idzahtjev';
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT zahtjev.idzahtjev, zahtjev.naziv_zahtjeva, zahtjev.opis_zahtjeva, "
        . "zahtjev.datum, zahtjev.kolicina, korisnik.idkorisnik, korisnik.korisnicko_ime "
        . "FROM korisnik, narucivanje_lijeka, zahtjev, stavka_zahtjev "
        . "WHERE stavka_zahtjev.status_zahtjeva_idstatus_zahtjeva = 1 "
        . "AND zahtjev.idzahtjev = stavka_zahtjev.zahtjev_idzahtjev "
        . "AND korisnik.idkorisnik = narucivanje_lijeka.korisnik_idkorisnik "
        . "AND zahtjev.idzahtjev = narucivanje_lijeka.zahtjev_idzahtjev "
        . "AND korisnik.idkorisnik = '$requestPayload' "
        . "ORDER BY $order $sort";

$result = $connect->selectDB($query);

$current_time = date('Y-m-d H:i:s', time());
if (mysqli_num_rows($result) > 0) {
    if ($sort == 'DESC') {
        $sort = 'ASC';
    } else {
        $sort = 'DESC';
    }
    echo "<table class = 'tableScrollUser'>
            <caption>Lista korisnika</caption>
            <tr>
                <th><a href='issueBill.php?order=idzahtjev&&sort=$sort'>idZahtjeva</a></th>
                <th><a href='issueBill.php?order=naziv_zahtjeva&&sort=$sort'>Naziv zahtjeva</a></th>
                <th><a href='issueBill.php?order=opis_zahtjeva&&sort=$sort'>Opis zahtjeva</a></th>
                <th><a href='issueBill.php?order=datum&&sort=$sort'>Datum</a></th>
                <th><a href='issueBill.php?order=kolicina&&sort=$sort'>Kolicina</a></th>
                <th>Pošalji račun</th>
            </tr>"
    . "<tbody id='myTable'>";

    while ($row = mysqli_fetch_assoc($result)) { //TODO: popuni tablicu sa onim podacima sto su gore!!
        $db_time = $row['datum'];
        $bill_expires = date('Y-m-d H:i:s', strtotime($db_time) + 24 * 60 * 60);
        if ($current_time < $bill_expires) {
            $db_idZahtjev = $row['idzahtjev'];
//        $db_idRacuna = $row['idracun'];
//        if ($db_status == 0) {
//            $payed = "Nije plačeno";
//            $checked = "";
//        } else {
//            $payed = "Plačeno";
//            $checked = "checked";
//        }
            echo "<tr>"
            . "<td>" . $row['idzahtjev'] . "</td>"
            . "<td>" . $row['naziv_zahtjeva'] . "</td>"
            . "<td>" . $row['opis_zahtjeva'] . "</td>"
            . "<td>" . $row['datum'] . "</td>"
            . "<td>" . $row['kolicina'] . "</td>"
//        . "<td>" . $payed . "</td>"
            . "<td><input type='button' id='btnIssueBill' name='btnIssueBill' onclick='issueBill($db_idZahtjev)'></td>" //TODO
            . "</tr>";
        } else {
            echo "Prošlo je vrijeme!";
        }
    }
    echo "</tbody></table>";
} else {
    echo "0 result";
}

$connect->zatvoriDB();
?>
