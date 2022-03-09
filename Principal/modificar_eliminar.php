<?php

    session_start();
    $_SESSION["id_dibujo"] = $_POST["oculto"];
    $id_del_dibujo = $_POST["oculto"];

    $dos = $_POST["ocultoDos"];
    if( isset($_POST["$dos"]) ) {

        //echo "Hacer script de eliminación de $id_del_dibujo";
        header("Location: eliminarDibujo.php");

    } else {

        header("Location: dibujoVer.php");

    }

?>