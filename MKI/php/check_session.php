<?php

// Iniciar sesión (sin output antes)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está autenticado
if (!isset($_SESSION["admin_id"]) || !isset($_SESSION["admin_usuario"])) {
    // Si no está autenticado, redirigir al login de forma segura
    header("Location: /MKI/admin/login.html", true, 302);
    exit();
}

// Opcional: Verificar si la sesión ha expirado (30 minutos de inactividad)
$timeout = 30 * 60; // 30 minutos en segundos
if (isset($_SESSION["admin_login_time"]) && (time() - $_SESSION["admin_login_time"]) > $timeout) {
    session_destroy();
    header("Location: /MKI/admin/login.html?sesion_expirada=1", true, 302);
    exit();
}

// Actualizar el tiempo de la última actividad
$_SESSION["admin_login_time"] = time();

?>
