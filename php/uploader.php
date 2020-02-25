<?php

if (isset($_POST["submit"])) {

    if (isset($_POST['medication_name'])) {
        $medicatoinName = $_POST['medication_name'];
    }
    if (isset($_POST['discription'])) {
        $medicatoinDiscription = $_POST['discription'];
    }
    if (isset($_POST['amount'])) {
        $amount = $_POST['amount'];
    }
    if (isset($_POST['medicatoin_type'])) {
        $medicationTypeId = $_POST['medicatoin_type'];
    }
    if (isset($_POST['pharmacy'])) {
        $pharmacy = $_POST['pharmacy'];
    }

    $connect = new Baza();
    $connect->spojiDB();

//    $queryFindMedicationId = "SELECT idvrsta_lijeka, naziv_vrste "
//            . "FROM vrsta_lijeka "
//            . "WHERE naziv_vrste = 'Recept'";  
//    $result = $connect->selectDB($queryFindMedicationId);
//    $row = mysqli_fetch_assoc($result);
//    var_dump($row);
//    $db_medicationType = $row['idvrsta_lijeka'];
//    var_dump($db_medicationType);

    $userfile = $_FILES['userfile']['tmp_name'];
    $userfile_name = $_FILES['userfile']['name'];
    $userfile_size = $_FILES['userfile']['size'];
    $userfile_type = $_FILES['userfile']['type'];
    $userfile_error = $_FILES['userfile']['error'];
    if ($userfile_error > 0) {
        switch ($userfile_error) {
            case 1: echo 'Problem: Veličina veća od ' . ini_get('upload_max_filesize');
                break;
            case 2: echo 'Problem: Veličina veća od ' . $_POST["MAX_FILE_SIZE"] . 'B';
                break;
            case 3: echo 'Problem: Datoteka djelomično prenesena';
                break;
            case 4:
                $errorFileTransfer = 'Datoteka nije prenesena';
                break;
        }
        exit;
    }

    $allowed = array("image/jpeg", "image/png", "audio/mp3", "audio/mp4");

    if (preg_match('/[^A-Za-z0-9]+.*(?=\.)/', $userfile_name)) {
        echo "$userfile_name <br>";
        echo "Naziv datoteke ne sadrži samo slova i brojeve!";
        exit;
    } else {
        echo "$userfile_name <br>";
        echo "Naziv datoteke je uredu <br>";
    }

    if (!in_array($userfile_type, $allowed)) {
        echo 'Problem: datoteka nije slika (jpeg ili png formata) niti audio (mp3 ili mp4 formata)' . $userfile;
        exit;
    }

    if ($userfile_type == 'image/jpeg') {
        $upfile = 'multimedia/images/' . $userfile_name;
        if ($userfile_size > 250000) {
            echo 'Veličina datoteke(slike) je ' . $userfile_size . 'B, što je veće od dozvoljenih 250KB';
            exit;
        }
    } elseif ($userfile_type == 'image/png') {
        $upfile = 'multimedia/images/' . $userfile_name;
        if ($userfile_size > 250000) {
            echo 'Veličina datoteke(slike) je ' . $userfile_size . 'B, što je veće od dozvoljenih 250KB';
            exit;
        }
    } elseif ($userfile_type == 'audio/mp3') {
        $upfile = 'multimedia/audio/' . $userfile_name;
        if ($userfile_size > 500000) {
            echo 'Veličina datoteke(audio) je ' . $userfile_size . 'B, što je veće od dozvoljenih 500KB';
            exit;
        }
    } elseif ($userfile_type == 'audio/mp4') {
        $upfile = 'multimedia/video/' . $userfile_name;
        if ($userfile_size > 500000) {
            echo 'Veličina datoteke(video) je ' . $userfile_size . 'B, što je veće od dozvoljenih 500KB';
            exit;
        }
    }


    if (is_uploaded_file($userfile)) {
        if (!move_uploaded_file($userfile, $upfile)) {
            echo 'Problem: nije moguće prenijeti datoteku na odredište';
            exit;
        }
    } else {
        echo 'Problem: mogući napad prijenosom. Datoteka: ' . $userfile_name;
        exit;
    }
    $uploadedImageDir = $userfile_name;
    echo 'Datoteka uspješno prenesena<br /><br />';

//Azurirannje baze
    $query = "INSERT INTO `lijek` "
            . "VALUES (NULL, '$medicatoinName', '$medicatoinDiscription', '$uploadedImageDir','$amount', '$medicationTypeId')";

    $connect->updateDB($query);

    $queryFindIdMedication = "SELECT idlijek FROM lijek "
            . "WHERE naziv_lijeka = '$medicatoinName'";
    $result = $connect->selectDB($queryFindIdMedication);
    $row = mysqli_fetch_assoc($result);
    $db_idMedication = $row['idlijek'];

    $queryAddToPhamracy = "INSERT INTO lijek_u_lijekarni "
            . "VALUES ( '$db_idMedication', '$pharmacy')";
    $connect->updateDB($queryAddToPhamracy);
    
    $connect->zatvoriDB();
    AddAplicationLog("Dodan je novi lijek");
}
?>