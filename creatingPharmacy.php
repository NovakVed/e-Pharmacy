<?php
require './templates/baza.class.php';
require './templates/aplicationLog.php';
require './templates/sesija.class.php';

$userTypeSession = Sesija::dajKorisnika();
$typeSession = $userTypeSession['tip'];

$arrayList = array(1);
if(!in_array($typeSession, $arrayList)){
    header("Location: ./forms/login.php");
}

if (isset($_POST['submit'])) {

    if (isset($_POST['naziv_ljekarne'])) {
        $naziv_ljekarne = $_POST['naziv_ljekarne'];
    }
    if (isset($_POST['email'])) {
        $email = $_POST['email'];
    }
    if (isset($_POST['kontakt_broj'])) {
        $kontakt_broj = $_POST['kontakt_broj'];
    }
    if (isset($_POST['grad'])) {
        $grad = $_POST['grad'];
    }
    if (isset($_POST['postanski_broj'])) {
        $postanski_broj = $_POST['postanski_broj'];
    }
    if (isset($_POST['adresa_lijekarne'])) {
        $adresa_lijekarne = $_POST['adresa_lijekarne'];
    }
    if (isset($_POST['oib'])) {
        $oib = $_POST['oib'];
    }


    $connect = new Baza();
    $connect->spojiDB();

    $query = "INSERT INTO `ljekarna` (`idljekarna`, `naziv_ljekarne`, `email`, `kontakt_broj`, `grad`, `postanski_broj`, `adresa_lijekarne`, `OIB`) "
            . "VALUES( '', '$naziv_ljekarne', '$email', '$kontakt_broj', '$grad', '$postanski_broj', '$adresa_lijekarne', '$oib')";

    $connect->updateDB($query);
    echo '<script language="javascript">';
    echo 'alert("Dodana je nova ljekarna!")';
    echo '</script>';

    $connect->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Dodavanje ljekarni</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vedran Novak">
        <meta name="keywords" content="tablica, retci, grid">
        <meta name="description" content="Stranica sa tablicom">
        <link href="css_vednovak/general.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/table.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/navigation.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_480.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_720.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_850.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/print.css" rel="stylesheet" type="text/css"> 

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!--        <script type="text/javascript" src="javascript/tableSearch.js"></script>
        <script type="text/javascript" src="javascript/ajaxIssueBill.js"></script>-->

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
                    <li><a class="nextPage" href="acceptingRequests.php">PREGLED ZAHTJEVA MODERATOR</a></li>
                    <li><a class="nextPage" href="issueBill.php">IZDAJ RAČUN</a></li>
                    <li><a class="currentPageHighlight" href="creatingPharmacy.php">>KREIRANJE LJEKARNI</a></li>
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

<!--        <p>Pronađi zahtjev:
            onkeyup="tableSearch()
            <input type="text" id="search" name="search" placeholder="Search">
            <button onclick="printPage()">Print this page</button>
        </p>-->
        <form class="registration_form" method="post" name="login_form" action="./creatingPharmacy.php">
            <table id = "table">


                <!--UBACIVANJE KORISNIKA--> 
                <!--<tr>-->
                <?php
//TABLICA DNEVNIK
//                    require './php/populateSelectElementUser.php';
//        require './populateTableIssueBills.php';
                ?>
                <!--
                                    <td><a href="./forms/registration.php">Napravite novog korisnika</a></td>
                                </tr>
                -->
                <!--                KREIRANJE LJEKARNE-->
                <tr>
                    <td><label for="naziv_ljekarne">Naziv ljekarne: </label></td>
                    <td><input type="text" id="naziv_ljekarne" name="naziv_ljekarne" size="20" maxlength="20" placeholder="naziv ljekarne"><br></td>
                    <!--<td id="available"></td>-->
                </tr>
                <tr>
                    <td><label for="email">Email: </label></td>
                    <td><input class="email" type="text" id="email" name="email" size="20" maxlength="20" placeholder="email"><br></td>
                    <!--<td id="nameMessage"></td>-->
                </tr>
                <tr>
                    <td><label for="kontakt_broj">Kontaktni broj: </label></td>
                    <td><input class="correctInput" type="text" id = "kontakt_broj" name="kontakt_broj" size="20" maxlength="20" placeholder="kontaktni broj"></td>
                    <!--<td id="surnameMessage"></td>-->
                </tr>
                <tr>
                    <td><label for="grad">Grad: </label></td>
                    <td><input type="text" id="grad" name="grad" size="20" maxlength="20" placeholder="korisničko ime"><br></td>
                    <!--<td id="available"></td>-->
                </tr>
                <tr>
                    <td><label for="postanski_broj">Poštanski broj: </label></td>
                    <td><input class="correctInput" type="text" id="postanski_broj" name="postanski_broj" size="20" maxlength="20" placeholder="poštanski broj"><br></td>
                    <!--<td id="nameMessage"></td>-->
                </tr>
                <tr>
                    <td><label for="adresa_lijekarne">Adresa: </label></td>
                    <td><input class="correctInput" type="text" id = "adresa_lijekarne" name="adresa_lijekarne" size="20" maxlength="20" placeholder="adresa"></td>
                    <!--<td id="surnameMessage"></td>-->
                </tr>
                <tr>
                    <td><label for="oib">OIB: </label></td>
                    <td><input class="correctInput" type="text" id = "oib" name="oib" size="20" maxlength="20" placeholder="oib"></td>
                    <!--<td id="surnameMessage"></td>-->
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value=" Pošalji " >&nbsp &nbsp &nbsp &nbsp<input name="reset" type="reset" value=" Ponovi "></td>
                </tr>
            </table>
        </form>
        <footer>
            <p>Ime i prezime autora: <a class="nextPageFooter" href="../AboutAuthor.html">Vedran Novak</a></p>
            <address><strong>Kontakt:</strong> <a href="mailto:vednovak@foi.hr">vednovak@foi.hr</a></address>
            <p>&copy; 2019 V.Novak <span class="spanFooter">Zadnje izmijenjeno: 24.03.2019.</span></p>
        </footer>
    </body>
</html>

<!--TODO: pogledaj uploader-->

<?php
//require './php/uploader.php';
?>