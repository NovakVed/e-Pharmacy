<?php

include_once './templates/sesija.class.php';
include_once './templates/aplicationLog.php';
include_once './templates/baza.class.php';

$userTypeSession = Sesija::dajKorisnika();
$typeSession = $userTypeSession['tip'];

$arrayList = array(1);
if(!in_array($typeSession, $arrayList)){
    header("Location: ./forms/login.php");
}

$url = "http://barka.foi.hr/WebDiP/pomak_vremena/pomak.php?format=xml";

if (!($fp = fopen($url, 'r'))) {
    echo "Problem: nije moguće otvoriti url: " . $url;
    exit;
}

// XML data
$xml_string = fread($fp, 10000);
fclose($fp);

// create a DOM object from the XML data
$domdoc = new DOMDocument;
$domdoc->loadXML($xml_string);

$params = $domdoc->getElementsByTagName('brojSati');
$sati = 0;

if ($params != NULL) {
    $sati = $params->item(0)->nodeValue;
}

if(file_exists("time.txt")){ //Ako vec posotoji brise se
    unlink("time.txt");
}

$myfile = fopen("time.txt", "w") or die("Nije moguće otvoriti datoteku!"); //Kreira se novi
$txt = "$sati";
fwrite($myfile, $txt);

//echo '<script language="javascript">';
//echo 'alert("Vrijeme je pomaknuto!")';
//echo '</script>';

AddAplicationLog("Promijenjeno je vrijeme servera");

fclose($myfile);
header("Location: ./index.php");
?>