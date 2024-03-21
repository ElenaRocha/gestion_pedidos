<?php
    require 'server_sesiones.php';

    if(!comprobar_sesion()) return;
    
    $_SESSION = array();
    session_destroy();
    setcookies(session_name(), "", time()-10000);
?>