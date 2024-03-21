<?php
    require_once 'bd.php';
    require 'server_sesiones.php';

    if(!comprobar_sesion()) return;
    $categorias = cargar_categprias();
    $categorias_json = json_encode(iterator_to_array($categorias));
    echo $categorias_json;
?>