<?php

    include_once "../db.php";
    session_start();

    $dibujo_dimension = $_SESSION["dibujo_dimension"];
    $dibujo_titulo = $_SESSION["dibujo_titulo"];

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="style.css" />
        <title> Dibujo </title>
    </head>
    <body>
        <div class="wrapper">
            <div id="encabezado">

                <?php
                    echo $_SESSION["usuario"] . "<br>";
                ?>
                <input type="button" id="btnRegresar" value="Principal" class="boton" onclick="window.location.href = '../Principal/principal.php'">
                <form id="formBuscar" action="../Principal/almacenarBusqueda.php" method="POST">
                    <input type='hidden' id='txtBuscar' name='txtBuscar' value=''>
                    <input type="search" id="buscar" name="buscar" class="textfield"  placeholder="Buscar...">
                    <input type="submit" class="boton" value="Buscar">
                </form>
                <!--
                <input type="button" name="btnCerrar" value="Cerrar Sesión" onclick="cerrar()">
                -->
                <script src="../accionBotones.js" type="text/javascript"></script>
                
            </div>
            <div id="opciones" style="text-align: center;">
                <form action="publicar.php" method="POST">
                    Titulo: <input type="text" name="titulo" class="textfield" 
                    style="width: 150px" value="<?php echo $dibujo_titulo ?>" />
                    Album: <select name="album" class="textfield" style="width: 150px" 
                            onchange="document.getElementById('texto_seleccionado').value = this.options[this.selectedIndex].text; 
                            console.log(document.getElementById('texto_seleccionado').value)">
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
                    </select>
                    <label id="modo">Modo: Pincel</label>
                    <input type="button" value="Pincel" class="boton" 
                    style="width: 65px" onclick="cambiarModoDibujo(this);" />
                    <input type="button" value="Borrador" class="boton" 
                    style="width: 75px" onclick="cambiarModoDibujo(this);" />
                    <input type="color" id="colores" class="boton" style="height: 25px" />
                    <label for="checkGrid"><input type="checkbox" id="checkGrid" onchange="cambiarGrid(this);" />Ver Grid</label>
                    <input type="file" id="archivos" accept="image/*" onchange="abrirArchivo();" />  Max: 64 KB
                    <a id="descarga">Descargar</a>
                    <input type="hidden" id="texto_seleccionado" name="texto_seleccionado" value="">
                    <input type='hidden' id='oculto' name='imagen_blob'>
                    <input type="hidden" name="dimension" value="<?php echo $dibujo_dimension ?>">
                    <input type="submit" class="boton" style="width: 75px" value="Publicar">
                </form>
            </div>
        <br>
        <div id="lienzos">
            <?php
                echo "<canvas id='lienzo' width='$dibujo_dimension' height='$dibujo_dimension'></canvas>";
                echo "<canvas id='capaGrid' width='$dibujo_dimension' height='$dibujo_dimension'></canvas>";
            ?>
        </div>
        <script>
                var busqueda = document.getElementById("buscar");
        
                busqueda.addEventListener("keypress", function(event) {
                    // 13 = "Enter"
                    if (event.keyCode === 13) {
                        event.preventDefault();
        
                        //Programar acción
        
                    }
                });
        
                function cerrar() {
        
                    window.location.href = "../Principal/cerrarSesion.php";
        
                }
        
                function volver() {
                            
                    window.location.href = "../Principal/principal.php";
        
                }
        
                function verPerfil() {
        
                    window.location.href = "../Principal/verPerfil.php";
        
                }
                
            </script>
        </div>
        <script src="lienzo.js"></script>
    </body>
</html>