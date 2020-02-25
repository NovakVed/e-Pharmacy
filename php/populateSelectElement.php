<?php
//require './templates/baza.class.php';

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT idlijek, naziv_lijeka  FROM lijek";
$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {    
    echo "<td><select name='medicationId'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $medicationName = $row['naziv_lijeka'];
        $idlijek = $row['idlijek'];
        echo '<option value=' . $idlijek . '>' . $medicationName . '</option>';
    }
    echo "</select></td>";
}

$connect->zatvoriDB();
?>