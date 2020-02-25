window.onload = function () {
    document.getElementById("new_username").addEventListener("onchange", function () {
        var username = document.getElementById("new_username").value;
        alert("poruka");
        if (username < 5) {
            document.getElementById("new_username").className = 'wrongInput';
            alert("poruka");
        }
    }, false);

    document.getElementById("new_username").addEventListener("onchange", function () {
        var username = document.getElementById("new_username");
        if (username > 24) {
            document.getElementById("new_username").className = 'wrongInput';
        }
    });
    
    document.getElementById("new_password").addEventListener("onchange", function () {
        var new_password = document.getElementById("new_password");
        if (new_password < 5) {
            document.getElementById("new_password").className = 'wrongInput';
        }
    });

    document.getElementById("new_password").addEventListener("onchange", function () {
        var new_password = document.getElementById("new_password");
        if (new_password > 13) {
            document.getElementById("new_password").className = 'wrongInput';
        }
    });

    document.getElementById("repeat_new_password").addEventListener("onchange", function () {
        var new_password = document.getElementById("new_password");
        var repeat_new_password = document.getElementById("repeat_new_password");
        if (repeat_new_password !== new_password) {
            //TODO: napisi da se ispisuje kvadratic crvene boje
        }
    });

    document.getElementById("email").addEventListener("onchange", function () {
        var email = document.getElementById("email");
        alert("poruka");
        var emailFilter = /^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/;
        if (!emailFilter.test(email)) {
            //TODO: napisi da se ispisuje kvadratic crvene boje ako ne vrijedi struktura emaila
        }
    });
};