<?php

    include_once "../db.php";

    if( isset( $_POST["oculto"] ) ) {

        session_start();
        $id_seleccionado = $_POST["oculto"];
        $_SESSION["perfil_seleccionado"] = $id_seleccionado;
        //echo $_SESSION["perfil_seleccionado"] . "<br>";

        header("Location: verPerfilExterno.php");

    }

?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title> Busqueda </title>
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
            <br>
            <br>

            <div id="cuerpo">

                <form action="#" method="POST">
                <input type="hidden" id="oculto" name="oculto" value="" />
                <?php

                    $conexion = mysqli_connect($HOST, $USER, $PASSWORD, $DB);

                    if(!$conexion) {

                        echo "No se pudo conectar al servidor...";
                        die();

                    } // fin if

                    $id = $_SESSION["id"];
                    $busqueda = mysqli_real_escape_string($conexion, $_SESSION["busqueda"]);
                    //echo ($busqueda == "") ? "vacio <br>" : ($busqueda . "<br>");

                    $sql = "SELECT * FROM usuario WHERE id_usuario <> $id AND usuario LIKE '$busqueda%'";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount > 0) {

                            $i = 0;
                            while($usuario = mysqli_fetch_array($query)) {

                                $u_id = $usuario["id_usuario"];
                                $u_usuario = $usuario["usuario"];
                                $u_imagen = $usuario["imagen"];

                                echo "$u_usuario <br>";
                                echo "<img src='data:image/*; base64," . base64_encode($u_imagen) . "' width='200' /> <br>";
                                /*
                                echo "<input type='submit' id='$i' name='$i' value='Eliminar Dibujo' 
                                onmouseenter='cambiarOcultoDos(this.name); 
                                    cambiarOculto(document.getElementById(\"" . $id_dibujo . "\").name);' /> <br><br>";
                                */
                                echo "<input type='submit' name='$u_id' value='Ver Perfil' 
                                onmouseenter='cambiarOculto(this.name)' class='boton'> <br>";
                                echo "<br><br><br>";
                                $i++;

                            }

                        } else {

                            echo "No se encuentran usuarios";

                        } // fin if else

                    } // fin if else

                ?>
                </form>
                <script>
                    function cambiarOculto(id) {

                        var elemento = document.getElementById("oculto").value = id;
                        console.log(elemento);

                    }
                </script>

            </div>

        </div>

    </body>
</html>