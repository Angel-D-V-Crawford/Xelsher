<?php

    if( isset( $_POST["txtBuscar"] ) ) {

        $texto_buscado = $_POST["txtBuscar"];
        //echo ($texto_buscado == "") ? "vacio <br>" : ($texto_buscado . "<br>");
    
        if($texto_buscado != "") {

            session_start();
            $_SESSION["busqueda"] = $texto_buscado;
            //echo ($_SESSION["busqueda"] == "") ? "vacio <br>" : ($_SESSION["busqueda"] . "<br>");
        
            header("Location: resultadoBuscados.php");

        } else {

            echo "No se ha podido realizar la busqueda... <br><br>";
            include "principal.php";

        }

    } else {

        echo "No se ha podido realizar la busqueda... <br><br>";
        include "principal.php";

    }

?>