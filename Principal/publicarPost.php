<?php
    
    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if
    
    if( isset( $_POST["texto"] ) ) {

        session_start();
        $id_usuario = $_SESSION["id"];

        $id_dibujo = $_POST["id_dibujo"];

        if( $_POST["texto"] != "" ) {

            $texto = mysqli_real_escape_string($conexion, $_POST["texto"]);
            $band = true;

        } else {

            $band = false;

        }

        if($band) {

            date_default_timezone_set("America/Mazatlan");
            $fecha = date("Y-m-d H:i:s");
        
            if( strcmp($id_dibujo, "default") == 0 ) {
        
                $sql = "INSERT INTO post(id_usuario, texto, fecha) 
                VALUES ($id_usuario, '$texto', '$fecha')";
        
            } else {
        
                $sql = "INSERT INTO post(id_usuario, texto, id_dibujo, fecha) 
                VALUES ($id_usuario, '$texto', $id_dibujo, '$fecha')";
        
            }
        
            $query = mysqli_query($conexion, $sql);
            if(!$query) {
        
                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
        
            } else {
        
                if(mysqli_affected_rows($conexion) > 0) {
        
                    echo "Post publicado";
                    header("Location: ../Principal/principal.php");
        
                } else {
        
                    echo "Hubo un fallo a la hora de intentar publicar <br><br>";
                    include "postPreparar.php";
        
                }
        
            } // fin if else

        } else {

            echo "No puedes publicar la nada... <br><br>";
            include "postPreparar.php";

        } // fin if else

    } else {

        echo "No puedes publicar la nada... <br><br>";
        include "postPreparar.php";

    } // fin if else

?>

