/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function changeDatabase(value) {
//    console.log(value);
    var xml = new XMLHttpRequest();
    xml.open("POST", "tableChangeAcceptingRequest.php", true);
    xml.setRequestHeader("Content-Type", "aplication/json");
    xml.send(value);
    
    location.reload();
}