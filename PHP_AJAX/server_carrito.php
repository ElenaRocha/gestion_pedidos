<?php
    require_once 'bd.php';
    require 'server_sesiones.php';

    if(!comprobar_sesion()) return;

    $productos = cargar_productos(array_keys($_SESSION["carrito"]));
    $productos = iterator_to_array($productos);
    foreach($productos as $producto) {
        $cod = $producto->producto_id;
        $producto->unidades = $_SESSION["carrito"][$cod];
    }

    echo json_encode($productos);
?>