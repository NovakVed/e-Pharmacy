<?php
//require './templates/baza.class.php';

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT idljekarna, naziv_ljekarne  FROM ljekarna";
$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {    
    echo "<td><select name='pharmacy'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $pharmacyName = $row['naziv_ljekarne'];
        $idPharmachy = $row['idljekarna'];
        echo '<option value=' . $idPharmachy . '>' . $pharmacyName . '</option>';
    }
    echo "</select></td>";
}

$connect->zatvoriDB();
?>