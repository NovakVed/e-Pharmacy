<?php
require './templates/baza.class.php';
require './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$userTypeSession = Sesija::dajKorisnika();
$typeSession = $userTypeSession['tip'];

$arrayList = array(1, 2);
if(!in_array($typeSession, $arrayList)){
    header("Location: ./forms/login.php");
}

?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Kreiraj lijek</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vedran Novak">
        <meta name="keywords" content="tablica, retci, grid">
        <meta name="description" content="Stranica sa tablicom">
        <link href="css_vednovak/general.css" rel="stylesheet" type="text/css">
        <!--<link href="css_vednovak/table.css" rel="stylesheet" type="text/css">-->
        <link href="css_vednovak/navigation.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_480.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_720.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_850.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/print.css" rel="stylesheet" type="text/css"> 

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!--        <script type="text/javascript" src="javascript/tableSearch.js"></script>
        <script type="text/javascript" src="javascript/printPage.js"></script>-->

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
                    <li><a class="currentPageHighlight" href="creatingMedication.php">>KREIRAJ LIJEK</a></li>
                    <li><a class="nextPage" href="acceptingRequests.php">PREGLED ZAHTJEVA MODERATOR</a></li>
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

        <div class = "center_div_registration">
            <form class="registration_form" enctype="multipart/form-data" method="post" name="creating_medication" action="./creatingMedication.php">
                <table cellspacing="20">
                    <tr>
                        <td><label for="medication_name">Naziv lijeka: </label></td>
                        <td><input type="text" id="medication_name" name="medication_name" size="20" maxlength="20" placeholder="naziv lijeka"><br></td>
                        <td id="available"></td>
                    </tr>
                    <tr>
                        <td><label for="discription">Opis lijeka: </label></td>
                        <td><input class="correctInput" type="text" id="discription" name="discription" size="20" maxlength="200" placeholder="opis"><br></td>
                    </tr>
                    <tr>
                        <td><label for="amount">Cijena: </label></td>
                        <td><input class="correctInput" type="text" id="amount" name="amount" size="20" maxlength="200" placeholder="cijena"><br></td>
                    </tr>
                    <tr>
                        <td><label for="medicatoin_type">Odaberite vrstu lijeka: </label></td>
                        <?php
                        require './php/populateSelectElementCreatingMedication.php';
                        ?>
                    </tr>
                    <tr>
                        <td><label for="pharmacy">Odaberite ljekarnu: </label></td>
                        <?php
                        require './php/populateSelectElementPharmacy.php';
                        ?>
                    </tr>
                    <!--TODO: Rijesi upload datoteke-->
                    <tr>
                        <td><input type="hidden" name="MAX_FILE_SIZE" value="1000000" /></td>
                        <td>Preuzmi datoteku: <input name="userfile" type="file" /><br></td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" id="submit" value=" Kreiraj " ></td>
                        <td><input name="reset" type="reset" value=" Ponovi "></td>
                    </tr>
                </table>
            </form>
        </div>
        <footer>
            <p>Ime i prezime autora: <a class="nextPageFooter" href="../AboutAuthor.html">Vedran Novak</a></p>
            <address><strong>Kontakt:</strong> <a href="mailto:vednovak@foi.hr">vednovak@foi.hr</a></address>
            <p>&copy; 2019 V.Novak <span class="spanFooter">Zadnje izmijenjeno: 24.03.2019.</span></p>
        </footer>
    </body>
</html>

<!--TODO: pogledaj uploader-->

<?php
require './php/uploader.php';
?>