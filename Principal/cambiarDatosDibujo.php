<?php

    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    session_start();
    $id_usuario = $_SESSION["id"];

    $id_dibujo = $_POST["id_dibujo"];
    $titulo = mysqli_real_escape_string($conexion, $_POST["txtTitulo"]);
    $id_album = $_POST["album"];
    

    if( strcmp($id_album, "default") == 0 ) {

        $sql = "UPDATE dibujo 
        SET titulo = '$titulo' 
        WHERE id_dibujo = $id_dibujo AND id_usuario = $id_usuario";

    } else {

        $sql = "UPDATE dibujo 
        SET titulo = '$titulo', id_album = $id_album 
        WHERE id_dibujo = $id_dibujo AND id_usuario = $id_usuario";

    }
    $query = mysqli_query($conexion, $sql);

    if(!$query) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion) . "<br>";

    } else {

        if(mysqli_affected_rows($conexion) > 0) {

            echo "Los datos han sido actualizados correctamente <br>";
                
        } else {

            echo "Hubo un fallo en la modificación <br>";

        }

    } // fin if else

    header("Location: verDibujos.php");

?>