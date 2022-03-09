<html>
    <head>

        <meta charset="UTF-8" />
        <title> Dibujos </title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>

        <div class="wrapper">

            <div id="encabezado">

                <?php
                    include "../encabezado.php";
                    include_once "../db.php";
                    $id_dibujo = $_SESSION["id_dibujo"];
                ?>
                <script src="../accionBotones.js"></script>

            </div>
            <br>
            <br>

            <div id="cuerpo">

                <form action="cambiarDatosDibujo.php" method="POST">
                <input type="hidden" name="id_dibujo" value="<?php echo $id_dibujo; ?>" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);
                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    $sql = "SELECT * FROM dibujo WHERE id_usuario = $id AND id_dibujo = $id_dibujo AND activo = 1 ORDER BY fecha";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {
                        
                        $rowcount = mysqli_num_rows($query);

                        if($rowcount == 1) {

                            $dibujo = mysqli_fetch_array($query);

                            $titulo = htmlspecialchars($dibujo["titulo"]);
                            //$dimension = $dibujo["dimension"];
                            $imagen = $dibujo["imagen"];
                            $id_album = $dibujo["id_album"];
                            //$fecha = $dibujo["fecha"];

                            //$fecha_formateada = strtotime($fecha);
                            //$fecha_formateada = date("d/m/Y   h:i:s A", $fecha_formateada);

                            /*
                            echo "$titulo <br>";
                            echo "Dimensión: $dimension px <br>";
                            echo "Publicado en: $fecha_formateada <br>";
                            echo "<img src='data:image/*; base64," . base64_encode($imagen) . "' /> <br><br>";
                            */

                        } else {

                            echo "No hay dibujos";

                        } // fin if else

                    } // fin if else

                ?>

                    Titulo: <input type='text' name='txtTitulo' class="textfield" value="<?php echo $titulo; ?>" /> <br>
                    Album: <select name="album" class="textfield" style="width: 150px" 
                            onchange="document.getElementById('texto_seleccionado').value = this.options[this.selectedIndex].text; 
                            console.log(document.getElementById('texto_seleccionado').value); console.log(this.value)">
                            <option value="default" selected> Selecciona
                            <?php
                            
                            $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                            if(!$conexion) {
                        
                                echo "No se pudo conectar al servidor...";
                                die();
                        
                            } // fin if
                        
                            $id_usuario = $_SESSION["id"];
                            $sql = "SELECT id_album, titulo FROM album WHERE id_usuario = $id_usuario AND activo = 1";
                            $query = mysqli_query($conexion, $sql);
                        
                            if(!$query) {
                        
                                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
                        
                            } else {
                        
                                $rowcount = mysqli_num_rows($query);
                        
                                if($rowcount > 0) {
                        
                                    while($album = mysqli_fetch_array($query)) {

                                        $id_album = $album["id_album"];
                                        $titulo_album = $album["titulo"];
                                        echo "<option value='$id_album'> $titulo_album \n";

                                    } // fin while
                        
                                } // fin if
                        
                            } // fin if else

                            ?>
                    </select> <br>
                    <img src="data:image/png; base64,<?php echo base64_encode($imagen); ?>" /> <br>
                    <input type="hidden" id="texto_seleccionado" name="texto_seleccionado" value="">
                    <input type="submit" class="boton" value="Realizar cambios">

                </form>

            </div>

        </div>

    </body>
</html>