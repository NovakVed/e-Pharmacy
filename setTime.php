<?php
include_once './templates/sesija.class.php';

$userTypeSession = Sesija::dajKorisnika();
$typeSession = $userTypeSession['tip'];

$arrayList = array(1);
if(!in_array($typeSession, $arrayList)){
    header("Location: ./forms/login.php");
}

header("Location: http://barka.foi.hr/WebDiP/pomak_vremena/vrijeme.html");
?>