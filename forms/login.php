<?php
require './changeHTTPtoHTTPS.php'; //promijeni http u https
require '../templates/baza.class.php';
include_once '../templates/sesija.class.php';

if (isset($_POST['submit'])) {
    $username;
    $password;

    if (isset($_POST['username'])) {
        $username = $_POST['username'];
    }
    if (isset($_POST['password'])) {
        $password = $_POST['password'];
    }

    if ($username && $password) {
        $connect = new Baza();
        $connect->spojiDB();

        $query = "SELECT * FROM korisnik WHERE korisnicko_ime = '$username'";

        include_once '../templates/aplicationLog.php';

        $result = $connect->selectDB($query);
        $row = mysqli_fetch_assoc($result); //vraca cijeli red dobivenog upita
        $db_username = $row['korisnicko_ime']; //u db_code postavljamo string iz celije(stupca confirmed_code
        $db_password = $row['password'];
        $db_isActive = $row['is_active'];
        $db_type = $row['uloga_iduloga'];
        $db_failedLogins = $row['failed_logins'];
        if ($db_failedLogins >= 3) {
            AddAplicationTask_User("Korisniku zakljucan accountm neuspiješna prijava", $username); //dnevnik
            echo '<script>';
            echo 'alert("Molimo Vas kontaktirajte administratora da Vam otključa account!")';
            echo '</script>';
        } else {
            if ($db_isActive == 1) {
                if ($username == $db_username && $password == $db_password) {
                    setcookie("username", $username);
                    Sesija::kreirajKorisnika($username, $db_type);

                    $queryFailedLoginSetToZero = "UPDATE korisnik "
                            . "SET failed_logins = '0'"
                            . "WHERE korisnicko_ime = '{$db_username}'";
                    $connect->updateDB($queryFailedLoginSetToZero);
                    AddAplicationLog("Korisnik se uspiješno prijavio"); //dnevnik
                } else {
                    $count = 1 + $db_failedLogins;
                    $queryFailedLogin = "UPDATE korisnik "
                            . "SET failed_logins = '{$count}'"
                            . "WHERE korisnicko_ime = '{$db_username}'";

                    $connect->updateDB($queryFailedLogin);

                    AddAplicationTask_User("Korisnik krivo upisao sifru, neuspiješna prijava", $username); //dnevnik

                    echo '<script>';
                    echo 'alert("Upisali ste krivi username ili password!")';
                    echo '</script>';
                }
            } else {
                include_once '../templates/aplicationLog.php';
                AddAplicationTask_User("Korisniku nije aktiviran account, neuspiješna prijava", $username); //dnevnik
                echo '<script>';
                echo 'alert("Niste aktivirali account!")';
                echo '</script>';
            }
        }
    }
    $connect->zatvoriDB();
}
?>
<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Prijava</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vedran Novak">
        <meta name="keywords" content="Login, Data, Registration">
        <meta name="description" content="Page for user to login">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../css_vednovak/general.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/navigation.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/general_480.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/general_720.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/general_850.css" rel="stylesheet" type="text/css">

        <script type="text/javascript" src="../javascript/showCookieValue.js"></script>
    </head>
    <body> 
        <header>
            <nav>
                <ul>
                    <li><a class="rectCaption" href="../index.php">LJEKARNA</a></li>
                    <li><a class="nextPage" href="../medication.php">LJEKOVI</a></li>
                    <li><a class="nextPage" href="../request.php">ZAHTJEV</a></li>
                    <li><a class="nextPage" href="../bills.php">RAČUNI</a></li>
                    <li><a class="nextPage" href="../usersAllRequests.php">POPIS ZAHTJEVA KORISNIKA</a></li>
                    <li><a class="nextPage" href="../creatingMedication.php">KREIRAJ LIJEK</a></li>
                    <li><a class="nextPage" href="../acceptingRequests.php">PREGLED ZAHTJEVA MODERATOR</a></li>
                    <li><a class="nextPage" href="../issueBill.php">IZDAJ RAČUN</a></li>
                    <li><a class="nextPage" href="../creatingPharmacy.php">KREIRANJE LJEKARNI</a></li>
                    <li><a class="nextPage" href="../creatingMedicationType.php">KREIRANJE TIPA LIJEKA</a></li>
                    <li><a class="nextPage" href="../administratorAcceptTasks.php">ADMINISTRATOR ODOBRAVA ZAHTJEVE</a></li>
                    <li><a class="nextPage" href="../userControlAdministrator.php">UPRAVLJANJE KORISNICIMA</a></li>
                    <li><a class="nextPage" href="../setTime.php">PROMIJENI VREMENSKI POMAK</a></li>
                    <li><a class="nextPage" href="../virtualTimeChange.php">POSTAVI VREMENSKI POMAK</a></li>
                    <li><a class="currentPageHighlight" href="./login.php">>PRIJAVA</a></li>
                    <li><a class="nextPage" href="../forms/registration.php">REGISTRACIJA</a></li>
                    <li><a class="nextPage" href="../privatno/korisnici.php">KORISNICI</a></li>
                    <li><a class="nextPage" href="../statistics/aplicationLogStatistics.php">DNEVNIK</a></li>
                    <li><a class="nextPage" href="../forms/logOut.php">ODJAVA</a></li>
                    <li><a class="nextPage" href="../AboutAuthor.html">O AUTORU</a></li>
                </ul>
            </nav>
        </header>


        <div class = "center_div">
            <form class="formLogin" novalidate method="post" name="form1" action="./login.php">
                <table cellspacing="20">
                    <!--<caption style ="font-size: 15px; font-style: italic">Prijava</caption>-->
                    <tr>
                        <td><label for="username">Korisničko ime: </label></td>
                        <td><input type="text" id="username" name="username" size="20" maxlength="20" placeholder="korisničko ime"><br></td>
                    </tr>
                    <tr>
                        <td><label for="password">Lozinka: </label></td>
                        <td><input type="password" id="password" name="password" size="20" maxlength="20" placeholder="lozinka" required="required"><br></td>
                    </tr>
                    <tr>
                        <td><label for="zapamtikorisnika">Zapamti korisnika: </label></td>
                        <td><input type="checkbox" id = "zapamtikorisnika" checked="checked" name="zapamtikorisnika" value="1"></td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" value=" Prijavi se "></td>
                        <td><a href ="forgotPassword.php">Zaboravili ste lozinku?</a></td>
                    </tr>
                    <span id="available"></span>
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
