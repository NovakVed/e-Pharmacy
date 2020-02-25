<?php
//require './templates/baza.class.php';

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT idvrsta_lijeka, naziv_vrste  FROM vrsta_lijeka";
$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {    
    echo "<td><select name='medicatoin_type'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $medicationType = $row['naziv_vrste'];
        $idMedicatoinType = $row['idvrsta_lijeka'];
        echo '<option value=' . $idMedicatoinType . '>' . $medicationType . '</option>';
    }
    echo "</select></td>";
}

$connect->zatvoriDB();
?>