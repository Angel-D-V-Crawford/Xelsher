<?php

    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    if( isset( $_POST["txtTitulo"] ) && isset( $_POST["descripcion"] ) ) {

        session_start();
        $id_usuario = $_SESSION["id"];

        if($_POST["txtTitulo"] != "" && $_POST["descripcion"] != "") {
            $titulo = mysqli_real_escape_string($conexion, $_POST["txtTitulo"]);
            $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]); 
            $id_album = $_POST["id_album"];
            $band = true;
        } else {
            $band = false;
        }

        if($band) {

            $sql = "UPDATE album 
                SET titulo = '$titulo', descripcion = '$descripcion' 
                WHERE id_album = $id_album AND id_usuario = $id_usuario";
        
            $query = mysqli_query($conexion, $sql);
        
            if(!$query) {
        
                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion) . "<br>";
        
            } else {
        
                if(mysqli_affected_rows($conexion) > 0) {
        
                    echo "Los datos han sido actualizados correctamente <br>";
                        
                } else {
        
                    echo "No hubo necesidad de realizar modificaciones <br>";
        
                }
        
            } // fin if else
        
            header("Location: verAlbumes.php");

        } else {

            echo "Los campos no pueden quedar vacios <br><br>";
            include "modificarAlbum.php";

        } // fin if else

    } else {

        echo "Los campos no pueden quedar vacios <br><br>";
        include "modificarAlbum.php";

    } // fin if else

?>