<html>
    <head>

        <meta charset="UTF-8" />
        <title>Modificar Perfil</title>
        <link rel="stylesheet" type="text/css" href="../css/style.css">

    </head>
    <body>

        <div id="encabezado">

            <?php
                include "../encabezado.php";
            ?>
            <script src="../accionBotones.js"></script>
    
        </div>
        <br>
        <br>

        <form action="cambiarDatosPerfil.php" method="POST" enctype="multipart/form-data">
            E-Mail: <input type="email" name="email" class="textfield" value='<?php echo $_SESSION["email"]; ?>' /> <br>
            Nombre: <input type="text" name="nombre" class="textfield" value='<?php echo $_SESSION["nombre"]; ?>' /> <br>
            Apellidos: <input type="text" name="apellidos" class="textfield" value='<?php echo $_SESSION["apellidos"]; ?>' /> <br>
            Usuario: <input type="text" name="usuario" class="textfield" value='<?php echo $_SESSION["usuario"]; ?>' /> <br>
            Contraseña: <input type="password" name="contra" class="textfield" value='<?php echo $_SESSION["contrasena"]; ?>' /> <br>
            Género: <?php 
            echo "<input type='radio' name='genero' value='Hombre' ";
            if($_SESSION["genero"] == "Hombre") {
                echo "checked ";
            }
            echo "/> Hombre   ";

            echo "<input type='radio' name='genero' value='Mujer' ";
            if($_SESSION["genero"] == "Mujer") {
                echo "checked ";
            }
            echo "/> Mujer ";
            ?> <br>
            País: <input type="text" name="pais" class="textfield" value='<?php echo $_SESSION["pais"]; ?>' /> <br>
            Imagen: <input type="file" id="archivos" name="file_imagen" accept="image/*" onchange="abrirArchivo();" />  Max: 16 MB <br>
            <?php echo "<img id='imagen' src='data:image/*; base64," . base64_encode($_SESSION["imagen"]) . "' width='200' />" ?> <br>
            <br>
            <input type="submit" class="boton" value="Cambiar Datos" /> 
        </form>
        <script src="scriptModificar.js"></script>

    </body>
</html>