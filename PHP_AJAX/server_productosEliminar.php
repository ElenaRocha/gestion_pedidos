<?php
    require 'server_sesiones.php';

    if(!comprobar_sesion()) return;

    $cod = $_POST["cod"];
    $unidades = (int)$_POST["unidades"];

    if(isset($_SESSION["carrito"][$cod])) {
        $_SESSION["carrito"][$cod] -= $unidades;

        if($_SESSION["carrito"][$cod] <= 0) {
            unset($_SESSION["carrito"][$cod]);
        }
    }
    echo $cod;
?>