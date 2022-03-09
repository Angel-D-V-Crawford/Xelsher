<?php

    include_once "../db.php";

    session_start();

    if( isset($_POST["C"]) ) {

        $conexionComentar = mysqli_connect($HOST, $USER, $PASSWORD, $DB);
        if(!$conexionComentar) {

            echo "No se pudo conectar al servidor...";
            die();

        } // fin if

        $id_usuario = $_SESSION["id"];
        $comentario = $_POST["comentario"];
        $nombre_usuario = $_SESSION["usuario"];
        date_default_timezone_set("America/Mazatlan");
        $fecha = date("Y-m-d H:i:s");

        if($comentario != "") {

            $id_post_comentar = $_SESSION["ir_a_post"];

            $sqlComentar = "INSERT INTO comentario(id_post, id_usuario, texto, fecha) 
                VALUES ($id_post_comentar, $id_usuario, '$comentario', '$fecha')";
    
            $queryComentar = mysqli_query($conexionComentar, $sqlComentar);
            if(!$queryComentar) {
                echo "Hubo un fallo en la consulta: " . mysqli_error($conexionComentar);
            } else if( isset($_SESSION["id_usuario_post_tmp"]) ) {
    
                $usuarioDiferente = $_SESSION["id_usuario_post_tmp"];
                if($usuarioDiferente != $id_usuario) {
                    $sqlNotificacion = "INSERT INTO notificacion(id_usuario, descripcion, id_post, fecha) 
                    VALUES ($usuarioDiferente, '$nombre_usuario ha comentado tu post!', $id_post_comentar, '$fecha')";
    
                    $queryNotificacion = mysqli_query($conexionComentar, $sqlNotificacion);
                    if(!$queryNotificacion) {
                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexionComentar);
                    }
                }
            }

        } else {

            echo "No puedes comentar la nada... <br><br>";

        }

    } else if( isset($_POST["VC"]) ) {

        $id_post_ver_comentarios = $_SESSION["ir_a_post"];
        $_SESSION["post_seleccionado"] = $id_post_ver_comentarios;
        header("Location: verComentarios.php");

    } else if( isset($_POST["LIKE"]) ) {

        $conexionLikes = mysqli_connect($HOST, $USER, $PASSWORD, $DB);
        if(!$conexionLikes) {

            echo "No se pudo conectar al servidor...";
            die();

        } // fin if
        $id_usuario = $_SESSION["id"];
        $nombre_usuario = $_SESSION["usuario"];

        $id_post_like = $_SESSION["ir_a_post"];

        $sql = "SELECT * FROM likes WHERE id_post = $id_post_like AND id_usuario = $id_usuario";
        $query = mysqli_query($conexionLikes, $sql);
        if(!$query) {

            echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

        } else {

            $enviarNotificacion = false;
            date_default_timezone_set("America/Mazatlan");
            $fecha = date("Y-m-d H:i:s");

            $rowcount = mysqli_num_rows($query);
            if($rowcount == 0) {

                $sqlLike = "INSERT INTO likes(id_post, id_usuario, es_like) 
                VALUES ($id_post_like, $id_usuario, 1); ";
                
                $usuarioDiferente = $_SESSION["id_usuario_post_tmp"];
                if($usuarioDiferente != $id_usuario) {
                    $sqlLike = $sqlLike . "INSERT INTO notificacion(id_usuario, descripcion, id_post, fecha) 
                    VALUES ($id_usuario, 'A $nombre_usuario le ha gustado tu post!', $id_post_like, '$fecha')";
                }

                $enviarNotificacion = true;
                
            } else {
                $descLike = mysqli_fetch_array($query);
                if( $descLike["es_like"] == '1' ) {
                    $sqlLike = "UPDATE likes 
                    SET es_like = 0 
                    WHERE id_post = $id_post_like AND id_usuario = $id_usuario";
                } else {
                    $sqlLike = "UPDATE likes 
                    SET es_like = 1 
                    WHERE id_post = $id_post_like AND id_usuario = $id_usuario";
                    $enviarNotificacion = true;
                }
            }

            $queryLikes = mysqli_query($conexionLikes, $sqlLike);
            if(!$queryLikes) {
                echo "Hubo un fallo en la consulta: " . mysqli_error($conexionLikes);
            } else if($enviarNotificacion) {

                $usuarioDiferente = $_SESSION["id_usuario_post_tmp"];
                if($usuarioDiferente != $id_usuario) {

                    $sqlNotificacion = "INSERT INTO notificacion(id_usuario, descripcion, id_post, fecha) 
                    VALUES ($id_usuario, 'A $nombre_usuario le ha gustado tu post!', $id_post_like, '$fecha')";
    
                    $queryNotificacion = mysqli_query($conexionLikes, $sqlNotificacion);
                    if(!$queryNotificacion) {
                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexionLikes);
                    }

                }

            }

        }

    } else if ( isset($_POST["U"]) ) {

        $_SESSION["perfil_seleccionado"] = $seleccionado_id;
        header("Location: verPerfilExterno.php");

    }

