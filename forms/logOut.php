<?php
require_once '../templates/sesija.class.php';
require '../templates/baza.class.php';
include_once '../templates/aplicationLog.php';
AddAplicationLog("Korisnik se odjavio");


Sesija::obrisiSesiju();
echo '<script language="javascript">';
echo 'alert("Odjavili ste se!")';
echo '</script>';

header("Location: ../index.php");
?>
