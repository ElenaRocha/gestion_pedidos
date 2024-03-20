<?php
    require 'sesiones.php';
    require_once 'bd.php';
    comprobar_sesion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Productos por categorías</title>
    </head>
    <body>
        <?php
        require 'cabecera.php';
        $cat = cargar_categoria($_GET['categoria']);
        $productos = cargar_productos_categoria($_GET['categoria']);
        if($cat === FALSE or $productos === FALSE){
            echo "<p class='error'>Error al conetar</p>";
        }else{
            foreach($cat as $row){
                echo "<h2>Categorías: " .$row->nombre . "</h2>";
                echo "<h3>" .$row->descripcion . "</h3>";
            }
            echo "<table>";
            echo "<tr><th>Nombre</th><th>Descripción</th>" . "<th>Stock</th><th>Compra</th>";
            foreach($productos as $row){
                $producto_id = $row->producto_id;
                $nombre = $row->nombre;
                $descripcion = $row->descripcion;
                $stock = $row->stock;
                echo "<tr><td>$nombre</td><td>$descripcion</td><td>$stock>
                    <td>
                        <form action = 'anadir.php' method = 'POST'>
                            <input name = 'cantidad' type = 'number' min = '1' value = '1'>
                            <input type = 'submit' value = 'Añadir al pedido'>
                            <input name = 'producto_id' type = 'hiden' value = '$producto_id'>
                        </form> 
                    </td>
                </tr>"
            }
        }
        ?>
    </body>
</html>