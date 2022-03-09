<?php

    session_start();

    $id_album = $_POST["oculto"];

    $id_album = explode( ' ', $id_album );
    $id_album_tmp = $id_album[0];

    $_SESSION["id_album"] = $id_album_tmp;
    
    echo $_POST["oculto"];

    if( strcmp($_POST["oculto"], "$id_album_tmp M") == 0 ) {

        echo "Match";
        header("Location: modificarAlbum.php");

    } else if( strcmp($_POST["oculto"], "$id_album_tmp E") == 0  ) {

        header("Location: eliminarAlbum.php");

    } else if( isset($_POST["$id_album_tmp"]) ){

        header("Location: verAlbumDibujos.php");

    }

?>