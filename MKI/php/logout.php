<?php

// Iniciar sesión para poder destruirla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Destruir la sesión
session_destroy();

// Redirigir al login de forma segura
header("Location: /MKI/admin/login.html", true, 302);
exit();

?>
