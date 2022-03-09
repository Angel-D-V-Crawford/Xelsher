<?php
    
    include_once "../db.php";
    
    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if
    
    session_start();

    $id_usuario = $_SESSION["id"];

    $titulo = mysqli_real_escape_string($conexion, $_POST["titulo"]);
    $dimension = $_POST["dimension"];

    $dibujo = $_POST["imagen_blob"];
    $id_album = $_POST["album"];

    date_default_timezone_set("America/Mazatlan");
    $fecha = date("Y-m-d H:i:s");

    $data = substr($dibujo, strpos($dibujo, ",") + 1);
    $decodedData = base64_decode($data);
    $fp = fopen("../Imagenes/canvas.png", 'wb');
    fwrite($fp, $decodedData);
    fclose($fp);

    $nombre_archivo = "../Imagenes/canvas.png";
    $archivo_objetivo = fopen($nombre_archivo, "r");
    $contenido_blob = fread($archivo_objetivo, filesize($nombre_archivo));
    $contenido_blob = addslashes($contenido_blob);
    fclose($archivo_objetivo);
    
    /*
    echo $fecha;
    echo "<br>" . date_default_timezone_get();
    */

    if($id_album == "default") {

        $sql = "INSERT INTO dibujo(id_usuario, titulo, dimension, imagen, fecha) 
            VALUES ($id_usuario, '$titulo', $dimension, '$contenido_blob', '$fecha')";

    } else {

        $sql = "INSERT INTO dibujo(id_usuario, titulo, dimension, imagen, id_album, fecha) 
        VALUES ($id_usuario, '$titulo', $dimension, '$contenido_blob', $id_album, '$fecha')";

    }

    $query = mysqli_query($conexion, $sql);
    if(!$query) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

    } else {

        if(mysqli_affected_rows($conexion) > 0) {

            echo "Dibujo publicado";

        } else {

            echo "Hubo un fallo en la publicacion";

        }

    } // fin if else
    header("Location: ../Principal/principal.php");

?>

