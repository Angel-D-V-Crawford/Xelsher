<?php

    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    session_start();

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
            $nombre = mysqli_real_escape_string($conexion, $_POST["nombre"]);
            $apellidos = mysqli_real_escape_string($conexion, $_POST["apellidos"]);
            $usuario = mysqli_real_escape_string($conexion, $_POST["usuario"]);
            $nueva_contra = mysqli_real_escape_string($conexion, $_POST["contra"]);
            $genero = $_POST["genero"];
            $pais = mysqli_real_escape_string($conexion, $_POST["pais"]);

            $band = true;
        } else {
            $band = false;
        }

        if($band) {

            $imagen = $_FILES["file_imagen"]["tmp_name"];
            $imagen_tamano = $_FILES["file_imagen"]["size"];
            $imagen_tipo = $_FILES["file_imagen"]["type"];
            $imagen_nombre = $_FILES["file_imagen"]["name"];

            if($imagen_tamano <= 16776900) {

                $nueva_imagen = "";

                if($imagen != "") {

                    $carpeta_destino = "../Imagenes/";
                    $nombre_archivo = $carpeta_destino . $imagen_nombre;
                    move_uploaded_file($imagen, $nombre_archivo);

                    $archivo_objetivo = fopen($nombre_archivo, "r");
                    $contenido_blob = fread($archivo_objetivo, $imagen_tamano);
                    $contenido_blob = addslashes($contenido_blob);
                    fclose($archivo_objetivo);

                    $nueva_imagen = $contenido_blob;

                } else {

                    $nueva_imagen = addslashes($_SESSION["imagen"]);

                }
                
                /*
                if($imagen_tamano == 0 && $_FILES['file_imagen']['error'] == 0) {

                    session_start();
                    $nueva_imagen = $_SESSION["imagen"];

                }
                */

                $contra = $_SESSION["contrasena"];
                $imagen_codificada = $nueva_imagen;

                $sql = "UPDATE usuario 
                SET email = '$email', nombre = '$nombre', apellidos = '$apellidos', usuario = '$usuario', contrasena = '$nueva_contra', 
                genero = '$genero', pais = '$pais', imagen = '$nueva_imagen' 
                WHERE usuario.email = '$email' AND contrasena = '$contra'";
                $query = mysqli_query($conexion, $sql);

                if(!$query) {

                    echo "Hubo un fallo en la consulta: " . mysqli_error($conexion) . "<br>";

                } else {

                    if(mysqli_affected_rows($conexion) > 0) {

                        echo "Los datos han sido actualizados correctamente <br>";

                        $sql = "SELECT * FROM usuario WHERE email='$email' AND contrasena='$nueva_contra'";

                        $resultados = mysqli_query($conexion, $sql);

                        if(!$resultados) {

                            echo "Hubo un fallo en la consulta de actualización: " . mysqli_error($conexion) . "<br>";

                        } else {

                            while($usuario = mysqli_fetch_array($resultados)) {

                                $_SESSION["email"] = $usuario["email"];
                                $_SESSION["nombre"] = $usuario["nombre"];
                                $_SESSION["apellidos"] = $usuario["apellidos"];
                                $_SESSION["usuario"] = $usuario["usuario"];
                                $_SESSION["contrasena"] = $usuario["contrasena"];
                                $_SESSION["genero"] = $usuario["genero"];
                                $_SESSION["pais"] = $usuario["pais"];
                                $_SESSION["imagen"] = $usuario["imagen"];
                
                            }

                        }
                        
                    } else {

                        echo "No fue necesario realizar cambios <br>";

                    }

                    include "verPerfil.php";

                } // fin if else

            } else {

                echo "El archivo es demasiado grande. El máximo es de 16 MB <br>";
                include "modificarPerfil.php";

            }

        } else {

            echo "No se pueden dejar campos vacios <br><br>";
            include "modificarPerfil.php";

        }

    } else {

        echo "No se pueden dejar campos vacios <br><br>";
        include "modificarPerfil.php";

    }
    
?>