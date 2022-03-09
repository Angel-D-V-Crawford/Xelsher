<?php

    include_once "../db.php";

    if( isset( $_POST["oculto"] ) ) {

        session_start();
        $id_seleccionado = $_POST["oculto"];
        $_SESSION["perfil_seleccionado"] = $id_seleccionado;

        header("Location: verPerfilExterno.php");

    }

?>

<html>
    <head>

        <meta charset="UTF-8" />
        <title> Amigos </title>
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

                    $sql = "SELECT * FROM amistad 
                    INNER JOIN usuario ON ( (amistad.id_solicitador = usuario.id_usuario) OR (amistad.id_receptor = usuario.id_usuario) )
                    WHERE ( (id_solicitador = $id) OR (id_receptor = $id) ) AND usuario.id_usuario <> $id 
                    AND son_amigos = 1 ORDER BY usuario.usuario";
                    $query = mysqli_query($conexion, $sql);
                    if(!$query) {

                        echo "Hubo un fallo en la consulta: " . mysqli_error($conexion);

                    } else {

                        $rowcount = mysqli_num_rows($query);

                        if($rowcount > 0) {

                            $i = 0;
                            while($amigo = mysqli_fetch_array($query)) {

                                $amigo_id = $amigo["id_usuario"];
                                $amigo_usuario = $amigo["usuario"];
                                $amigo_imagen = $amigo["imagen"];

                                echo "$amigo_usuario <br>";
                                echo "<img src='data:image/*; base64," . base64_encode($amigo_imagen) . "' width='200' /> <br>";
                                /*
                                echo "<input type='submit' id='$i' name='$i' value='Eliminar Dibujo' 
                                onmouseenter='cambiarOcultoDos(this.name); 
                                    cambiarOculto(document.getElementById(\"" . $id_dibujo . "\").name);' /> <br><br>";
                                */
                                echo "<input type='submit' name='$amigo_id' value='Ver Perfil' 
                                onmouseenter='cambiarOculto(this.name)' class='boton'> <br>";
                                echo "<br><br><br>";
                                $i++;

                            }

                        } else {

                            echo "No tienes amigos";

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