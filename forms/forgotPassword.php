<?php
require '../templates/baza.class.php';

if ($_POST['submit']) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = hash('sha256', $password);

    $connect = new Baza();
    $connect->spojiDB();

    $query = "SELECT * FROM korisnik "
            . "WHERE korisnicko_ime = '$username'";

    $result = $connect->selectDB($query);

    $row = mysqli_fetch_assoc($result); //vraca cijeli red dobivenog upita
    $db_username = $row['korisnicko_ime'];
    $db_password = $row['password'];

    if ($db_username == "") {
        echo '<script language="javascript">';
        echo 'alert("Ne postoji takav username!")';
        echo '</script>';
        $connect->zatvoriDB();
        exit();
    }

    if ($db_password == $password) {
        echo '<script language="javascript">';
        echo 'alert("Upisali ste stari password, molimo Vas ponovite unos")';
        echo '</script>';
        $connect->zatvoriDB();
        exit();
    }

    if ($db_username == $username) {
        $queryUpdatePassword = "UPDATE korisnik "
                . "SET password = '$password'"
                . "WHERE korisnicko_ime = '{$username}'";
        $queryUpdatePasswordHash = "UPDATE korisnik "
                . "SET 	password_hash = '$password_hash'"
                . "WHERE korisnicko_ime = '{$username}'";

        $connect->updateDB($queryUpdatePassword);
        $connect->updateDB($queryUpdatePasswordHash);
    }

    $message = "Korisnik usuername: " . $username . ". Vasa nova lozinka jest: " . $password . "."
            . "Kliknite na sljedecí link kako biste se prijavili"
            . "http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x103/forms/login.php";

    if (mail($email, "Vaša nova lozinka", $message, "From: DoNotReplay@gmail.com")) {
        echo '<script language="javascript">';
        echo 'alert("Poslana Vam je Vaša nova lozinka. Provjerite svoji mail!")';
        echo '</script>';

        include_once '../templates/aplicationLog.php';
        AddAplicationTask_User("Poslan zahtjev za novu lozinku", $username); //dnevnik
    }



    $connect->zatvoriDB();
}
?>

<!DOCTYPE html>
<html lang = "hr">
    <head>
        <title>Nova lozinka</title>
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
        <nav><ul>
                <li><a class="rectCaption" href="../index.php">LJEKARNA</a></li>
                <li><a class="nextPage" href="./login.php">PRIJAVA</a></li>
                <li><a class="nextPage" href="./registration.php">REGISTRACIJA</a></li>
                <li><a class="nextPage" href="./logOut.php">ODJAVA</a></li>
                <li><a class="nextPage" href="../AboutAuthor.html">O AUTORU</a></li>
            </ul><nav>
                </header>


                <div class = "center_div">
                    <div class = "center_forms">
                        <div class = "center_text_forms">
                            <form novalidate id="login_form" method="post" name="form1" action="forgotPassword.php">
                                <table cellspacing="20">
                                    <tr>
                                        <td><label for="username">Vaše korisničko ime: </label></td>
                                        <td><input type="text" id="username" name="username" size="20" maxlength="20" placeholder="korisnicko ime"><br></td>
                                    </tr>
                                    <tr>
                                        <td><label for="email">Vaš email: </label></td>
                                        <td><input type="text" id="email" name="email" size="30" maxlength="30" placeholder="email"><br></td>
                                    </tr>
                                    <tr>
                                        <td><label for="password">Nova lozinka: </label></td>
                                        <td><input type="password" id="password" name="password" size="20" maxlength="20" placeholder="lozinka" required="required"><br></td>
                                    </tr>
                                    <tr>
                                        <td><label for="password">Nova lozinka: </label></td>
                                        <td><input type="password" id="repat_password" name="repat_password" size="20" maxlength="20" placeholder="lozinka" required="required"><br></td>
                                    </tr>
                                    <tr>
                                        <td><input name="submit" type="submit" value=" Uredu "></td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <footer>
                    <p>Ime i prezime autora: Vedran Novak</p>
                    <address><strong>Kontakt:</strong> <a href="mailto:vednovak@foi.hr">vednovak@foi.hr</a></address>
                    <p>&copy; 2019 V.Novak</p>
                    <span style="float: right">Zadnje izmijenjeno: 24.03.2019.</span>
                </footer>
                </body>
                </html>