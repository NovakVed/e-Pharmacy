<?php

if (isset($_REQUEST['new_username'])) {
    require '../templates/baza.class.php';

    $connect = new Baza();
    $connect->spojiDB();

    $korime = $_REQUEST["new_username"];

    $query = "SELECT *FROM korisnik "
            . "WHERE korisnicko_ime='{$korime}'";
    $result = $connect->selectDB($query);

    $hint = "";
    
    if (mysqli_num_rows($result) > 0) {
        $hint = "Postoji";
        echo $hint;
    } else {
        $hint = "Ne postoji";
        echo $hint;
    }
    $connect->zatvoriDB();
}
?>