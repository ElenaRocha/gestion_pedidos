<?php
require 'sesiones.php';
require_once 'bd.php';
comprobar_sesion();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Categorías de productos</title>
    </head>
    <body>
        <?php require 'cabecera.php';?>
        <h1>Tipos de producto</h1>
        <?php
        $categorias = cargar_categorias();
        if($categorias == FALSE) {
            echo "<p class='error'>Error de conexión con la base de datos</p>";
        }else{
            echo "<ul>";
            foreach($categorias as $row) {
                $url = "productos.php?categorias=" .$row->categorias_id;
                echo "<li><a href='$url'>" .$row->nombre."</a></li>";
            }
            echo "</ul>";
        }
        ?>
    </body>
</html>