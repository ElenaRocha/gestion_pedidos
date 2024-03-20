<?php
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Pedidos</title>
    </head>
    <body>
        <?php
        require 'cabecera.php';
        $res = insertar_pedido($_SESSION['carrito'], $_SESSION['tienda_id']);
        if(!$res){
            echo "Error al procesar el pedido";
        }else{
            echo "Pedido realizado con exito";
            // TODO: enviar email de confirmación
            $_SESSION['carrito'] = [];
        }
        ?>
    </body>
</html>