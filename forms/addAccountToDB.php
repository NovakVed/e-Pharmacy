<?php
error_reporting(E_ALL ^ E_NOTICE);
$new_username;
$name;
$surname;
$new_password;
$password_hash = hash('sha256', $new_password);
$email;

$myfile = fopen("../time.txt", "r") or die("Nije moguće otvoriti datoteku!");
$hours = fread($myfile,filesize("../time.txt"));

$current_time = date('Y-m-d H:i:s', time() + $hours * 60 * 60);
$email_sent_expires = date('Y-m-d H:i:s', time() + $hours * 60 * 60 + 24 * 60 * 60);
$uloga_iduloga = 3;
$confirmCode = rand();

if ($_POST['submit']) {
    require '../templates/baza.class.php';

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


    $queryAdd = "INSERT INTO korisnik(idkorisnik, ime, prezime, email, korisnicko_ime, password, password_hash, email_sent, email_sent_expires, confirmed_code, is_active, failed_logins, uloga_iduloga) "
            . "VALUES('', '$name' , '$surname','$email', '$new_username', '$new_password', '$password_hash', '$current_time', '$email_sent_expires', '$confirmCode', '0', '0','$uloga_iduloga')";

    $connect->updateDB($queryAdd);

    $message = "Confirm Your Email
		Click the link below to verify your account
		http://barka.foi.hr/WebDiP/2018_projekti/WebDiP2018x103/forms/confirmMail.php?username=$new_username&code=$confirmCode";

    if (mail($email, "Confirm email adress", $message, "From: DoNotReplay@gmail.com")) {
        echo "<br>Registration Complete! Please confirm your email address";
    }

    
    include_once '../templates/aplicationLog.php';
    AddAplicationTask_User("Korisniku poslan aktivacijski email", $new_username); //dnevnik
    
    $connect->zatvoriDB();
}
?>
