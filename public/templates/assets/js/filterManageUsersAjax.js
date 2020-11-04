import { setDeleteManager } from './deleteManageUserAjax.js';
import { setEditManager } from './editManageUserAjax.js';

document.addEventListener("DOMContentLoaded", ()=>{

    // ------------------------------------------- FILTER BY PAGE SECTION ------------------------------------------- //
    var section = document.getElementsByClassName('usersTable')[0];
    var page = 0;
    ajaxFilterPage();

    // This function is the main, and the encharge of reload all the files in each AJAX petition
    function resetScripts() {
        setDeleteManager();
        setEditManager();
        setFilterPage();
    }
    
    function ajaxFilterPage() {
            let route = '/home/manage/page';
    
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    section.innerHTML = this.response;
                    resetScripts();
                }
            };

            xhttp.open('POST', route, false);
            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhttp.send('page='+page);
    }


    function setFilterPage() {
        var pager = document.getElementsByClassName('usersTable')[0].getElementsByClassName("page-link");
        Array.prototype.forEach.call(pager, p=> {
            p.addEventListener("click", ()=>{
                page = p.dataset.page;
                ajaxFilterPage();
            });
        });
    }

    // ------------------------------------------- END FILTER BY PAGE SECTION ------------------------------------------- //



    // ------------------------------------------- FILTER BY SEARCH SECTION ------------------------------------------- //

    var searchBar = document.getElementsByClassName("search-bar")[0];
    var text = "";
    searchBar.addEventListener("input", ()=>{
        text = searchBar.value;
        clearTimeout(retrive)
        var retrive = setTimeout(() => {
            ajaxFilterResult();
        }, 500);
    });

    function ajaxFilterResult() {
        let route = '/home/manage/page';

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                section.innerHTML = this.response;
                resetScripts();
            }
        };

        xhttp.open('POST', route, false);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.send('text='+text);
}

    // ------------------------------------------- END FILTER BY SEARCH SECTION ------------------------------------------- //


});