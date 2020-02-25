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

?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Kreiraj tip lijeka</title>
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
                    <li><a class="nextPage" href="creatingPharmacy.php">KREIRANJE LJEKARNI</a></li>
                    <li><a class="currentPageHighlight" href="creatingMedicationType.php">>KREIRANJE TIPA LIJEKA</a></li>
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

        <form class="registration_form" method="post" name="login_form" action="./creatingMedicationType.php">
            <table id = "table">

                <!--                KREIRANJE LJEKARNE-->
                <tr>
                    <td><label for="naziv_vrste">Naziv vrste: </label></td>
                    <td><input type="text" id="naziv_vrste" name="naziv_vrste" size="20" maxlength="20" placeholder="naziv vrste"><br></td>
                </tr>
                <tr>
                    <td><label for="opis_vrste">Opis: </label></td>
                    <td><input class="email" type="text" id="opis_vrste" name="opis_vrste" size="20" maxlength="20" placeholder="opis vrste"><br></td>
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

<?php
if (isset($_POST['submit'])) {

    if (isset($_POST['naziv_vrste'])) {
        $naziv_vrste = $_POST['naziv_vrste'];
    }
    if (isset($_POST['opis_vrste'])) {
        $opis_vrste = $_POST['opis_vrste'];
    }


    $connect = new Baza();
    $connect->spojiDB();

    $query = "INSERT INTO `vrsta_lijeka` (`idvrsta_lijeka`, `naziv_vrste`, `opis_vrste`) "
            . "VALUES( '', '$naziv_vrste', '$opis_vrste')";

    $connect->updateDB($query);
    echo '<script language="javascript">';
    echo 'alert("Dodana je nova vrsta!")';
    echo '</script>';

    $connect->zatvoriDB();
}
?>