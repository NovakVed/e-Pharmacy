function checkAvailable(value) {
    var xml;
    if (value.lenght === 0) {
        document.getElementById("available").innerHTML = "";
        return;
    } else {
        xml = new XMLHttpRequest();
        xml.open("POST", "checkUsername.php?new_username=" + value, true);
        xml.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
//                console.log("xml.responseText = " + xml.responseText);
                document.getElementById("available").innerHTML = xml.responseText;
            }
        };
        xml.send();
    }
}