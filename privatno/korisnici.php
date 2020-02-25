<?php
//require '../templates/baza.class.php';
?>

<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Popis korisnika</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Vedran Novak">
    <meta name="keywords" content="tablica, retci, grid">
    <meta name="description" content="Stranica sa tablicom">
    <link href="../css_vednovak/footer.css" rel="stylesheet" type="text/css">
    <link href="../css_vednovak/print.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script type="text/javascript" src="../javascript/printPage.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>

</head>

<body>
    <!-- Navigacija -->
    <?php

    $main_page = "../index.php";
    $popisLijekova = "../medication.php";
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
    $korisnici = "";
    $dnevnik = "";
    $odjava = "";
    $oAutoru = "../AboutAuthor.php";
    $dokumentacija = "../dokumentacija.php";

    include "../navigacija/navigationBar.php"; ?>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Popis Korisnika</li>
        </ol>
    </nav>

    <script>
        function printDiv(divName) {
            var printContents = document.getElementById(divName).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>

    <button type="button" title="Klikni za printanje" class="btn btn-info" onclick="printDiv('printableArea')">Print this page</button>
    <br><br>
    <div id="printableArea">
        <!-- TABLICA KORISNIKA -->
        <?php
        require '../php/populateTableUser.php';
        ?>
    </div>
    <!-- Footer -->
    <?php include "../navigacija/footer.php"; ?>
</body>

</html>