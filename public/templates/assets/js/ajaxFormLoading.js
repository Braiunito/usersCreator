document.addEventListener("DOMContentLoaded", ()=>{

    var loginPage = '/ajaxLogin';
    var registerPage = '/ajaxRegister';
    function ajaxPetition(route) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("access").innerHTML = this.responseText;
            }
        };
        xhttp.open("POST", route, false);
        xhttp.send();
    }

    function ajaxFirstOverload(route) {
        ajaxPetition(route);
        load();
    }
    
    function ajaxOverload(trigger, route) {
        document.getElementById(trigger).addEventListener('click', ()=>{
            ajaxPetition(route);
            load();
        });
    }

    function load() {
        ajaxOverload('register', registerPage);
        ajaxOverload('signin', loginPage);
    }
    ajaxFirstOverload(loginPage);
    load();
});