<?php
if (strlen($new_username) < 5) {
    echo "<br>Premali broj znakova";
    exit();
}

if (strlen($new_password) > 13) {
    echo "<br>Preveliki broj znakova";
    exit();
}

if (strlen($new_password) < 5) {
    echo "<br>Preslaba lozinka (pre mali broj znakova)";
    exit();
}

if($new_password !== $repeat_new_password){
    echo "<br> Lozinke se ne podudaraju";
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "$email <br>";
    echo "Uneseni email nije dobar!";
    exit();
}
?>