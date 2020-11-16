/**AFFICHAGE INSCRIPTION PAGE CONNEXION**/
function changement() {
    let x = document.getElementById("formCo__fond");
    
    x.style.display="none";
}


/**AFFICHAGE MENU CONTEXTUEL HEADERS**/
function userHover() {
    let showMenu = document.getElementById("headerHover__menu");
    showMenu.style.display="none";

    if (showMenu.style.display == "none") {
        showMenu.style.display="block";
    } else {
        showMenu.style.display="none";
    }
}