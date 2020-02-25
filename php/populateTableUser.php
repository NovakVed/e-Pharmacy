<?php

//require '../templates/baza.class.php';

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'idkorisnik';
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT k.idkorisnik, k.korisnicko_ime, k.email, k.password, u.naziv_uloge "
    . "FROM korisnik AS k, uloga AS u "
    . "WHERE k.uloga_iduloga = u.iduloga "
    . "ORDER BY $order $sort";

$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {
    if ($sort == 'DESC') {
        $sort = 'ASC';
    } else {
        $sort = 'DESC';
    }
    echo "<table id = 'myTable' class = 'display' cellspacing = '0' width ='100%'>
            <caption>Lista korisnika</caption>
            <thead>
        <tr>
                <th>IDkorisnika</a></th>
                <th>Email</a></th>
                <th>Korisnicko ime</a></th>
                <th>Password</a></th>
                <th>Uloga korisnika</a></th>
            </tr></thead>"
        . "<tbody>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>"
            . "<td>" . $row['idkorisnik'] . "</td>"
            . "<td>" . $row['korisnicko_ime'] . "</td>"
            . "<td>" . $row['email'] . "</td>"
            . "<td>" . $row['password'] . "</td>"
            . "<td>" . $row['naziv_uloge'] . "</td>"
            . "</tr>";
    }
    echo "</tbody><tfoot>
    <tr>
                <th>IDkorisnika</a></th>
                <th>Email</a></th>
                <th>Korisnicko ime</a></th>
                <th>Password</a></th>
                <th>Uloga korisnika</a></th>
            </tr>
            </tfoot></table>";
} else {
    echo "0 result";
}

$connect->zatvoriDB();
