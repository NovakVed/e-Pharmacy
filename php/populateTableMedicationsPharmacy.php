<?php
$query = "SELECT l.idlijek, l.naziv_lijeka, l.opis_lijeka, direktorij_slike, u.idljekarna, u.naziv_ljekarne "
    . "FROM lijek AS l, ljekarna AS u, lijek_u_lijekarni p "
    . "WHERE l.idlijek = p.lijek_idlijek "
    . "AND u.idljekarna = p.ljekarna_idljekarna "
    . "ORDER BY l.naziv_lijeka ASC "
    . "LIMIT $this_page_first_result, $pageLenght";

$result = $connect->selectDB($query);
$i = 0; //defined $i
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $i = 0 + $i;
        $medicatoin = $row['idlijek'];
        $direktorijSlike = './multimedia/images/' . $row['direktorij_slike'];
        $pharmacy = $row['idljekarna'];

        if ($i == 0) {
            echo "<div class='card-deck'>";
        }

        echo "<div class='card' style='width: 18rem;'>"
            . "<img style='border-bottom: solid; border-width: thin;' src='$direktorijSlike' class='card-img-top' height='60%' width='60%' alt='Slika nije učitana'/>"
            . "<div class='card-body'>"
            . "<h5 class='card-title'><a href='http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x103/php/showMedication.php?medicatoin=$medicatoin' class='card-link'>" . $row['naziv_lijeka'] . "</a></h5>"
            . "<p class='card-text'>" . $row['opis_lijeka'] . "</p>"
            . "<strong><p class='card-text'>" . "Naziv ljekarne" . "</p></strong>"
            . "<p><a href='http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x103/php/showPharmacy.php?pharmacy=$pharmacy' class='card-link'>" . $row['naziv_ljekarne'] . "</a></p>"
            . "</div></div>";

        $i++;
        if ($i != 0 && $i % 5 == 0) {
            echo "</div> <br>"
                . "<div class='card-deck'>";
        }
    }
} else {
    echo "0 result";
}
$connect->zatvoriDB();
