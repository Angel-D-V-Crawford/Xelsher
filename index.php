<?php

    if(session_status() === PHP_SESSION_ACTIVE) {

        header("Location: ./Principal/principal.php");

    } else {

        header("Location: ./Login/login.html");

    }

?>