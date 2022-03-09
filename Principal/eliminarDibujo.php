<?php

    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    session_start();
    $id_usuario = $_SESSION["id"];
    $id_dibujo = $_SESSION["id_dibujo"];

    $sql = "UPDATE dibujo 
        SET activo = 0 
        WHERE id_dibujo = $id_dibujo AND id_usuario = $id_usuario";
    $query = mysqli_query($conexion, $sql);

    if(!$query) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion) . "<br>";

    } else {

        if(mysqli_affected_rows($conexion) > 0) {

            echo "El dibujo ha sido eliminado correctamente <br>";
                
        } else {

            echo "Hubo un fallo en la eliminación <br>";

        }

    } // fin if else

    header("Location: verDibujos.php");

?>