<?php
    require_once 'bd.php';
    require 'server_sesiones.php';

    if(!comprobar_sesion()) return;

    $prodcutos = cargar_productos_categoria($_GET['categoria']);
    $productos_json = json_encode(iterator_to_array($productos));
    echo $productos_json;
?>