<?php

//require '../templates/baza.class.php';

if (isset($_GET['order'])) {
    $order = $_GET['order'];
} else {
    $order = 'idkorisnik';
}

if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'ASC';
}
if(isset($_GET['page'])){
    $page = $_GET['page'];
} else{
    $page = 1; 
}

$pageLenght = 10;

$connect = new Baza();
$connect->spojiDB();

$query = "SELECT k.idkorisnik, k.korisnicko_ime, k.email, k.is_active, k.password, u.iduloga ,u.naziv_uloge "
        . "FROM korisnik AS k, uloga AS u "
        . "WHERE k.uloga_iduloga = u.iduloga ";       

$result = $connect->selectDB($query);
$elements = mysqli_num_rows($result);


$num_of_pages = ceil($elements/$pageLenght);
$this_page_first_result = ($page-1)*$pageLenght;

$query = "SELECT * FROM dnevnik "
        . "ORDER BY $order $sort "
        . "LIMIT $this_page_first_result, $pageLenght";
        

for($page = 1; $page<=$num_of_pages; $page++){
    echo '<a href="userControlAdministrator.php?page=' . $page .  '"> ' . $page . '  </a>';
}

$query = "SELECT k.idkorisnik, k.korisnicko_ime, k.email, k.is_active, k.password, u.iduloga ,u.naziv_uloge "
        . "FROM korisnik AS k, uloga AS u "
        . "WHERE k.uloga_iduloga = u.iduloga "
        . "ORDER BY $order $sort "
        . "LIMIT $this_page_first_result, $pageLenght";

$result = $connect->selectDB($query);

if (mysqli_num_rows($result) > 0) {
    if ($sort == 'DESC') {
        $sort = 'ASC';
    } else {
        $sort = 'DESC';
    }
    echo "<table class = 'tableScrollUser'>
            <caption>Lista korisnika</caption>
        <tr>
                <th><a href='userControlAdministrator.php?order=idkorisnik&&sort=$sort&&'>IDkorisnika</a></th>
                <th><a href='userControlAdministrator.php?order=email&&sort=$sort'>Email</a></th>
                <th><a href='userControlAdministrator.php?order=korisnicko_ime&&sort=$sort'>Korisnicko ime</a></th>
                <th><a href='userControlAdministrator.php?order=password&&sort=$sort'>Password</a></th>
                <th><a href='userControlAdministrator.php?order=naziv_uloge&&sort=$sort'>Uloga korisnika</a></th>
                <th>Promijeni ulogu</th>
                <th><a>Aktivan</a></th>
                <th></th>
            </tr>"
    . "<tbody id='myTable'>";

    while ($row = mysqli_fetch_assoc($result)) {
        $db_user = $row['idkorisnik'];
        $db_active = $row['is_active'];
        $db_type = $row['iduloga'];
        if ($db_user > 1) {
            if ($db_active == 1) {
                $active = "Aktiviran";
            } else {
                $active = "Blokiran";
            }

            $myObjectModerator = new \stdClass();
            $myObjectUnlock = new \stdClass();
            $myObjectBlock = new \stdClass();
            
            $myObjectModerator->idKorisnik = "$db_user";
            $myObjectModerator->idUloga = 2;
            $JSONModerator = json_encode($myObjectModerator);


            $myObjectModerator->idKorisnik = "$db_user";
            $myObjectModerator->idUloga = 3;
            $JSONRegisteredUser = json_encode($myObjectModerator);

            $myObjectUnlock->idKorisnik = "$db_user";
            $myObjectUnlock->is_active = 1;
            $JSONUnlock = json_encode($myObjectUnlock);

            $myObjectBlock->idKorisnik = "$db_user";
            $myObjectBlock->is_active = 0;
            $JSONBlock = json_encode($myObjectBlock);


            echo "<tr>"
            . "<td>" . $row['idkorisnik'] . "</td>"
            . "<td>" . $row['korisnicko_ime'] . "</td>"
            . "<td>" . $row['email'] . "</td>"
            . "<td>" . $row['password'] . "</td>"
            . "<td>" . $row['naziv_uloge'] . "</td>"
            . "<td><select name='select' onchange = 'changeDatabaseModerator(this.value)'>"
            . "<option value = ''>Odaberi</option>"
            . "<option value = '$JSONModerator'>Moderator</option>"
            . "<option value = '$JSONRegisteredUser'>Registrirani korisnik</option>"
            . "</select></td>"
            . "<td>" . $active . "</td>"
            . "<td><select name='selectArgument[]' onchange = 'changeDatabase(this.value)'>"
            . "<option value = ''>Odaberi</option>"
            . "<option value = '$JSONUnlock'>Otključati</option>"
            . "<option value = '$JSONBlock'>Blokirati</option>"
            . "</select></td>"
            . "</tr>";
        }
    }
    echo "</tbody></table>";
} else {
    echo "0 result";
}

$connect->zatvoriDB();
?>