<html>
    <head>

        <meta charset="UTF-8" />
        <title> Ver Album </title>
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

                <form action="quitarDibujoAlbum.php" method="POST">
                <input type="hidden" id="oculto" name="oculto" value="" />
                <input type="hidden" id="ocultoDos" name="ocultoDos" value="" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    $id_album = $_SESSION["id_album"];

                    $sql = "SELECT * FROM dibujo WHERE id_usuario = $id AND id_album = $id_album AND activo = 1 ORDER BY fecha DESC";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount > 0) {

                            $i = 0;
                            while($dibujo = mysqli_fetch_array($query)) {

                                $id_dibujo = $dibujo["id_dibujo"];
                                $titulo = $dibujo["titulo"];
                                $dimension = $dibujo["dimension"];
                                $imagen = $dibujo["imagen"];
                                $id_album = $dibujo["id_album"];
                                $fecha = $dibujo["fecha"];

                                $fecha_formateada = strtotime($fecha);
                                $fecha_formateada = date("d/m/Y   h:i:s A", $fecha_formateada);

                                echo "$titulo <br>";
                                echo "Dimensión: $dimension px <br>";
                                echo "Publicado en: $fecha_formateada <br>";
                                echo "<img src='data:image/png; base64," . base64_encode($imagen) . "' /> <br>";
                                echo "<a href='data:image/png; base64," . base64_encode($imagen) . "' download='$id_dibujo - $titulo'>
                                Descargar</a>";
                                echo "<input type='submit' id='$id_dibujo' name='$id_dibujo' value='Quitar de album' 
                                onmouseenter='cambiarOculto(this.name)' class='boton' /> <br><br>";
                                $i++;

                            }

                        } else {

                            echo "No hay dibujos";

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