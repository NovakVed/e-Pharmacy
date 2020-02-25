function changeDatabase(value) {

    console.log(value);
    var xml = new XMLHttpRequest();
    xml.open("POST", "tableAdministratorAcceptTasks.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");

    xml.send(value);
    loadTable();
//    location.reload();
}

function loadTable() {

//    console.log(value);
    var xml = new XMLHttpRequest();
    xml.open("POST", "./php/populateTableAdministratorAcceptTasks.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");
    xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("load").innerHTML = this.response;
        }
    };

    xml.send();

//    location.reload();
}

window.onload = function () {
    loadTable();
}