<html>
    <head>

        <meta charset="UTF-8" />
        <title><?php session_start(); echo $_SESSION["usuario"]; ?></title>
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

                <?php

                    echo "ID: $id <br>";
                    echo "E-Mail: $email <br>";
                    echo "Nombre: $nombre <br>";
                    echo "Apellidos: $apellidos <br>";
                    echo "Usuario: $usuario <br>";
                    echo "Género: $genero <br>";
                    echo "País: $pais <br><br>";

                    echo "Foto de perfil: <br>";
                    echo "<img src='data:image/*; base64," . base64_encode($imagen) . "' width='200' />";

                ?>
                <br>
                <br>
                <input type="button" name="btnModificar" value="Modificar Perfil" class="boton" onclick="window.location.href = 'modificarPerfil.php'">
                <br>
                <br>
                <br>

            </div>

        </div>

    </body>
</html>