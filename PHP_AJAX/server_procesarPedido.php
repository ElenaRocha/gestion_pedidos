<?php
    require_once 'bd.php';
    require 'server_sesiones.php';

    if(!comprobar_sesion()) return;

    $result = insertar_pedido($_SESSION["carrito"], $_SESSIN["usuario"]->tienda_id);
    if($resultado === false) {
        echo "FALSE";
    } else {
        $_SESSION["carrito"] = [];
        echo "TRUE";
    }
?>