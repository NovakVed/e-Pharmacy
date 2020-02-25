<?php
$connect = new Baza();
$connect->spojiDB();

$query = "SELECT korisnik.idkorisnik, korisnik.korisnicko_ime "
        . "FROM korisnik, narucivanje_lijeka, zahtjev, stavka_zahtjev "
        . "WHERE stavka_zahtjev.status_zahtjeva_idstatus_zahtjeva = 1 "
        . "AND zahtjev.idzahtjev = stavka_zahtjev.zahtjev_idzahtjev "
        . "AND korisnik.idkorisnik = narucivanje_lijeka.korisnik_idkorisnik "
        . "AND zahtjev.idzahtjev = narucivanje_lijeka.zahtjev_idzahtjev "
        . "ORDER BY korisnicko_ime ASC";
$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {    
    echo "<td>Odaberite korisnika: <select name='userId' onchange='selectUser(this.value)'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $idUser = $row['idkorisnik'];
        $userName = $row['korisnicko_ime'];
        echo "<option value=$idUser> $userName </option>";
    }
    echo "</select></td>";
}

$connect->zatvoriDB();

?>