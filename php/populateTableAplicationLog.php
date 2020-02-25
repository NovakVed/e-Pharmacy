<?php
require '../templates/baza.class.php';

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'idDnevnik';
}
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}
if(isset($_GET['page'])){
    $page = $_GET['page'];
} else{
    $page = 1; 
}

$pageLenght = 10;

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT * FROM dnevnik ";        

$result = $connect->selectDB($query);
$elements = mysqli_num_rows($result);


$num_of_pages = ceil($elements/$pageLenght);
$this_page_first_result = ($page-1)*$pageLenght;

$query = "SELECT * FROM dnevnik "
        . "ORDER BY $order $sort "
        . "LIMIT $this_page_first_result, $pageLenght";
        

for($page = 1; $page<=$num_of_pages; $page++){
    echo '<a href="aplicationLogStatistics.php?page=' . $page .  '"> ' . $page . '  </a>';
}

$result = $connect->selectDB($query);
if (mysqli_num_rows($result) > 0) {
    if ($sort == 'DESC') {
        $sort = 'ASC';
    } else {
        $sort = 'DESC';
    }
    echo "<table class ='tableScrollLog'>
            <caption>Dnevnik</caption>
            <tr>
                <th><a href='aplicationLogStatistics.php?order=idDnevnik&&sort=$sort'>idDnevnik</a></th>
                <th><a href='aplicationLogStatistics.php?order=dnevnik_korisnik&&sort=$sort'>Korisnik</a></th>
                <th><a href='aplicationLogStatistics.php?order=dnevnik_korisnik_tip&&sort=$sort'>Tip korisnika</a></th>
                <th><a href='aplicationLogStatistics.php?order=dnevnik_IPadresa&&sort=$sort'>IP adresa</a></th>
                <th><a href='aplicationLogStatistics.php?order=dnevnik_page&&sort=$sort'>Stranica</a></th>
                <th><a href='aplicationLogStatistics.php?order=dnevnik_task&&sort=$sort'>Zadatak</a></th>
                <th><a href='aplicationLogStatistics.php?order=dnevnik_vrijeme&&sort=$sort'>Vrijeme</a></th>
            </tr>"
            . "<tbody id='myTable'>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>"
        . "<td>" . $row['idDnevnik'] . "</td>"
        . "<td>" . $row['dnevnik_korisnik'] . "</td>"
        . "<td>" . $row['dnevnik_korisnik_tip'] . "</td>"
        . "<td>" . $row['dnevnik_IPadresa'] . "</td>"
        . "<td>" . $row['dnevnik_page'] . "</td>"
        . "<td>" . $row['dnevnik_task'] . "</td>"
        . "<td>" . $row['dnevnik_vrijeme'] . "</td>"
        . "</tr>";
    }
    echo "</tbody></table>";
} else {
    echo "0 result";
}

$connect->zatvoriDB();
?>