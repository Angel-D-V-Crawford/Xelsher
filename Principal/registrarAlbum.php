<?php
    
    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    if( isset( $_POST["titulo"] ) && isset( $_POST["descripcion"] ) )  {

        session_start();

        $id_usuario = $_SESSION["id"];

        if($_POST["titulo"] != "" && $_POST["descripcion"] != "") {
            $titulo = mysqli_real_escape_string($conexion, $_POST["titulo"]);
            $descripcion = mysqli_real_escape_string($conexion, $_POST["descripcion"]); 
            $band = true;
        } else {
            $band = false;
        }

        date_default_timezone_set("America/Mazatlan");
        $fecha = date("Y-m-d H:i:s");
        
        /*
        echo $fecha;
        echo "<br>" . date_default_timezone_get();
        */

        if($band) {

            $sql = "INSERT INTO album(id_usuario, titulo, descripcion, fecha) 
                VALUES ($id_usuario, '$titulo', '$descripcion', '$fecha')";

            $query = mysqli_query($conexion, $sql);
            if(!$query) {

                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

            } else {

                if(mysqli_affected_rows($conexion) > 0) {

                    echo "Album creado";

                } else {

                    echo "Hubo un fallo en la creación del album";

                }

            } // fin if else
            header("Location: ../Principal/principal.php");

        } else {

            echo "Los campos no pueden quedar vacios <br><br>";
            include "crearAlbum.php";

        } // fin if else

    } else {

        echo "Los campos no pueden quedar vacios <br><br>";
        include "crearAlbum.php";

    } // fin if else

?>

