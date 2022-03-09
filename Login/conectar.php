<?php

    include "login.html";
    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    $email = $_POST["email"];
    $contra = $_POST["contra"];
    $sql = "SELECT * FROM usuario WHERE usuario.email = '$email' AND usuario.contrasena = '$contra'";
    $query = mysqli_query($conexion, $sql);

    if(!$query) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

    } else {

        $rowcount = mysqli_num_rows($query);

        if($rowcount == 1) {

            session_start();

            while($usuario = mysqli_fetch_array($query)) {

                $_SESSION["id"] = $usuario["id_usuario"];
                $_SESSION["email"] = $usuario["email"];
                $_SESSION["nombre"] = $usuario["nombre"];
                $_SESSION["apellidos"] = $usuario["apellidos"];
                $_SESSION["usuario"] = $usuario["usuario"];
                $_SESSION["contrasena"] = $usuario["contrasena"];
                $_SESSION["genero"] = $usuario["genero"];
                $_SESSION["pais"] = $usuario["pais"];
                $_SESSION["imagen"] = $usuario["imagen"];

            }

            header("Location: ../Principal/principal.php");

        } else {

            echo "Correo y/o contraseña invalidos";

        } // fin if else

    } // fin if else

?>

