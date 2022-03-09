<?php

    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    session_start();
    $id_usuario = $_SESSION["id"];
    $id_album = $_SESSION["id_album"];

    $sql = "UPDATE album 
        SET activo = 0 
        WHERE id_album = $id_album AND id_usuario = $id_usuario";
    $query = mysqli_query($conexion, $sql);

    if(!$query) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion) . "<br>";

    } else {

        if(mysqli_affected_rows($conexion) > 0) {

            echo "El album ha sido eliminado correctamente <br>";
                
        } else {

            echo "Hubo un fallo en la eliminación <br>";

        }

    } // fin if else

    header("Location: verAlbumes.php");

?>