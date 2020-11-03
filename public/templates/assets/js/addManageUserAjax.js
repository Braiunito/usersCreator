import { hideMessage, fadeMsg, hide, danger, success } from './commonFunctions.js';

document.addEventListener("DOMContentLoaded", ()=>{
        var firstname = "";
        var lastname = "";
        var email = "";
        var pass = "";

        var danger = "alert alert-danger";
        var success = "alert alert-success";
        var hide = "d-none";

        var modal = document.getElementById('addModal');
        var modalBtn = modal.getElementsByClassName("user-confirm-add")[0];
        var modalClose = modal.getElementsByClassName("close")[0]

        modalBtn.addEventListener("click", ()=>{
            firstname = modal.getElementsByClassName("form-name")[0].value;
            lastname = modal.getElementsByClassName("form-lastname")[0].value;
            email = modal.getElementsByClassName("form-email")[0].value;
            pass = modal.getElementsByClassName("form-pass")[0].value;
            ajaxUpdating();
            modalClose.click();
        });


        function ajaxUpdating() {
            let msg = document.getElementById('manageMsg');
            let route = '/register';

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    let response = JSON.parse(this.responseText);
                    let result = response['success'];
                    if (result) {
                        //updateUser(id, response);
                        msg.innerHTML = "User added succesfully!"; 
                        msg.className = success;
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    } else {
                        if (response['redirect']) {
                            window.location.href = response['redirect'];
                        }
                        msg.innerHTML = response["msg"]; 
                        msg.className = danger;
                    }
                    hideMessage(2000, msg);
                }
            };
            let myData = new Array('firstname='+firstname, 'lastname='+lastname, 'email='+email, 'pass='+pass, 'bymodal='+true);
            let url = myData.join('&');
            xhttp.open('POST', route, false);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send(url);
        }

        function updateUser(id, response) {
            let user = document.getElementById("user-"+id);

            user.getElementsByClassName("firstname")[0].innerHTML = response['user']['firstname'];
            user.getElementsByClassName("lastname")[0].innerHTML = response['user']['lastname'];
            user.getElementsByClassName("email")[0].innerHTML = response['user']['email'];

            modal.getElementsByClassName("form-name")[0].value = "";
            modal.getElementsByClassName("form-lastname")[0].value = "";
            modal.getElementsByClassName("form-email")[0].value = "";
            modal.getElementsByClassName("form-pass")[0].value = "";
        }
});