/**AFFICHAGE INSCRIPTION PAGE CONNEXION**/
function connexion() {
    let y = document.getElementById("page__title");

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

function update() {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: 'Mis à jour',
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
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    setTimeout(() => {
        document.location.reload();
    }, 2000);
}


/**ANIMATION HOVER DELETE PUBLICATION**/
function newBin() {
    document.getElementById("post_userBin").src = "./src/icons/opentrash.svg";
}

function oldBin() {
    document.getElementById("post_userBin").src = "./src/icons/trash.svg";
}


/**FOCUS POUR LES COMMENTAIRES**/
function commentFocus() {
    document.getElementById("input_commentFocus").focus({
        preventScroll: false
    });
}


/**RECHERCHE D'AMIS**/
let search = document.getElementById('headerSearch__input');
search.addEventListener('keyup', function () {
    if (search.value == '') {
        document.getElementById('results').innerHTML = '';
    } else {
        const req = new XMLHttpRequest();
        req.addEventListener("load", evt => {
            let data = req.responseText;
            console.log(data);
            document.getElementById('results').innerHTML = data;
        });
        req.open("GET", "http://localhost/FaceMe/traitement/search.php?recherche=" + search.value);
        req.send()
    }
});


/**BOUTON FILE PUBLICATION**/
function filePost() { 
    let realFileBtnPost = document.getElementById("real_inputPost"); 
    realFileBtnPost.click();
}


/**BOUTON FILE COMMENTAIRE**/
function fileCom() { 
    let realFileBtnCom = document.getElementById("real_inputCom"); 
    realFileBtnCom.click();
}


/**BOUTON FILE PHOTOS**/
function filePhotos() { 
    let realFileBtnPhotos = document.getElementById("real_inputPhotos"); 
    realFileBtnPhotos.click();
}

/**BOUTON FILE AVATAR SETTINGS**/
function fileSetAvatar() {
    let realFileBtnSet = document.getElementById("real_inputSetAvatar");
    realFileBtnSet.click();
}
/**BOUTON FILE BACKGROUND SETTINGS**/
function fileSetBackground() {
    let realFileBtnSet = document.getElementById("real_inputSetBackground");
    realFileBtnSet.click();
}