?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title> Post </title>
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
                <input type="hidden" id='seleccionado' name="seleccionado" value='0'>
                <input type="hidden" id='textoComentario' name="textoComentario" value=''>
                <input type="hidden" id='usuarioPost' name="usuarioPost" value="">
                <?php

                    $mensajeBoton = "";

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id_usuario = $_SESSION["id"];
                    $id_post_notificacion = $_SESSION["ir_a_post"];

                    /*
                        Query para obtener los post del propio usuario

                        SELECT * FROM post INNER JOIN usuario ON usuario.id_usuario = post.id_usuario 
                        INNER JOIN dibujo ON dibujo.id_dibujo = post.id_dibujo ORDER BY post.fecha DESC 
                    */
                    $sql = "SELECT id_post, post.id_usuario, texto, post.id_dibujo, post.fecha, usuario.usuario, dibujo.imagen 
                    FROM post 
                    INNER JOIN usuario ON usuario.id_usuario = post.id_usuario 
                    LEFT JOIN dibujo ON dibujo.id_dibujo = post.id_dibujo 
                    WHERE id_post = $id_post_notificacion AND post.activo = 1";
                    $query = mysqli_query($conexion, $sql);

                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount == 1) {

                            $post = mysqli_fetch_array($query);

                                $id_post = $post["id_post"];

                                $id_usuario_post = $post["id_usuario"];
                                $_SESSION["id_usuario_post_tmp"] = $id_usuario_post;

                                $texto = $post["texto"];
                                //$likes = $post["likes"];
                                $id_dibujo_post = $post["id_dibujo"];
                                $fecha = $post["fecha"];
                                $usuario = $post["usuario"];
                                $imagen = $post["imagen"];

                                $fecha_formateada = strtotime($fecha);
                                $fecha_formateada = date("d/m/Y   h:i:s A", $fecha_formateada);

                                $sqlPost = "SELECT * FROM likes WHERE id_post = $id_post AND id_usuario = $id_usuario";
                                $queryPost = mysqli_query($conexion, $sqlPost);
                                if(!$queryPost) {
                                    echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
                                }
                                $cuentaLikes = mysqli_num_rows($queryPost);
                                

                                if($cuentaLikes == 0) {
                                    $mensajeBoton = "Me gusta";
                                } else {
                                    $esLike = mysqli_fetch_array($queryPost);
                                    if($esLike["es_like"] == 1) {
                                        $mensajeBoton = "Dejar de gustar";
                                    } else {
                                        $mensajeBoton = "Me gusta";
                                    }
                                }

                                $sqlCuentaLikes = "SELECT * FROM likes WHERE id_post = $id_post AND es_like = 1";
                                $queryCuentaLikes = mysqli_query($conexion, $sqlCuentaLikes);
                                if(!$queryCuentaLikes) {
                                    echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
                                }
                                $likes = mysqli_num_rows($queryCuentaLikes);
                                if($likes > 1) {
                                    $mensajeLike = "A $likes personas les gusta";
                                } else if ($likes == 1) {
                                    $mensajeLike = "A $likes persona le gusta";
                                } else {
                                    $mensajeLike = "Aun no ha recibido 'Me gusta'";
                                }

                                if( is_null($id_dibujo_post) ) {

                                    echo "<div class='publicacion'> 
                                            $usuario ";

                                    if($id_usuario_post != $id_usuario) {
                                        echo "<input type='submit' name='U' value='Ver perfil' 
                                        onmouseenter='cambiarOculto(this.name)' class='boton'>";
                                    }

                                    echo "  <br>
                                            $texto <br>
                                            <input type='submit' name='LIKE' value='$mensajeBoton' 
                                                onmouseenter='
                                                cambiarOculto(this.name); 
                                                var elem = document.getElementById(\"usuarioPost\");
                                                elem.value = \"$id_usuario_post\"; 
                                                console.log(elem.value);
                                            ' class='boton'>
                                            $mensajeLike <br>
                                            $fecha_formateada <br>
                                            <textarea id='comentario' name='comentario' cols='40' rows='3'></textarea> <br>
                                            <input type='submit' name='VC' value='Ver comentarios' 
                                            onmouseenter='cambiarOculto(this.name);' class='boton'>
                                            <input type='submit' name='C' value='Comentar' 
                                                onmouseenter='
                                                cambiarOculto(this.name); 
                                                var elem = document.getElementById(\"usuarioPost\");
                                                elem.value = \"$id_usuario_post\"; 
                                                console.log(elem.value);
                                            ' class='boton'> <br>
                                    </div>";

                                } else {

                                    echo "<div class='publicacion'> 
                                            $usuario ";

                                    if($id_usuario_post != $id_usuario) {
                                        echo "<input type='submit' name='U' value='Ver perfil' 
                                            onmouseenter='cambiarOculto(this.name)' class='boton'>";
                                    }

                                    echo "  <br>
                                            $texto <br>
                                            <img src='data:image/png; base64," . base64_encode($imagen) . "' /> <br>
                                            <input type='submit' name='LIKE' value='$mensajeBoton' 
                                                onmouseenter='
                                                cambiarOculto(this.name); 
                                                var elem = document.getElementById(\"usuarioPost\");
                                                elem.value = \"$id_usuario_post\"; 
                                                console.log(elem.value);
                                            ' class='boton'>
                                            $mensajeLike <br>
                                            $fecha_formateada <br>
                                            <textarea id='comentario' name='comentario' cols='40' rows='3'></textarea> <br>
                                            <input type='submit' name='VC' value='Ver comentarios' 
                                            onmouseenter='cambiarOculto(this.name)' class='boton'>
                                            <input type='submit' name='C' value='Comentar' 
                                                onmouseenter='
                                                cambiarOculto(this.name); 
                                                var elem = document.getElementById(\"usuarioPost\");
                                                elem.value = \"$id_usuario_post\"; 
                                                console.log(elem.value);
                                            ' class='boton'> <br>
                                    </div>";

                                }

                                echo "<br><br><br>";

                        } // fin if

                    } // fin if else

                ?>
                </form>
                <script>
                    function cambiarOculto(id) {

                        document.getElementById("seleccionado").value = id;
                        console.log(document.getElementById("seleccionado").value);
                        //var idSec = document.getElementById("seleccionado").value;
                        //var texto = document.getElementById(idSec + " Comm").value;
                        //document.getElementById("textoComentario").value = texto;
                        //console.log( document.getElementById("textoComentario").value );

                    }

                </script>

            </div>

        </div>

    </body>
</html>