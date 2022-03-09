<html>
    <head>

        <meta charset="UTF-8" />
        <title>Crear Album</title>
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

                <form action="registrarAlbum.php" method="POST">
                    Título: <input type="text" name="titulo" class="textfield" /> <br>
                    Descripción: <br>
                    <textarea name="descripcion" cols="40" rows="3"></textarea> <br>
                    <input type="submit" class="boton" value="Crear" />
                </form>
        
            </div>
        
        </div>

    </body>
</html>