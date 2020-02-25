<?php

if (isset($_POST["submit"])) {
    $new_username = null;
    $name;
    $surname;
    $new_password;
    $repeat_new_password;
    $email;
    $remember_user;
    $captcha = "";

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
    if (isset($_POST['remember_user'])) {
        $remember_user = $_POST['remember_user'];
    }
    if (isset($_POST['g-recaptcha-response'])) {
        $captcha = $_POST['g-recaptcha-response'];
    }
    if (!$captcha) {
        echo '<script language="javascript">';
        echo 'alert("Please check the the captcha form.!")';
        echo '</script>';
        exit;
    }
    $secretKey = "6LdC26cUAAAAAOAeEBi0yeqMYJMnBiw1pbn3WYTx";
    $ip = $_SERVER['REMOTE_ADDR'];
// post request to server
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
    $response = file_get_contents($url);
    $responseKeys = json_decode($response, true);
// should return JSON with success as true
    if ($responseKeys["success"] == true) {
        echo '<script language="javascript">';
        echo 'alert("Registrirali ste se!")';
        echo '</script>';
    }
//    elseif($responseKeys["success"] == false) {
//        echo '<h2>You are spammer ! Get the @$%K out</h2>';
//    }
}
?>