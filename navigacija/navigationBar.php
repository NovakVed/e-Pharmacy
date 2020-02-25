<?php
require '../forms/changeHTTPtoHTTPS.php'; //promijeni http u https
require '../templates/baza.class.php';


if (isset($_POST['submit'])) {
    include_once '../templates/sesija.class.php';
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
        $db_username = $row['korisnicko_ime']; //u db_code postavljamo string iz celije(stupca confirmed_code)
        $db_password = $row['password'];
        $db_isActive = $row['is_active'];
        $db_type = $row['uloga_iduloga'];
        $db_failedLogins = $row['failed_logins'];
        if ($db_failedLogins >= 3) {
            AddAplicationTask_User("Korisniku zakljucan account zbog neuspiješne prijave", $username); //dnevnik
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
    header("Location: ../index.php");
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="<?php echo $main_page ?>">LJEKARNA</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo $popisLijekova ?>">Popis ljekova <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ostalo
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="<?php echo $dokumentacija ?>">Dokumentacija</a>
                    <a class="dropdown-item" href="<?php echo $oAutoru ?>">O autoru</a>
                    <a class="dropdown-item" href="<?php echo $popisKorisnika ?>">Popis korisnika</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
            <li>
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" id="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-light my-2 my-sm-0" type="submit">Search</button>
                </form>
            </li>
        </ul>

        <?php

        error_reporting(E_ALL ^ E_NOTICE); // IZBRISAO JE SVE NOTICE

        include_once '../templates/sesija.class.php';
        $userTypeSession = Sesija::dajKorisnika();
        $nameSession = $userTypeSession['korisnik']; //naziv registriranog korisnika

        $typeSession = $userTypeSession['tip'];

        $arrayList = array(1, 2, 3);
        if (in_array($typeSession, $arrayList)) {
            echo '<ul class="nav navbar-nav ml-auto">
            <li>
                <p class="navbar-text">Dobrodošli, </p>
            </li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"> ' . $nameSession . ' </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="#">Akcija</a>
                    
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../pkopija/forms/forgotPassword.php">Promijeni lozinku</a>
                    <a class="dropdown-item" href="../pkopija/forms/logOut.php">Odjavite se</a>
                </div>
            </li>
        </ul>';
        } else {
            echo '<!-- LOGIN -->
            <ul class="nav navbar-nav ml-auto">
                <li>
                    <p class="navbar-text">Already have an account?</p>
                </li>
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Login</a>
                    <div class="dropdown-menu dropdown-menu-right">
    
                        <!-- LOGIN FORM -->
                        <form class="px-4 py-3" novalidate method="post" name="form1" action="./navigacija/navigationBar.php">
                            <div class="form-group">
                                <label for="username">Korisničko ime</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Korisničko ime">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                        Zapamti me
                                    </label>
                                </div>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary">Prijavi se</button>
                        </form>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../pkopija/forms/registration.php">Novi ste ovdje? Registriraj se</a>
                        <a class="dropdown-item" href="../pkopija/forms/forgotPassword.php">Zaboravljena lozinka?</a>
                    </div>
                </li>
            </ul>';
        }
        ?>

    </div>
</nav>