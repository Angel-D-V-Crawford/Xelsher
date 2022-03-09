<?php
    
    include_once "../db.php";

    session_start();
    if( isset( $_POST["seleccionado"] ) ) {

        $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

        if(!$conexion) {

            echo "No se pudo conectar al servidor...";
            die();

        } // fin if

        $id = $_SESSION["id"];
        $id_seleccionado = $_POST["seleccionado"];
        $id_seleccionado_tmp = explode( ' ', $id_seleccionado );
        $id_post_tmp = $id_seleccionado_tmp[0];

        if( strcmp($id_seleccionado, "$id_post_tmp P") == 0 ) {

            $_SESSION["ir_a_post"] = $id_post_tmp;
            header("Location: verPostNotificacion.php");

        } else {

            $sql = "UPDATE notificacion 
            SET activo = 0 
            WHERE id_notificacion = $id_seleccionado AND id_usuario = $id";
            $query = mysqli_query($conexion, $sql);
            if(!$query) {
    
                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
    
            }

        }

    }
    
?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title> Notificaciones </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>

        <div class="wrapper">

            <div id="encabezado">

                <?php
                    include "../encabezado.php";
                ?>
                <script src="../accionBotones.js"></script>

            </div>
            <br>
            <br>

            <div id="cuerpo">

                <form action="#" method="POST">
                <input type='hidden' id='seleccionado' name='seleccionado' value="" />
                <input type='hidden' id='postNotificacion' name='postNotificacion' value="" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    //$post_seleccionado = $_SESSION["post_seleccionado"];
                    //echo ($busqueda == "") ? "vacio <br>" : ($busqueda . "<br>");

                    $sql = "SELECT * FROM notificacion WHERE id_usuario = $id AND activo = 1 ORDER BY fecha DESC";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount > 0) {

                            $i = 0;
                            while($notificacion = mysqli_fetch_array($query)) {

                                $id_notificacion = $notificacion["id_notificacion"];
                                $descripcion = $notificacion["descripcion"];
                                $id_post_notificacion = $notificacion["id_post"];
                                $fecha = $notificacion["fecha"];
                                $fecha_formateada = strtotime($fecha);
                                $fecha_formateada = date("d/m/Y   h:i:s A", $fecha_formateada);

                                if( is_null($id_post_notificacion) ) {

                                    echo "<div class='notificacion'> 
                                    $descripcion <br>
                                    $fecha_formateada <br>
                                    <input type='submit' name='$id_notificacion' value='Borrar notificación' class='boton' 
                                    onmouseenter='cambiarOculto(this.name, false)' onmouseout=''>";

                                } else {

                                    echo "<div class='notificacion'> 
                                    $descripcion <br>
                                    $fecha_formateada <br>
                                    <input type='submit' name='$id_notificacion' value='Borrar notificación' class='boton' 
                                    onmouseenter='cambiarOculto(this.name, false)' onmouseout=''>
                                    <input type='submit' name='$id_post_notificacion' value='Ir a...' class='boton' 
                                    onmouseenter='cambiarOculto(this.name, true)' onmouseout=''>";

                                }

                                echo "</div>";
                                echo "<br><br><br>";
                                $i++;

                            }

                        } else {

                            echo "Aun no ha recibido notificaciones";

                        } // fin if else

                    } // fin if else

                ?>
                </form>
                <script>
                    function cambiarOculto(id, esIr) {

                        if(esIr) {

                            document.getElementById("seleccionado").value = id + " P";
                            var elemento = document.getElementById("seleccionado").value;
                            console.log(elemento);

                        } else {

                            document.getElementById("seleccionado").value = id;
                            var elemento = document.getElementById("seleccionado").value;
                            console.log(elemento);

                        }

                    }

                </script>

            </div>

        </div>

    </body>
</html>