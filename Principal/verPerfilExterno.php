<?php

    include_once "../db.php";

    session_start();
    $id_perfil = $_SESSION["perfil_seleccionado"];

    $candado = false;

    if( isset( $_POST["btnVerPosts"] ) ) {

        header("Location: verPostsExterno.php");

    } else if( isset( $_POST["btnVerDibujos"] ) ) {

        header("Location: verDibujosExterno.php");

    } else if( isset( $_POST["btnVerAlbumes"] ) ) {

        header("Location: verAlbumExterno.php");

    }

    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

    if(!$conexion) {

        echo "No se pudo conectar al servidor...";
        die();

    } // fin if

    $id = $_SESSION["id"];
    //$busqueda = $_SESSION["busqueda"];

    $sqlAmigos = "SELECT * FROM amistad WHERE (id_solicitador = $id OR id_receptor = $id) 
        AND (id_solicitador = $id_perfil OR id_receptor = $id_perfil)";
    $queryAmigos = mysqli_query($conexion, $sqlAmigos);
    if(!$queryAmigos) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

    } else {

        $filas = mysqli_num_rows($queryAmigos);
        $mensajeSubmit = "";
        $nuevaSolicitud = false;
        $eliminarAmistad = false;

        if($filas > 0) {

            $amistad = mysqli_fetch_array($queryAmigos);

            if( strcmp($amistad["son_amigos"], "1")  == 0 ) {

                $mensajeSubmit = "Eliminar de mis amigos";
                $eliminarAmistad = true;

            } else {

                $mensajeSubmit = "Añadir a Amigos";

            }

        } else {

            $mensajeSubmit = "Añadir a Amigos";
            $nuevaSolicitud = true;                           
                                
        }

    }

    $sql = "SELECT * FROM usuario WHERE id_usuario = $id_perfil";
    $query = mysqli_query($conexion, $sql);
    if(!$query) {

        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

    } else {

        $rowcount = mysqli_num_rows($query);

        if($rowcount == 1) {

            $usuario = mysqli_fetch_array($query);

            /*
                $id = $_SESSION["id"];
                $email = $_SESSION["email"];
                $nombre = $_SESSION["nombre"];
                $apellidos = $_SESSION["apellidos"];
                $usuario = $_SESSION["usuario"];
                $contrasena = $_SESSION["contrasena"];
                $genero = $_SESSION["genero"];
                $pais = $_SESSION["pais"];
                $imagen = $_SESSION["imagen"];
            */

            $u_id = $usuario["id_usuario"];
            $u_email = $usuario["email"];
            $u_nombre = $usuario["nombre"];
            $u_apellidos = $usuario["apellidos"];
            $u_usuario = $usuario["usuario"];
            $u_genero = $usuario["genero"];
            $u_pais = $usuario["pais"];
            $u_imagen = $usuario["imagen"];

        } else {

            echo "No se pudieron extraer los datos del usuario";

        } // fin if else

    }

    if( isset( $_POST["btnAmistad"] ) ) {

        date_default_timezone_set("America/Mazatlan");
        $fecha = date("Y-m-d H:i:s");
        
        $insertarNotificacion = false;

        if($nuevaSolicitud) {

            $miUsuario = mysqli_real_escape_string($conexion, $_SESSION["usuario"]);
            $sqlAmistad = "INSERT INTO amistad(id_solicitador, id_receptor, fecha, son_amigos) 
                VALUES($id, $id_perfil, '$fecha', 1)";
            $sqlNotificacion = "INSERT INTO notificacion(id_usuario, descripcion, fecha) 
            VALUES ($id_perfil, '$miUsuario y tu ahora son amigos!', '$fecha')";
            $insertarNotificacion = true;
            $mensajeSubmit = "Eliminar de mis amigos";

        } else if($eliminarAmistad) {

            $sqlAmistad = "UPDATE amistad 
            SET son_amigos = 0, fecha = '$fecha' 
            WHERE (id_solicitador = $id OR id_receptor = $id) AND (id_solicitador = $id_perfil OR id_receptor = $id_perfil)";
            $mensajeSubmit = "Añadir a Amigos";

        } else {

            $sqlAmistad = "UPDATE amistad 
            SET son_amigos = 1, fecha = '$fecha' 
            WHERE (id_solicitador = $id OR id_receptor = $id) AND (id_solicitador = $id_perfil OR id_receptor = $id_perfil)";
            $mensajeSubmit = "Eliminar de mis amigos";

        }

        $queryAmistad = mysqli_query($conexion, $sqlAmistad);
        if(!$queryAmistad) {

            echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

        } else if($insertarNotificacion) {

            $queryNotificacion = mysqli_query($conexion, $sqlNotificacion);
            if(!$queryNotificacion) {

                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

            }

        }

    } // fin if btnAmistad
    

?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title><?php echo $u_nombre; ?></title>
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

                <?php

                    echo "ID: $u_id <br>";
                    echo "E-Mail: $u_email <br>";
                    echo "Nombre: $u_nombre <br>";
                    echo "Apellidos: $u_apellidos <br>";
                    echo "Usuario: $u_usuario <br>";
                    echo "Género: $u_genero <br>";
                    echo "País: $u_pais <br><br>";

                    echo "Foto de perfil: <br>";
                    echo "<img src='data:image/*; base64," . base64_encode($u_imagen) . "' width='200' />";

                ?>
                <br>
                <br>

                <form action="#" method="POST"> 

                    <?php

                    ?>

                    <input type="submit" name="btnAmistad" class="boton" style="width: 200px" value="<?php echo $mensajeSubmit; ?>"> <br><br>
                    <input type="submit" name="btnVerPosts" class="boton" value="Ver Posts">
                    <input type="submit" name="btnVerDibujos" class="boton" value="Ver Dibujos">
                    <input type="submit" name="btnVerAlbumes" class="boton" value="Ver Albumes">
                </form>

            </div>

        </div>

    </body>
</html>