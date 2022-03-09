<html>
    <head>

        <meta charset="UTF-8" />
        <title> Modificar Album </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>

        <div class="wrapper">

            <div id="encabezado">

                <?php
                    include "../encabezado.php";
                    include_once "../db.php";
                    $id_album = $_SESSION["id_album"];
                ?>
                <script src="../accionBotones.js"></script>

            </div>
            <br>
            <br>

            <div id="cuerpo">

                <form action="cambiarDatosAlbum.php" method="POST">
                <input type="hidden" name="id_album" value="<?php echo $id_album; ?>" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);
                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    $sql = "SELECT * FROM album WHERE id_usuario = $id AND id_album = $id_album AND activo = 1 ORDER BY fecha";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {
                        
                        $rowcount = mysqli_num_rows($query);

                        if($rowcount == 1) {

                            $album = mysqli_fetch_array($query);

                            $titulo = htmlspecialchars($album["titulo"]);
                            $descripcion = $album["descripcion"];
                            
                            //$id_album = $dibujo["id_album"];

                            /*
                            echo "$titulo <br>";
                            echo "Dimensión: $dimension px <br>";
                            echo "Publicado en: $fecha_formateada <br>";
                            echo "<img src='data:image/*; base64," . base64_encode($imagen) . "' /> <br><br>";
                            */

                        } else {

                            echo "No hay albumes";

                        } // fin if else

                    } // fin if else

                ?>

                    Titulo: <input type='text' name='txtTitulo' class="textfield" value="<?php echo $titulo; ?>" /> <br>
                    Descripción: <br>
                    <textarea name="descripcion" cols="40" rows="3"><?php echo $descripcion; ?></textarea> <br>
                    <input type="submit" class="boton" value="Realizar cambios">

                </form>

            </div>

        </div>

    </body>
</html>