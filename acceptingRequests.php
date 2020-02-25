<?php
include_once './templates/sesija.class.php';

$userTypeSession = Sesija::dajKorisnika();
$typeSession = $userTypeSession['tip'];

$arrayList = array(1, 2, 3);
if (!in_array($typeSession, $arrayList)) {
    header("Location: ./forms/login.php");
}
?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Pogledaj sve zahtjeve</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vedran Novak">
        <meta name="keywords" content="tablica, retci, grid">
        <meta name="description" content="Stranica sa tablicom">
        <link href="css_vednovak/generalsTables.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/table.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/navigation.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_480.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_720.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_850.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/print.css" rel="stylesheet" type="text/css"> 

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script type="text/javascript" src="javascript/tableSearch.js"></script>
        <script type="text/javascript" src="javascript/printPage.js"></script>
        <script type="text/javascript" src="javascript/ajaxAcceptingRequests.js"></script>

    </head>

    <body>
        <header>
            <nav>
                <ul>
                    <li><a class="rectCaption" href="index.php">LJEKARNA</a></li>
                    <li><a class="nextPage" href="medication.php">LJEKOVI</a></li>
                    <li><a class="nextPage" href="request.php">ZAHTJEV</a></li>
                    <li><a class="nextPage" href="bills.php">RAČUNI</a></li>
                    <li><a class="nextPage" href="usersAllRequests.php">POPIS ZAHTJEVA KORISNIKA</a></li>
                    <li><a class="nextPage" href="creatingMedication.php">KREIRAJ LIJEK</a></li>
                    <li><a class="currentPageHighlight" href="acceptingRequests.php">>PREGLED ZAHTJEVA MODERATOR</a></li>
                    <li><a class="nextPage" href="issueBill.php">IZDAJ RAČUN</a></li>
                    <li><a class="nextPage" href="creatingPharmacy.php">KREIRANJE LJEKARNI</a></li>
                    <li><a class="nextPage" href="creatingMedicationType.php">KREIRANJE TIPA LIJEKA</a></li>
                    <li><a class="nextPage" href="administratorAcceptTasks.php">ADMINISTRATOR ODOBRAVA ZAHTJEVE</a></li>
                    <li><a class="nextPage" href="userControlAdministrator.php">UPRAVLJANJE KORISNICIMA</a></li>
                    <li><a class="nextPage" href="setTime.php">PROMIJENI VREMENSKI POMAK</a></li>
                    <li><a class="nextPage" href="virtualTimeChange.php">POSTAVI VREMENSKI POMAK</a></li>
                    <li><a class="nextPage" href="forms/login.php">PRIJAVA</a></li>
                    <li><a class="nextPage" href="forms/registration.php">REGISTRACIJA</a></li>
                    <li><a class="nextPage" href="privatno/korisnici.php">KORISNICI</a></li>
                    <li><a class="nextPage" href="statistics/aplicationLogStatistics.php">DNEVNIK</a></li>
                    <li><a class="nextPage" href="forms/logOut.php">ODJAVA</a></li>
                    <li><a class="nextPage" href="AboutAuthor.html">O AUTORU</a></li>
                </ul>
            </nav>
        </header>

        <p>Pronađi zahtjev:
            <!--onkeyup="tableSearch()-->
            <input type="text" id="search" name="search" placeholder="Search">
            <button onclick="printPage()">Print this page</button>
        </p>
        <?php
//TABLICA DNEVNIK
        require './php/populateTableAcceptingRequests.php';
        ?>
        <footer>
            <p>Ime i prezime autora: <a class="nextPageFooter" href="../AboutAuthor.html">Vedran Novak</a></p>
            <address><strong>Kontakt:</strong> <a href="mailto:vednovak@foi.hr">vednovak@foi.hr</a></address>
            <p>&copy; 2019 V.Novak <span class="spanFooter">Zadnje izmijenjeno: 24.03.2019.</span></p>
        </footer>
    </body>
</html>