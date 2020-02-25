<!DOCTYPE html>
<html lang="hr">

<head>
    <title>O autoru</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Vedran Novak">
    <meta name="keywords" content="Login, Data, Registration">
    <meta name="description" content="Page for user to login">
    <link href="./css_vednovak/footer.css" rel="stylesheet" type="text/css">
    <link href="css_vednovak/AboutAuthor.css" rel="stylesheet" type="text/css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
    $oAutoru = "AboutAuthor.html";
    $dokumentacija = "dokumentacija.php";

    include "navigacija/navigationBar.php"; ?>

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">O Autoru</li>
        </ol>
    </nav>
    <!-- <h1 id="prvaAnimacijaHeader">O autoru</h1> -->

    <div class="media">
        <img src="multimedia/vednovak_index_slika.jpg" class="rounded mr-3" alt="Slika osobe Vedrana Novaka">
        <div class="media-body">
            <h5 class="mt-0">O autoru</h5>
            <ul>
                <li><strong>Ime:</strong> Vedran</li>
                <li><strong>Prezime:</strong> Novak</li>
                <li><strong>Email:</strong> <a href="mailto:vednovak@foi.hr">vedrannovak1@gmail.com</a></address>
                </li>
                <li><strong>Broj indeksa:</strong> 43131/14-I</li>
            </ul>
            Currently pursuing Bachelors degree in Computer Science @ FOI, Varaždin.
            Worked on several major projects during my studies as Fullstack developer, for developing windows application 'E-learning' and web application 'E-pharmacy'.
            Experienced in C#, Java, PHP, JavaScript, JQuery, Ajax, phpMyAdmin, HTML, CSS, PostgreSQL MySQL, SQL Server, GIT.
            I am always eager to learn new technologies.
            Currently looking for the experience in the field.
        </div>
    </div>
    <br>
    <h4>Opis projektnog zadatka</h4>
    <p>U projektu se trebalo napraviti sustav E-ljekarne. Stranica preko koje se može naručivati, plačati i
            zahtjevati određene lijekove. U kojoj se nalaze 4 uloge
            korisnika same stranice, i one se dijele na administratora, koji ima apsolutnu ulogu, te on upravlja samim
            sustavom. Moderatore koji isplaćuju dnevne račune, pregledava
            i odobravaju zahtjeve lijekova koji nisu na receptima(njih odobrava administrator). Uloga registriranog
            korisnika koji ima pravo poslati zahtjev pojedinog
            lijeka, pregled računa, registrirati i logirati se, te pretraživati trgovinom. Te zadnje, uloga
            neregistriranog korisnika, koja je podosta limitirana
            sa time što može raditi na samoj stranici. Opčirnije u navigacijskom dijagramu.
        </p><br>
        <p>Susutav funckionira na način da postoje uloge. Ovisno o kojima, određena uloga ima pristup određenoj
            stranici. Svaki korisnik ima svoju ulogu. Korisnik se može
            registirirati u slučaju da nema već napravljen račun, te ulogirati. Naravno, i ne mora, ali u tom slučaju
            neće moći pristupiti određenim stranicama.
            Nakon registracija, korisniku se šalje mail, koji tek nakon što prihvati može se ulogirati u stranicu.
            Također, kod registracije, postoji Captcha preko koje se
            spriječavaju automati. Na prvi ulazak u samu stranicu, korinsnik mora prihvatiti uvjete korištenja, s kojim
            se radi kolačić s tajmerom od 2 dana. Na svaki novi ulazak korisnika
            u stanicu, taj kolačić se provjerava, te u slučaju da je istekao, korisniku će se ponovno pojaviti pitanje
            da ga prihvati.
            Rad sustava. Svako novo ažuriranje, ili neka promijena na stranici zapisuje se u dnevnik, kojem samo
            administrator može pristupiti. U projektnom rješenju koričteni
            su razni jezici, o kojima čemo malo više kasnije spomenuti. Svaka tablica na stranici, ima svojstva, poput
            sortiranja po kolonama, straničenje tablica koje imaju
            više od 7 elemenata, te pretraživanje samih tablica. Pristup odreženoj tablici ovisi o samoj ulozi
            korisnika. Sustav funckionira na način da administrator ima
            apsolutnu ulogu, te može sa svime upravljati, može izdavati ljekove, račune, recepte, vidjeti raznorazne
            statistike, znači ima cijeli pregled sustava. Također može
            kreirati, nove ljekove, ljekarne, korisnike, nove moderatore. Također može otključavati\zaključavati
            korisnički po želji. Moderator ima više ulogu kao trgovac,
            nema isti pristup kao i administrator, ali može kreirati nove ljekove, i izdavati dnevne račune. Takožer ima
            pregled svim zahtjevima, ali može odobravati samo one
            koji nisu preko recepta. Registrirani korisnik, može zahtjevati ljekove, kreirati nove zahtjeve i ima
            pregled na svim svojim računima. Takožer ih, ako želi
            može i platiti. Neregistrirani korisnik može samo pristupiti stranicama, dokumentacija, o autoru, početnoj,
            te može pristupiti popisu svih ljekarni sa ljekovima.</p>

    <!-- Footer -->
    <?php include "navigacija/footer.php"; ?>
</body>

</html>