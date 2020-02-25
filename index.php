<?php
//require './templates/baza.class.php';

if (isset($_GET['acceptCookie'])) {
    setcookie('accept_cookie', 'true', time() + 2 * 24 * 60 * 60); //kolacic traje 2 dana
    header('Location: ./');
}
?>

<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Početna stranica</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vedran Novak">
    <meta name="keywords" content="First, Index, Pharmachy">
    <meta name="description" content="Home page">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./css_vednovak/footer.css" rel="stylesheet" type="text/css">

    <!-- Accept Cookie -->
    <link href="css_vednovak/acceptCookie.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="./javascript/ajaxAcceptCookie.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigacija -->
    <?php

    $main_page = "index.php";
    $popisLijekova = "medication.php";
    $login = "";
    $register = "";
    $racuni = "";
    $popisZahtjeva = "";
    $kreirajLjek = "";
    $pregledZahtjeva = "";
    $moderator = "";
    $izdajRacun = "";
    $kreirajLjek = "";
    $kreirajTipLjeka = "";
    $administratorOdobravaLjek = "";
    $upravljanjeKorisnicima = "";
    $promijeniVremenskiPomak = "";
    $postaviVremenskiPomak = "";
    $popisKorisnika = "privatno/korisnici.php";
    $dnevnik = "";
    $odjava = "";
    $oAutoru = "AboutAuthor.php";
    $dokumentacija = "dokumentacija.php";

    include "navigacija/navigationBar.php"; ?>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">Home</li>
        </ol>
    </nav>

    <?php
    //ACCEPTING COOKIE
    if (!isset($_COOKIE['accept_cookie'])) {
        ?>
        <div class="banner">
            <div class="containter">
                <p> Kliknite na akciju "Prihvati" kako biste pristali na upotrebljavanje kolačića </p><br>
                <input type="button" id="acceptCookie" name="acceptCookie" value="Prihvati" onclick="window.open('http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x103/index.php?acceptCookie')">
            </div>
        </div>
    <?php
    }
    ?>

    <div class="bd-example">
        <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
                <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="multimedia/images/jumbotron1.jpg" class="d-block w-100" alt="Slika nije učitana" height="400">
                </div>
                <div class="carousel-item">
                    <img src="multimedia/images/jumbotron5.jpg" class="d-block w-100" alt="Slika nije učitana" height="400">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Dan planeta zemlje</h5>
                        <p>Današnji dan je posvećen našem planetu zemlja! Brinimo se o njemu, jer je on naš jedini planet.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="multimedia/images/jumbotron2.jpg" class="d-block w-100" alt="Slika nije učitana" height="400">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Ljekarna Milanka</h5>
                        <p>Saznajte o novim akcijama u ljekarni Milanka.</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

    <div class="jumbotron">
        <h1 class="display-4">Ljekarna</h1>
        <p class="lead">Dobrodošli na stranicu E-Ljekarne. </p>
        <hr class="my-4">
        <p>Kliknite na sljedeći gumb kako bi ste dobili detaljni pregled svih ljekova koji su trenutno u prodaji i/ili na akciji.</p>
        <a class="btn btn-primary btn-lg" href="medication.php" role="button">Trgovina</a>
    </div>

    <!-- Footer -->
    <?php include "./navigacija/footer.php"; ?>

</body>

</html>