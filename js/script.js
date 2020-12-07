/**AFFICHAGE INSCRIPTION PAGE CONNEXION**/
function changement() {
    let x = document.getElementById("formCo__fond");

    x.style.display = "none";
}


/**AFFICHAGE MENU CONTEXTUEL HEADER**/
function userHover() {
    var e = document.getElementById("headerHover__menu");

    if (e.style.display === "none") {
        e.style.display = "block";
    } else {
        e.style.display = "none";
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
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
    setTimeout(() => {
        document.location.reload();
    }, 2000);
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
    document.getElementById("input_commentFocus").focus({
        preventScroll: false
    });
}

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