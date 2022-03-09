<?php
    
    include_once "../db.php";

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    
    //$sql = "SELECT * FROM usuario WHERE usuario.email = '$email' AND usuario.contrasena = '$contra'";
    //$query = mysqli_query($conexion, $sql);

    //if(!$query) {

    //    echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

    //} else {

        session_destroy();

        header("Location: ../Login/login.html");

    //} // fin if else

?>

