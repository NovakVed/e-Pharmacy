function changeDatabase(value) {
    
    console.log(value);
    var xml = new XMLHttpRequest();
    xml.open("POST", "tableChangeUserIsActive.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");
    xml.send(value);
    
    location.reload();
}

function changeDatabaseModerator(value) {
    
    console.log(value);
    var xml = new XMLHttpRequest();
    xml.open("POST", "tableChangeUserType.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");
    xml.send(value);
    
    location.reload();
}