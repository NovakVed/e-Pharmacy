<?php
require './templates/baza.class.php';
require './templates/aplicationLog.php';
include_once './templates/sesija.class.php';

$userTypeSession = Sesija::dajKorisnika();
$typeSession = $userTypeSession['tip'];

$arrayList = array(1, 2, 3);
if(!in_array($typeSession, $arrayList)){
    header("Location: ./forms/login.php");
}

$connect = new Baza();
$connect->spojiDB();

$myfile = fopen("time.txt", "r") or die("Nije moguće otvoriti datoteku!");
$hours = fread($myfile,filesize("time.txt"));
$current_time = date('Y-m-d H:i:s', time() + $hours * 60 * 60);

if (isset($_POST["submit"])) {
    $nameRequest;
    $descriptionRequest;
    $amount;
    $medicationId;

    $user = Sesija::dajKorisnika();
    $userValue = $user['korisnik'];

//    TRAZIMO KORISNIKOV ID
    $queryUserId = "SELECT idkorisnik FROM korisnik WHERE korisnicko_ime = '$userValue'";
    $resultSelectUserId = $connect->selectDB($queryUserId);
    if (mysqli_num_rows($resultSelectUserId) > 0) {
        $rowSelectUserId = mysqli_fetch_assoc($resultSelectUserId);
        $db_idkorisnika = $rowSelectUserId['idkorisnik']; //korisnikov ID
    }

//    UBACUJE VRIJEDNOSTI IZ FORME U VARIJABLE
    if (isset($_POST['nameRequest'])) {
        $nameRequest = $_POST['nameRequest']; //ime
    }
    if (isset($_POST['descriptionRequest'])) {
        $descriptionRequest = $_POST['descriptionRequest']; //opis
    }
    if (isset($_POST['amount'])) {
        $amount = $_POST['amount']; //kolicina
    }
    if (isset($_POST['medicationId'])) {
        $medicationId = $_POST['medicationId']; //lijek
    }
    if ($nameRequest == "" || $descriptionRequest == "" || $amount == "" || $amount <= 0) {
        echo '<script language="javascript">';
        echo 'alert("Provjerite upisane podatke!")';
        echo '</script>';
        exit();
    }

//    UPIS U TABLICU "zahtjev"   
    $queryAddRequest = "INSERT INTO zahtjev(idzahtjev, naziv_zahtjeva, opis_zahtjeva, datum, kolicina) "
            . "VALUES('', '$nameRequest', '$descriptionRequest', '$current_time', '$amount')";

    $connect->updateDB($queryAddRequest);
    AddAplicationLog("Poslan je zahtjev za lijek");

//    TRAZIMO ID ZAHTJEVA
    $querySelect = "SELECT idzahtjev FROM zahtjev WHERE naziv_zahtjeva = '$nameRequest' AND opis_zahtjeva = '$descriptionRequest'";
    $resultSelect = $connect->selectDB($querySelect);
    $rowSelect = mysqli_fetch_assoc($resultSelect);
    $db_idRequest = $rowSelect['idzahtjev'];

//    TRAZIMO DALI JE LIJEK NA RECEPT
    $queryMedicationOnPrescription = "SELECT v.naziv_vrste "
            . "FROM vrsta_lijeka AS v, lijek AS l "
            . "WHERE v.idvrsta_lijeka = l.vrsta_lijeka_idvrsta_lijeka "
            . "AND l.idlijek = '$medicationId'";
    $result = $connect->selectDB($queryMedicationOnPrescription);
    $row = mysqli_fetch_assoc($result);
    $db_perscription = $row['naziv_vrste'];

    if ($db_perscription == "Recept") {
        $queryAddStatus = "INSERT INTO stavka_zahtjev(zahtjev_idzahtjev, status_zahtjeva_idstatus_zahtjeva)"
                . "VALUES('$db_idRequest', '4')";
        $connect->updateDB($queryAddStatus);
        //TODO: POSLATI MAIL ADMINISTRATORU DA ODOBRI LIJEK
        $message = "New request for a medicine on a prescription
		Click the link below to see the new request
		http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x103/administratorAcceptTasks.php";

    if (mail("vedrannovak1@gmail.com", "Accept new request", $message, "From: DoNotReplay@gmail.com")) {
        echo "<br>Registration Complete! Please wait untill someone accepts ur request";
    }
    
    } else {
        //    UPIS U TABLICU "stavka_zahtjev"
        $queryAddStatus = "INSERT INTO stavka_zahtjev(zahtjev_idzahtjev, status_zahtjeva_idstatus_zahtjeva)"
                . "VALUES('$db_idRequest', '9')";
        $connect->updateDB($queryAddStatus);
    }

//    UPIS U TABLICU "narucivanje_lijeka"
    $queryAddRequest_Medicatoin_User = "INSERT INTO narucivanje_lijeka(korisnik_idkorisnik, lijek_idlijek, zahtjev_idzahtjev)"
            . "VALUES('$db_idkorisnika','$medicationId','$db_idRequest')";
    $connect->updateDB($queryAddRequest_Medicatoin_User);
    
    
}
$connect->zatvoriDB();
?>


<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Kreiraj zahtjev</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vedran Novak">
        <meta name="keywords" content="task, registered, user">
        <meta name="description" content="Stranica sa tablicom">
        <link href="css_vednovak/general.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/navigation.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_480.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_720.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/general_850.css" rel="stylesheet" type="text/css">
        <link href="css_vednovak/print.css" rel="stylesheet" type="text/css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<!--        <script type="text/javascript" src="../javascript/tableSearch.js"></script>
        <script type="text/javascript" src="../javascript/printPage.js"></script>-->

    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a class="rectCaption" href="index.php">LJEKARNA</a></li>
                    <li><a class="nextPage" href="medication.php">LJEKOVI</a></li>
                    <li><a class="currentPageHighlight" href="request.php">>ZAHTJEV</a></li>
                    <li><a class="nextPage" href="bills.php">RAČUNI</a></li>
                    <li><a class="nextPage" href="usersAllRequests.php">POPIS ZAHTJEVA KORISNIKA</a></li>
                    <li><a class="nextPage" href="creatingMedication.php">KREIRAJ LIJEK</a></li>
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
            <form class="registration_form" method="post" name="login_form" action="./request.php">
                <table cellspacing="20">
                    <tr>
                        <td><label for="nameRequest">Naziv zahtjeva: </label></td>
                        <td><input type="text" id="nameRequest" name="nameRequest" size="20" maxlength="20" placeholder="naziv zahtjeva"><br></td>
                    </tr>
                    <tr>
                        <td><label for="descriptionRequest">Opis zahtjeva: </label></td>
                        <td><input type="text" id="descriptionRequest" name="descriptionRequest" size="20" maxlength="20" placeholder="opis zahtjeva"></td>
                    </tr>
                    <tr>
                        <td><label for="amount">Količina: </label></td>
                        <td><input type="text" id="amount" name="amount" size="20" maxlength="20" placeholder="količina"><br></td>
                    </tr>
                    <!--Ovdje se odabire lijek preko combo boxa-->
                    <tr>
                        <td><label for="medication">Odaberi lijek:  </label></td>
                        <?php
                        require './php/populateSelectElement.php';
                        ?>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" id="submit" value=" Pošalji zahtjev " ></td>
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

