/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function selectUser(value) {

    var xml = new XMLHttpRequest();

    xml.open("POST", "populateTableIssueBills.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");
//    console.log(value);
    xml.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
                console.log("xml.responseText = " + xml.responseText);
            document.getElementById("table").innerHTML = xml.responseText;
        }
    };
    xml.send(value);

//    location.reload();
}

function issueBill(value){
    var xml = new XMLHttpRequest();
//    console.log(value);
    xml.open("POST", "issueTheBillToUser.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");
    
    
    xml.send(value);
    location.reload();
}