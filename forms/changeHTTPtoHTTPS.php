<?php

if (!isset($_SERVER["HTTPS"])) {
    $address = 'https://' . $_SERVER["SERVER_NAME"] .
            $_SERVER["REQUEST_URI"];
    header("Location: $address");
    exit();
}

?>