<?php
    require 'sesiones.php';
    comprobar:sesion();
    $producto_id = $_POST['producto_id'];
    $cantidad = (int)$_POST['cantidad'];
    if(isset($_SESSION['carrito'][$producto_id])) {
        $_SESSION['carrito'][$producto_id] += $cantidad;
    }else{
        $_SESSION['carrito'][$producto_id] = $cantidad;
    }
    header("Location: carrito.php");
?>