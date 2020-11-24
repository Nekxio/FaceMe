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

function deconnexion() {
    Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Déconnexion',
    showConfirmButton: false,
    timer: 1500
    })
}

function friendship() {
    Swal.fire({
    position: 'center',
    icon: 'success',
    title: 'Demande envoyée',
    showConfirmButton: false,
    timer: 1500
    })
}

function scrollToTop() { 
    window.scrollTo({ top: 0, behavior: 'smooth' });
    setTimeout(() => { document.location.reload(); }, 2000);
}