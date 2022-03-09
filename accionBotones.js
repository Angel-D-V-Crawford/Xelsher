

function cerrar() {

    window.location.href = "cerrarSesion.php";

}

function volver() {
                    
    window.location.href = "principal.php";

}

function verPerfil() {

    window.location.href = "verPerfil.php";

}

function modificar() {
                    
    window.location.href = "modificarPerfil.php";

}

function crearDibujo() {

    window.location.href = "inicializarDibujo.php";

}

function verDibujos() {

    window.location.href = "verDibujos.php";

}

function verAlbumes() {

    window.location.href = "verAlbumes.php";

}

function crearAlbum() {

    window.location.href = "crearAlbum.php";

}

function paginaPost() {

    window.location.href = "postPreparar.php";

}

function verNotificaciones() {

    window.location.href = "verNotificaciones.php";

}

function verPosts() {

    window.location.href = "verPostsPerfil.php";

}

function verAmigos() {

    window.location.href = "verAmigos.php";

}



var busqueda = document.getElementById("buscar");

busqueda.addEventListener("keypress", function(event) {
    // 13 = "Enter"
    if (event.keyCode === 13) {
        event.preventDefault();

        //Programar acción
        document.getElementById("formBuscar").submit();

        //document.getElementById("myBtn").click();
    } 
});

busqueda.addEventListener("keyup", function(event) {

    if(event.keyCode != 13) {

        document.getElementById("txtBuscar").value = busqueda.value;
        console.log(document.getElementById("txtBuscar").value);

    }

});




