import { hideMessage, fadeMsg, hide, danger, success } from './commonFunctions.js';

document.addEventListener("DOMContentLoaded", ()=>{

    var modal = document.getElementById('deleteModal');
    var modalBtn = modal.getElementsByClassName("user-confirm-delete")[0];
    var modalClose = modal.getElementsByClassName("close")[0]

    modalBtn.addEventListener("click", ()=>{
        ajaxDeletition();
        modalClose.click();
    });

    var els = document.getElementsByClassName('user-manage-row');
    Array.prototype.forEach.call(els, e => {
        let id = e.dataset.id;
        e.getElementsByClassName('delete-button')[0].addEventListener("click", ()=> {
            modalBtn.dataset.id = id;
        });
    });


    function ajaxDeletition() {
        let msg = document.getElementById('manageMsg');
        let route = '/home/manage/delete/user';
        let id = modalBtn.dataset.id;

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let response = JSON.parse(this.responseText);
                let result = response['success'];
                if (result) {
                    document.getElementById('user-'+id).remove();    
                    msg.innerHTML = (!response['msg']) ? "User deleted succesfully!" : response['msg']; 
                    msg.className = success;
                } else {
                    if (response['redirect']) {
                        window.location.href = response['redirect'];
                    }
                    msg.innerHTML = (!response['msg']) ? "Error, user couldn't be deleted." : response['msg']; 
                    msg.className = danger;
                }
                hideMessage(2000, msg);
            }
        };
        xhttp.open('POST', route, false);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send('id='+id);
    }

    
});