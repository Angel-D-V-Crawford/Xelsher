<?php

    echo "<h1>XELSHER</h1>
    <br>";
    echo "<input type='button' id='btnRegresar' value='Principal' class='boton' onclick='window.location.href = \"principal.php\"'><br>";
    if(session_status() === PHP_SESSION_ACTIVE) {

        echo $_SESSION["usuario"] . "<br>";

    } else {

        session_start();
        echo $_SESSION["usuario"] . "<br>";

    }

    echo "<form id='formBuscar' action='almacenarBusqueda.php' method='POST'>
        <input type='hidden' id='txtBuscar' name='txtBuscar' value=''>
        <input type='search' id='buscar' name='buscar' class='textfield' placeholder='Buscar...'>
        <input type='submit' class='boton' value='Buscar'>
    </form>";

    echo "<input type='button' id='btnPerfil' value='Ver Perfil' class='boton' onclick='window.location.href = \"verPerfil.php\"'>";
    echo "<input type='button' id='btnAmigos' value='Ver Amigos' class='boton' onclick='window.location.href = \"verAmigos.php\"'>";
    echo "<input type='button' id='btnNotificaciones' value='Ver Notificaciones' class='boton' onclick='window.location.href = \"verNotificaciones.php\"'>";
    echo "<input type='button' id='btnVerPosts' value='Ver Posts' class='boton' onclick='window.location.href = \"verPostsPerfil.php\"'>";
    echo "<input type='button' id='btnDibujos' value='Ver Dibujos' class='boton' onclick='window.location.href = \"verDibujos.php\"'>";
    echo "<input type='button' id='btnCrear' value='Crear Dibujo' class='boton' onclick='window.location.href = \"inicializarDibujo.php\"'>";
    echo "<input type='button' id='btnAlbumes' value='Ver Albumes' class='boton' onclick='window.location.href = \"verAlbumes.php\"'>";
    echo "<input type='button' id='btnCrearAlbumes' value='Crear Album' class='boton' onclick='window.location.href = \"crearAlbum.php\"'>";
    echo "<input type='button' name='btnCerrar' value='Cerrar Sesión' class='boton' onclick='window.location.href = \"cerrarSesion.php\"'>";

    /*
    echo "<input type='button' id='btnPerfil' value='Ver Perfil' onclick='verPerfil()'>";
    echo "<input type='button' id='btnAmigos' value='Ver Amigos' onclick='verAmigos()'>";
    echo "<input type='button' id='btnNotificaciones' value='Ver Notificaciones' onclick='verNotificaciones()'>";
    echo "<input type='button' id='btnVerPosts' value='Ver Posts' onclick='verPosts()'>";
    echo "<input type='button' id='btnDibujos' value='Ver Dibujos' onclick='verDibujos()'>";
    echo "<input type='button' id='btnCrear' value='Crear Dibujo' onclick='crearDibujo()'>";
    echo "<input type='button' id='btnAlbumes' value='Ver Albumes' onclick='verAlbumes()'>";
    echo "<input type='button' id='btnCrearAlbumes' value='Crear Album' onclick='crearAlbum()'>";
    echo "<input type='button' name='btnCerrar' value='Cerrar Sesión' onclick='cerrar()'>";
    */

?>