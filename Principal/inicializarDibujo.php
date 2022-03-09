<?php

    if( isset( $_POST["crear"] ) ) {

        if( isset( $_POST["dimension"] ) ) {

            if( $_POST["dimension"] != "" && $_POST["dimension"] != "0" ) {
    
                session_start();
                $_SESSION["dibujo_dimension"] = $_POST["dimension"];
                $_SESSION["dibujo_titulo"] = htmlspecialchars($_POST["titulo"]);
    
                header("Location: ../Pintar/dibujo.php");
    
            } else {
    
                echo "Dimensión no puede dejarse en 0 o vacio <br><br>";
    
            }
    
        } else {
    
            echo "Dimensión no puede dejarse vacio <br><br>";
    
        }

    }

?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title>Crear Dibujo</title>
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

                <form action="#" method="POST">
                    Dimensión (px): <input type="number" name="dimension" min="100" max="500" value="300" class="boton" /> <br>
                    Título: <input type="text" name="titulo" class="textfield" /> <br>
                    <input type="submit" name='crear' value="Crear" class="boton" />
                </form>
        
            </div>
        
        </div>

    </body>
</html>