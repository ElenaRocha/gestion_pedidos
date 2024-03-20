<?php
    require_once 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Pedido en curso</title>
    </head>
    <body>
        <?php
        require 'cabecera.php';
        echo "<h3>Pedido en curso</h3>";
        $productos = cargar_productos(array_keys($_SESSION['carrito']));
        if($productos === FALSE){
            echo "<p>No hay productos en el pedido</p>";
            exit;
        }
        echo "<table>";
        echo "<tr><th>Nombre</th><th>Descripción</th><th>Cantidad</th><th>Eliminar</th>";
        foreach($productos as $row){
            $producto_id = $row->producto_id;
            $nombre = $row->nombre;
            $descripcion = $row->descripcion;
            $cantidad = $_SESSION['carrito'][$producto_id];
            echo "<tr><td>$nombre</td><td>$descripcion</td><td>$cantidad</td>
                    <td>
                        <form action = 'eliminar.php' method = 'POST'>
                            <input name = 'cantidad.php' method = 'POST'>
                            <input type = 'submit' value = 'Eliminar'>
                            <input name = 'producto_id' type = 'hidden' value = '$producto_id'>
                        </form>
                    </td>
                </tr>";
        }
        echo "</t<ble>";
        ?>
        <hr>
        <a href="procesar.php">Confirmar pedido</a>
    </body>
</html>