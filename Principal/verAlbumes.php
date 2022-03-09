<html>
    <head>

        <meta charset="UTF-8" />
        <title> Albumes </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>

        <div class="wrapper">

            <div id="encabezado">

                <?php
                    include "../encabezado.php";
                    include_once "../db.php";
                ?>
                <script src="../accionBotones.js"></script>

            </div>
            <br>
            <br>

            <div id="cuerpo">

                <form action="modificar_eliminar_album.php" method="POST">
                <input type="hidden" id="oculto" name="oculto" value="" />
                <input type="hidden" id="ocultoDos" name="ocultoDos" value="" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    $sql = "SELECT * FROM album WHERE id_usuario = $id AND activo = 1 ORDER BY fecha";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount > 0) {

                            $i = 0;
                            while($album = mysqli_fetch_array($query)) {

                                $id_album = $album["id_album"];
                                $titulo = $album["titulo"];
                                $descripcion = $album["descripcion"];
                                $fecha = $album["fecha"];

                                $fecha_formateada = strtotime($fecha);
                                $fecha_formateada = date("d/m/Y   h:i:s A", $fecha_formateada);

                                echo "$titulo <br>";
                                echo "$descripcion <br>";
                                echo "Publicado en: $fecha_formateada <br>";
                                /*
                                echo "<img src='data:image/png; base64," . base64_encode($imagen) . "' /> <br>";
                                echo "<a href='data:image/png; base64," . base64_encode($imagen) . "' download='$id_dibujo - $titulo'>
                                Descargar</a>";
                                */
                                echo "<input type='submit' id='$id_album' name='$id_album' value='Ver Album' 
                                onmouseenter='cambiarOculto(this.name)' class='boton' style='width: 200px' /><br>";
                                echo "<input type='submit' id='$id_album M' name='$id_album M' value='Modificar info de Album' 
                                onmouseenter='cambiarOculto(this.name)' class='boton' style='width: 200px' /><br>";
                                echo "<input type='submit' id='$id_album E' name='$id_album E' value='Eliminar Album' 
                                onmouseenter='cambiarOculto(this.name)' class='boton' style='width: 200px' /> <br><br>";
                                /*
                                echo "<input type='submit' id='$i' name='$i' value='Eliminar Album' 
                                onmouseenter='cambiarOcultoDos(this.name); 
                                    cambiarOculto(document.getElementById(\"" . $id_album . "\").name);' /> <br><br>";
                                */
                                $i++;

                            }

                        } else {

                            echo "No hay albumes";

                        } // fin if else

                    } // fin if else

                ?>
                </form>
                <script>
                    function cambiarOculto(id) {

                        var elemento = document.getElementById("oculto").value = id;
                        console.log(elemento);

                    }

                    function cambiarOcultoDos(i) {

                        var elemento = document.getElementById("ocultoDos").value = i;
                        console.log(elemento);

                    }
                </script>

            </div>

        </div>

    </body>
</html>