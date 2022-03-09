<?php
    
    include_once "../db.php";

    session_start();

    if( isset( $_POST["seleccionado"] ) && !isset( $_POST["comentar"] ) ) {

        $seleccionado = $_POST["seleccionado"];
        $seleccionado_arr = explode( ' ', $seleccionado );
        $seleccionado_id = $seleccionado_arr[0];

        if( strcmp($seleccionado, "$seleccionado_id U") == 0 ) {

            $_SESSION["perfil_seleccionado"] = $seleccionado_id;
            header("Location: verPerfilExterno.php");
            
        } else if( strcmp($seleccionado, "$seleccionado_id E") == 0 ) {

            $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

            if(!$conexion) {

                echo "No se pudo conectar al servidor...";
                die();

            } // fin if

            $id = $_SESSION["id"];
            //$comentario_seleccionado = $_POST["seleccionado"];
            //echo ($busqueda == "") ? "vacio <br>" : ($busqueda . "<br>");

            $sql = "UPDATE comentario 
            SET activo = 0 
            WHERE id_comentario = $seleccionado_id AND id_usuario = $id";
            $query = mysqli_query($conexion, $sql);
            if(!$query) {

                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

            }

        }

    } else if( isset( $_POST["comentar"] ) ) {

        $conexionComentar = mysqli_connect($HOST, $USER, $PASSWORD, $DB);
        if(!$conexionComentar) {

            echo "No se pudo conectar al servidor...";
            die();

        } // fin if

        $id_usuario = $_SESSION["id"];
        $comentario = mysqli_real_escape_string($conexionComentar, $_POST["comentario"]);
        $nombre_usuario = $_SESSION["usuario"];
        date_default_timezone_set("America/Mazatlan");
        $fecha = date("Y-m-d H:i:s");

        if($comentario != "") {

            $id_post_comentar = $_SESSION["post_seleccionado"];

            $sqlComentar = "INSERT INTO comentario(id_post, id_usuario, texto, fecha) 
                VALUES ($id_post_comentar, $id_usuario, '$comentario', '$fecha')";
    
            $queryComentar = mysqli_query($conexionComentar, $sqlComentar);
            if(!$queryComentar) {
                echo "Hubo un fallo en la consulta: " . mysqli_error($conexionComentar);
            } else if( isset($_SESSION["id_usuario_post_tmp"]) ) {
    
                $usuarioDiferente = $_SESSION["id_usuario_post_tmp"];
                if($usuarioDiferente != $id_usuario) {
                    $sqlNotificacion = "INSERT INTO notificacion(id_usuario, descripcion, id_post, fecha) 
                    VALUES ($paraUsuario, '$nombre_usuario ha comentado tu post!', $id_post_comentar, '$fecha')";
    
                    $queryNotificacion = mysqli_query($conexionComentar, $sqlNotificacion);
                    if(!$queryNotificacion) {
                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexionComentar);
                    }
                }
            }

        } else {

            echo "No puedes comentar la nada... <br><br>";

        } // fin if else

    }

?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title> Comentarios </title>
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
                <textarea id='comentario' name='comentario' cols='40' rows='3'></textarea> <br>
                <input type="submit" name='comentar' class="boton" value='Dejar comentario'> <br><br><br>

                <input type='hidden' id='seleccionado' name='seleccionado' value="" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    $post_seleccionado = $_SESSION["post_seleccionado"];
                    //echo ($busqueda == "") ? "vacio <br>" : ($busqueda . "<br>");

                    $sql = "SELECT id_comentario, comentario.id_usuario, texto, fecha, usuario.usuario FROM comentario 
                    INNER JOIN usuario ON usuario.id_usuario = comentario.id_usuario 
                    WHERE comentario.id_post = $post_seleccionado AND comentario.activo = 1";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount > 0) {

                            $i = 0;
                            while($comentario = mysqli_fetch_array($query)) {

                                $id_comentario = $comentario["id_comentario"];
                                $id_usuario_comentario = $comentario["id_usuario"];
                                $texto_comentario = $comentario["texto"];
                                $fecha_comentario = $comentario["fecha"];
                                $usuario_comentario = $comentario["usuario"];

                                $fecha_formateada = strtotime($fecha_comentario);
                                $fecha_formateada = date("d/m/Y   h:i:s A", $fecha_formateada);

                                echo "<div class='comentario'> 
                                    $usuario_comentario "; 
                                
                                if($id_usuario_comentario != $id) {

                                    echo "<input type='submit' name='$id_usuario_comentario U' value='Ver perfil' 
                                    onmouseenter='cambiarOculto(this.name);' class='boton'> ";

                                }
                                
                                echo "<br><br>
                                    $texto_comentario <br><br>
                                    $fecha_formateada <br>";

                                if($id_usuario_comentario == $id) {
                                    echo "<input type='submit' name='$id_comentario E' value='Eliminar comentario' 
                                    onmouseenter='cambiarOculto(this.name)' class='boton'> <br>";
                                }

                                echo "</div>";
                                echo "<br><br><br>";
                                $i++;

                            }

                        } else {

                            echo "Aun no ha recibido comentarios";

                        } // fin if else

                    } // fin if else

                ?>
                </form>
                <script>
                    function cambiarOculto(id) {

                        document.getElementById("seleccionado").value = id;
                        var elemento = document.getElementById("seleccionado").value;
                        console.log(elemento);

                    }
                </script>

            </div>

        </div>

    </body>
</html>