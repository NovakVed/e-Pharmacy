<?php
include_once '../templates/sesija.class.php';
$current_time = date('Y-m-d H:i:s', time());

if (isset($_POST['new_username'])) {
    $new_username = $_POST['new_username'];
}
if (isset($_POST['name'])) {
    $name = $_POST['name'];
}
if (isset($_POST['surname'])) {
    $surname = $_POST['surname'];
}
if (isset($_POST['new_password'])) {
    $new_password = $_POST['new_password'];
}
if (isset($_POST['repeat_new_password'])) {
    $repeat_new_password = $_POST['repeat_new_password'];
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if ($_POST['submit']) {
    require '../templates/baza.class.php';

    $new_password;
    $password_hash = hash('sha256', $new_password);

    $connect = new Baza();
    $connect->spojiDB();

    $query = "SELECT * FROM korisnik "
            . "WHERE korisnicko_ime = '$new_username'";

    $result = $connect->selectDB($query);

    $row = mysqli_fetch_assoc($result); //vraca cijeli red dobivenog upita
    $db_username = $row['korisnicko_ime']; //u db_code postavljamo string iz celije(stupca confirmed_code)

    if ($db_username == $new_username) {
        echo '<script language="javascript">';
        echo 'alert("Već ste se registrirali, provjerite svoji mail!")';
        echo '</script>';
        $connect->zatvoriDB();
        exit;
    }

    $queryAdd = "INSERT INTO korisnik ( idkorisnik, ime, prezime, email, korisnicko_ime, password, password_hash, email_sent, email_sent_expires, confirmed_code, is_active, failed_logins, uloga_iduloga) "
            . "VALUES( '', '$name' , '$surname', '$email', '$new_username', '$new_password', '$password_hash', '$current_time', '0000-00-00 00:00:00', '0', '1', '0', '3')";

    $connect->updateDB($queryAdd);

    include_once '../templates/aplicationLog.php';
    AddAplicationLog("Korisnik: $new_username je aktiviran od strane administratora"); //dnevnik

    $connect->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Registriraj novog korisnika</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Vedran Novak">
        <meta name="keywords" content="Login, Data, Registration">
        <meta name="description" content="Page for user to login">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script type="text/javascript" src="../javascript/ajax.js"></script>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <link href="../css_vednovak/general.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/navigation.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/general_480.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/general_720.css" rel="stylesheet" type="text/css">
        <link href="../css_vednovak/general_850.css" rel="stylesheet" type="text/css">

    </head>
    <body> 
        <header>
            <nav>
                <ul>
                    <li><a class="rectCaption" href="../index.php">LJEKARNA</a></li>
                    <li><a class="nextPage" href="../request.php">ZAHTJEV</a></li>
                    <li><a class="nextPage" href="login.php">PRIJAVA</a></li>
                    <li><a class="currentPageHighlight" href="registration.php">>REGISTRACIJA</a></li>
                    <li><a class="nextPage" href="../privatno/korisnici.php">KORISNICI</a></li>
                    <li><a class="nextPage" href="../statistics/aplicationLogStatistics.php">DNEVNIK</a></li>
                    <li><a class="nextPage" href="logOut.php">ODJAVA</a></li>
                    <li><a class="nextPage" href="../AboutAuthor.html">O AUTORU</a></li>
                </ul>
            </nav>
        </header>

        <div class = "center_div_registration">
            <form class="registration_form" method="post" name="login_form" action="./registerNewModerator.php">
                <table cellspacing="20">
                    <tr>
                        <td><label for="new_username">Korisničko ime: </label></td>
                        <td><input type="text" id="new_username" name="new_username" size="20" maxlength="20" placeholder="korisničko ime" onkeyup="checkAvailable(this.value)"><br></td>
                        <td id="available"></td>
                    </tr>
                    <tr>
                        <td><label for="name">Ime: </label></td>
                        <td><input class="correctInput" type="text" id="name" name="name" size="20" maxlength="20" placeholder="ime"><br></td>
                        <td id="nameMessage"></td>
                    </tr>
                    <tr>
                        <td><label for="surname">Prezime: </label></td>
                        <td><input class="correctInput" type="text" id = "surname" name="surname" size="20" maxlength="20" placeholder="prezime"></td>
                        <td id="surnameMessage"></td>
                    </tr>
                    <tr>
                        <td><label for="new_password">Lozinka: </label></td>
                        <td><input class="correctInput" type="password" id="new_password" name="new_password" size="20" maxlength="20" placeholder="lozinka"><br></td>
                        <td id="new_passwordMessage"></td>
                    </tr>
                    <tr>
                        <td><label for="repeat_new_password">Ponovi lozinku: </label></td>
                        <td><input class="correctInput" type="password" id = "repeat_new_password" name="repeat_new_password" size="20" maxlength="20" placeholder="ponovi lozinku"></td>
                        <td id="repeat_new_passwordMessage"></td>
                    </tr>
                    <tr>
                        <td><label for="email">Email: </label></td>
                        <td><input class="correctInput" type="text" id="email" name="email" size="20" maxlength="30" placeholder="email"><br></td>
                        <td id="emailMessage"></td>
                    </tr>
                    <tr>
                        <td><input name="submit" type="submit" id="submit" value=" Registriraj se " ></td>
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

<?php
require './validationServerSide.php';
?>