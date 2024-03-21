<?php
    function obtenerConexion() {
        $password = 'Web';
        $user = 'userapps';
        $dbName = 'Web';
        $database = new PDO('mysql:host=localhost;dbname=' . $dbName, $user, $password);
        $database->query("set names utf8;");
        $database->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        $database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $database;
    }

    function comprobar_usuario($email, $clave){
        $bd = obtenerConexion();
        $res = $bd->prepare("SELECT tienda_id, email FROM tiendas WHERE email = ? AND pw = ?");
        $res->execute([$email, $clave]);
        $bd = null;
        return $res->fetchAll();
    }

    function cargar_categorias(){
        $bd = obtenerConexion();
        $res = $bd->prepare("SELECT categoria_id, nombre FROM categorias ORDER BY categoria_id");
        $res->execute();
        if(!$res){
            return FALSE;
        }
        return $res;
    }

    function cargar_categoria($categoria){
        $bd = obtenerConexion();
        $res = $bd->prepare("SELECT nombre, descripcion FROM categorias WHERE categoria_id = ?");
        $res->execute(([$categoria]));
        if(!$res){
            return FALSE;
        }
        return $res;
    }

    function cargar_productos_categoria($categoria){
        $bd = obtenerConexion();
        $res = $bd->prepare("SELECT producto_id, nombre, descripcion, categoria_id, stock FROM productos WHERE categoria_id = ?");
        $res->execute([$categoria]);
        if(!$res){
            return FALSE;
        }
        return $res;
    }

    function cargar_productos($productos){
        if(empty($productos)){
            return FALSE;
        }
        $bd = obtenerConexion();
        $numParametros = implode(',', array_fill(0, count($productos), '?'));
        $res = $bd->prepare("SELECT producto_id, nombre, descripcion, categoria_id, stock FROM productos WHERE producto_id IN ($numParametros");
        $res->execute($productos);
        if(empty($res)){
            return FALSE;
        }
        return $res;
    }

    function insertar_pedido($carrito, $tienda_id){
        $bd = obtenerConexion();
        $bd->beginTransaction();
        $sql = "INSERT INTO pedidos SET tienda_id = ?, fecha = NOW(), enviado = FALSE";
        $res = $bd->prepare($sql);
        $res->execute([$tienda_id]);
        $sql2 = "SELECT MAX(pedido_id) pedido_id FROM pedidos";
        $res = $bd->query($sql2);
        $ped = 0;
        foreach($res as $row){
            $ped = $row->pedido_id;
        }
        foreach($carrito as $producto_id=>$cantidad){
            $sql = "INSERT INTO pedidos_productos SET pedido_id = $ped, producto_id = $producto_id, cantidad = $cantidad";
            $res = $bd->query($sql);
            if(empty($res)){
                $bd->rollback();
                return FALSE;
            }
            $sql2 = "UPDATE productos SET stock = stock - $cantidad WHERE producto_id = $producto_id";
            $res = $bd->query($sql2);
            if(empty($res)){
                $bd->rollback();
                return FALSE;
            }
        }
        $bd->commit();
        return $ped;
    }
?>