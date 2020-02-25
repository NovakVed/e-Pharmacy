<!DOCTYPE html>
<html lang="hr">

<head>
    <title>Popis lijekova</title>
    <meta charset="UTF-8">
    <meta name="author" content="Vedran Novak">
    <meta name="keywords" content="tablica, retci, grid">
    <meta name="description" content="Stranica sa tablicom">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="./css_vednovak/footer.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    

</head>

<body>
    <!-- Navigacija -->
    <?php

    $main_page = "index.php";
    $popisLijekova = "medication.php";
    $login = "";
    $register = "";
    $racuni = "";
    $popisZahtjeva = "";
    $kreirajLjek = "";
    $pregledZahtjeva = "";
    $moderator = "";
    $izdajRacun = "";
    $kreirajLjek = "";
    $kreirajTipLjeka = "";
    $administratorOdobravaLjek = "";
    $upravljanjeKorisnicima = "";
    $promijeniVremenskiPomak = "";
    $postaviVremenskiPomak = "";
    $popisKorisnika = "privatno/korisnici.php";
    $dnevnik = "";
    $odjava = "";
    $oAutoru = "AboutAuthor.php";
    $dokumentacija = "dokumentacija.php";

    include "navigacija/navigationBar.php"; ?>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Popis lijekova</li>
        </ol>
    </nav>

    <!-- Search pronađi lijek   VAŽNO!!! TRENUTNO SE MOŽE SEARCHATI I NA NAVIGACIJI (izbrisi name i id u navigationBar kako bi to maknuo) -->
    <p>Pronađi lijek</p>
    <input type="text" id="filter" class="form-control" name="search" placeholder="Search for medication" title="Pronađi lijek">
    <br>

    <?php
    //require 'templates/baza.class.php';

    $connect = new Baza();
    $connect->spojiDB();

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    $pageLenght = 15;

    $connect = new Baza();
    $connect->spojiDB();

    $query = "SELECT l.idlijek, l.naziv_lijeka, direktorij_slike, u.idljekarna, u.naziv_ljekarne "
        . "FROM lijek AS l, ljekarna AS u, lijek_u_lijekarni p "
        . "WHERE l.idlijek = p.lijek_idlijek "
        . "AND u.idljekarna = p.ljekarna_idljekarna "
        . "ORDER BY l.naziv_lijeka ASC";

    $result = $connect->selectDB($query);
    $elements = mysqli_num_rows($result);


    $num_of_pages = ceil($elements / $pageLenght);
    $this_page_first_result = ($page - 1) * $pageLenght;

    // for ($page = 1; $page <= $num_of_pages; $page++) {
    //     echo '<a href="medication.php?page=' . $page . '"> ' . $page . '  </a>';
    // }
    // 
    ?>

    <div id="kako">
        <?php
        //TABLICA DNEVNIK
        require 'php/populateTableMedicationsPharmacy.php';
        ?>
    </div>
    </div>

    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
        <div class="btn-group mr-2" role="group" aria-label="First group">
            <?php

            for ($page = 1; $page <= $num_of_pages; $page++) {
                echo '<a href="medication.php?page=' . $page . '"><button type="button" class="btn btn-primary"> ' . $page . '  </button></a>';
            }

            ?>
        </div>
    </div>
    <br>
    <!-- Footer -->
    <?php
    //echo "</div>";
    include "./navigacija/footer.php"; ?>
    <script type="text/javascript" src="./javascript/tableSearchMedication.js"></script>
</body>

</html>