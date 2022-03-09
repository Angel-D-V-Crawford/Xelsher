<?php

    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    if( 
        isset( $_POST["email"] ) 
        && isset( $_POST["nombre"] ) 
        && isset( $_POST["apellidos"] ) 
        && isset( $_POST["usuario"] ) 
        && isset( $_POST["contra"] ) 
        && isset( $_POST["genero"] ) 
        && isset( $_POST["pais"] ) 
    ) {

        if($_POST["email"] != "" && $_POST["nombre"] != "" && $_POST["apellidos"] != "" && $_POST["usuario"] != "" 
            && $_POST["contra"] != "" && $_POST["genero"] != "" && $_POST["pais"] != "") {
            $email = $_POST["email"]; 
            $nombre = $_POST["nombre"];
            $apellidos = $_POST["apellidos"];
            $usuario = $_POST["usuario"];
            $contra = $_POST["contra"];
            $genero = $_POST["genero"];
            $pais = $_POST["pais"];

            $band = true;
        } else {
            $band = false;
        }

        if( $band ) {

            $imagen = $_FILES["file_imagen"]["tmp_name"];
            $imagen_tamano = $_FILES["file_imagen"]["size"];
            $imagen_tipo = $_FILES["file_imagen"]["type"];
            $imagen_nombre = $_FILES["file_imagen"]["name"];
    
            if($imagen_tamano <= 16776900) {
    
                if($imagen_tamano == 0) {
    
                    $nombre_archivo = "iconoPerfil.jpg";
    
                } else {
    
                    $carpeta_destino = "../Imagenes/";
                    $nombre_archivo = $carpeta_destino . $imagen_nombre;
                    move_uploaded_file($imagen, $nombre_archivo);
    
                }
    
                $archivo_objetivo = fopen($nombre_archivo, "r");
                $contenido_blob = fread($archivo_objetivo, filesize($nombre_archivo));
                $contenido_blob = addslashes($contenido_blob);
                fclose($archivo_objetivo);
    
                $sql = "SELECT email FROM usuario WHERE email='$email'";
                $query = mysqli_query($conexion, $sql);
    
                if(!$query) {
    
                    echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
    
                } else {
    
                    if(mysqli_num_rows($query) > 0) {
    
                        echo "Usted ya se encuentra registrado <br>";
    
                    } else {
    
                        $sql = "INSERT INTO usuario(email, nombre, apellidos, usuario, contrasena, genero, pais, imagen) 
                        VALUES ('$email', '$nombre', '$apellidos', '$usuario', '$contra', '$genero', '$pais', '$contenido_blob')";
                        $query = mysqli_query($conexion, $sql);
    
                        if(!$query) {
    
                            echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
    
                        } else {
    
                            if(mysqli_affected_rows($conexion) > 0) {
    
                                echo "Usted se ha registrado correctamente";
    
                            } else {
    
                                echo "Hubo un fallo en el registro";
    
                            }
    
                        } // fin if else
    
                    }
    
                }
    
            } else {
    
                echo "El archivo es demasiado grande. El máximo es de 16 MB <br><br>";
    
            }

        } else {

            echo "Faltan campos por llenar <br><br>";

        }
        

    } else {

        echo "Faltan campos por llenar <br><br>";

    }

    include "registro_usuario.html";

?>