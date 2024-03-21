<?php
    require_once 'bd.php';
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $user = comprobar_usuario($_POST["usuario"], $_POST["clave"]);

        if($user === false) {
            echo "FALSE";
        } else {
            session_start();
            $_SESSION["usurio"] = $user[0]; //comprobar_usuario devuelve un array de uduarios
            $_SESSION["carrito"] = [];
            $usuario_json = json_encode($user);
            echo $usuario_json;
        }
    }
?>