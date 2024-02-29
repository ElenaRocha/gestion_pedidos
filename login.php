<?php
require_once 'bd.php';
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $u = comprobar_usuario($_POST['usuario'], $_POST['clave']);
    if($u === FALSE) {
        $err = TRUE;
        $usuario = $_POST['usuario'];
        echo "Autenticación fallida";
    }
}else{
    session_start();
    $_SESSION['carrito'] = [];
    foreach($u as $resultado){
        $_SESSION['tienda_id'] = $resultado->tienda_id;
        $_SESSION['email'] = $resultado->email;
    }
    header("Location: categorias.php");
    return;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login Tiendas</title>
        <meta charset = "UTF-8">
    </head>
    <body>
        <?php if(isset($_GET["redirigido"])) {
            echo "<p>Introduzca sus credenciales: </p>";
        }?>
        <?php if(isset($err) and $err == TRUE) {
            echo "<p>Credenciales incorrectas</p>";
        }?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method = "POST">
            <label for = "usuario">email</label>
            <input value = "<?php if(isset($usuario)) echo $usuario;?>" id = "usuario" name = "usuario" type="text">
            <label for="clave">Contraseña</label>
            <input id = "clave" name = "cave" type="password">
            <input type="submit">
        </form>
    </body>
</html>    