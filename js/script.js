/**AFFICHAGE INSCRIPTION PAGE CONNEXION**/
function connexion() {
    let y = document.getElementById("formCo__fond");

    y.style.display = "none";
}

/**AFFICHAGE MENU CONTEXTUEL HEADER**/
function userHover() {
    let e = document.getElementById("headerHover__menu");

    if (e.style.display === "none") {
        e.style.display = "block";
        e.style.zIndex = "999";
    } else {
        e.style.display = "none";
    }
}

/**AFFICHAGE MENU CONTEXTUEL NOTIF**/
function notifHover() {
    let x = document.getElementById("headerHover__notif"); 

    if (x.style.display === "none") {
        x.style.display = "block";
        x.style.zIndex = "999";
    } else {
        x.style.display = "none";
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

/**ANIMATION HOVER DELETE**/
function newBin() {
    document.getElementById("post_userBin").src = "./src/icons/opentrash.svg";
}

function oldBin() {
    document.getElementById("post_userBin").src = "./src/icons/trash.svg";
}


/**FOCUS POUR LES COMMENTAIRES**/
function commentFocus() {
    document.getElementById("input_commentFocus").focus({preventScroll:false});
}