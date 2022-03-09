<html>
    <head>

        <meta charset="UTF-8" />
        <title>Publicar Post</title>
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
                    
            <?php
        
                $id = $_SESSION["id"];
                $email = $_SESSION["email"];
                $nombre = $_SESSION["nombre"];
                $apellidos = $_SESSION["apellidos"];
                $usuario = $_SESSION["usuario"];
                $contrasena = $_SESSION["contrasena"];
                $genero = $_SESSION["genero"];
                $pais = $_SESSION["pais"];
                $imagen = $_SESSION["imagen"];
        
            ?>
            <br>
            <br>
        
            <div id="cuerpo">

                <form action="publicarPost.php" method="POST">
                    <input type="hidden" id="id_dibujo" name="id_dibujo" value="default" />
                    Estado: <br>
                    <textarea name="texto" cols="40" rows="3"></textarea> <br>
                    Dibujo: <select name="dibujo" class="textfield" style="width: 150px" 
                            onchange="document.getElementById('id_dibujo').value = this.value; 
                            console.log(document.getElementById('id_dibujo').value)">
                            <option value="default" selected> Selecciona
                            <?php
                            
                            $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                            if(!$conexion) {
                        
                                echo "No se pudo conectar al servidor...";
                                die();
                        
                            } // fin if
                        
                            $id_usuario = $_SESSION["id"];
                            $sql = "SELECT id_dibujo, titulo FROM dibujo WHERE id_usuario = $id_usuario AND activo = 1";
                            $query = mysqli_query($conexion, $sql);
                        
                            if(!$query) {
                        
                                echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);
                        
                            } else {
                        
                                $rowcount = mysqli_num_rows($query);
                        
                                if($rowcount > 0) {
                        
                                    while($dibujo = mysqli_fetch_array($query)) {

                                        $id_dibujo = $dibujo["id_dibujo"];
                                        $titulo = $dibujo["titulo"];
                                        echo "<option value='$id_dibujo'> $titulo \n";

                                    } // fin while
                        
                                } // fin if
                        
                            } // fin if else

                            ?>
                    </select> <br>
                    <br>
                    <br>
                    <input type="submit" class="boton" value="Publicar" />
                </form>
        
            </div>
        
        </div>

    </body>
</html>