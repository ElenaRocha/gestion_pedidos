<?php
function comprobar_sesion() {
    session_start();
    if(!isset($_SESSION['tienda_id'])) {
        header("Location: login.php?redirigido=true");
    }
}