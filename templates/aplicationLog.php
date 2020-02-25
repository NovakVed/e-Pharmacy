<?php

function AddAplicationLog($task) {
    $connectAL = new Baza();
    $connectAL->spojiDB();

    $user = Sesija::dajKorisnika();

    $page = $_SERVER["REQUEST_URI"]; //Visited page
    $adresaIP = $_SERVER["REMOTE_ADDR"]; //Users IP adress

    $myfile = fopen("../time.txt", "r") or die("Nije moguće otvoriti datoteku!");
    $hours = fread($myfile, filesize("../time.txt"));

    $current_time = date('Y-m-d H:i:s', time() + $hours * 60 * 60);

    $type = null;

    if ($user['tip'] == 1) {
        $type = "Administrator";
    }
    if ($user['tip'] == 2) {
        $type = "Moderator";
    }
    if ($user['tip'] == 3) {
        $type = "Registrirani korisnik";
    }
    if ($user['tip'] == 4) {
        $type = "Neregistrirani korisnik";
    }

    if ($type == null) {
        $type = "Neregistrirani korisnik";
        $task = "Neregistrirani korisnik se pokušao odjaviti";
    }

    preg_match('/[^\/]+$/', $page, $pageScript); //nakon zadnje / sve prikazi i upisi u array
    $pageURL = $pageScript[0]; //izvadi prvi element array.a

    $queryUpdateLog = "INSERT INTO dnevnik(idDnevnik, dnevnik_korisnik, dnevnik_korisnik_tip, dnevnik_IPadresa, dnevnik_page, dnevnik_task, dnevnik_vrijeme)"
            . "VALUES ( '', '{$user['korisnik']}', '$type', '$adresaIP', '$pageURL', '$task', '$current_time')";

    $connectAL->updateDB($queryUpdateLog);
    $connectAL->zatvoriDB();
}

function AddAplicationTask_User($task, $username) {
    $connectAL = new Baza();
    $connectAL->spojiDB();
    $page = $_SERVER["REQUEST_URI"]; //Visited page
    $adresaIP = $_SERVER["REMOTE_ADDR"]; //Users IP adress



    $myfile = fopen("../time.txt", "r") or die("Nije moguće otvoriti datoteku!");
    $hours = fread($myfile, filesize("../time.txt"));


    $current_time = date('Y-m-d H:i:s', time() + $hours * 60 * 60); //Current time task was sent

    preg_match('/[^\/]+$/', $page, $pageScript); //nakon zadnje / sve prikazi i upisi u array
    $pageURL = $pageScript[0]; //izvadi prvi element array.a

    $queryUpdateLog = "INSERT INTO dnevnik(idDnevnik, dnevnik_korisnik, dnevnik_korisnik_tip, dnevnik_IPadresa, dnevnik_page, dnevnik_task, dnevnik_vrijeme) "
            . "VALUES('', '$username' , 'Neregistrirani korisnik', '$adresaIP', '$pageURL', '$task', '$current_time')";


    $connectAL->updateDB($queryUpdateLog);
    $connectAL->zatvoriDB();
}

function AddAplicationTask_User_RegisteredUser($task, $username) {
    $connectAL = new Baza();
    $connectAL->spojiDB();
    $page = $_SERVER["REQUEST_URI"]; //Visited page
    $adresaIP = $_SERVER["REMOTE_ADDR"]; //Users IP adress


    $myfile = fopen("../time.txt", "r") or die("Nije moguće otvoriti datoteku!");
    $hours = fread($myfile, filesize("../time.txt"));

    $current_time = date('Y-m-d H:i:s', time() + $hours * 60 * 60); //Current time task was sent

    preg_match('/[^\/]+$/', $page, $pageScript);
    $pageURL = $pageScript[0];

    $queryUpdateLog = "INSERT INTO dnevnik(idDnevnik, dnevnik_korisnik, dnevnik_korisnik_tip, dnevnik_IPadresa, dnevnik_page, dnevnik_task, dnevnik_vrijeme) "
            . "VALUES('', '$username' , 'Registrirani korisnik', '$adresaIP', '$pageURL', '$task', '$current_time')";


    $connectAL->updateDB($queryUpdateLog);
    $connectAL->zatvoriDB();
}

?>