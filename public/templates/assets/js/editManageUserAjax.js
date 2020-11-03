import { hideMessage, fadeMsg, hide, danger, success } from './commonFunctions.js';

document.addEventListener("DOMContentLoaded", ()=>{

    var firstname = "";
    var lastname = "";
    var email = "";
    var pass = "";

    var danger = "alert alert-danger";
    var success = "alert alert-success";
    var hide = "d-none";

    var modal = document.getElementById('editModal');
    var modalBtn = modal.getElementsByClassName("user-confirm-edit")[0];
    var modalClose = modal.getElementsByClassName("close")[0]

    modalBtn.addEventListener("click", ()=>{
        firstname = modal.getElementsByClassName("form-name")[0].value;
        lastname = modal.getElementsByClassName("form-lastname")[0].value;
        email = modal.getElementsByClassName("form-email")[0].value;
        pass = modal.getElementsByClassName("form-pass")[0].value;
        ajaxUpdating();
        modalClose.click();
    });

    var els = document.getElementsByClassName('user-manage-row');
    Array.prototype.forEach.call(els, e => {
        let id = e.dataset.id;
        e.getElementsByClassName('edit-button')[0].addEventListener("click", ()=> {
            modalBtn.dataset.id = id;
        });
    });


    function ajaxUpdating() {
        let msg = document.getElementById('manageMsg');
        let route = '/home/manage/edit/user';
        let id = modalBtn.dataset.id;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                let result = response['success'];
                if (result) {
                    updateUser(id, response);
                    msg.innerHTML = "User updated succesfully!"; 
                    msg.className = success;
                } else {
                    if (response['redirect']) {
                        window.location.href = response['redirect'];
                    }
                    msg.innerHTML = "Error, user couldn't be updated. Might be an invalid email."; 
                    msg.className = danger;
                }
                hideMessage(2000, msg);
            }
        };
        let myData = new Array('id='+id, 'firstname='+firstname, 'lastname='+lastname, 'email='+email, 'pass='+pass);
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