<?php

// Iniciar sesión PRIMERO (antes de cualquier header)
session_start();

header("Content-Type: application/json");

try {
    require_once "conexion.php";

    $datos = json_decode(file_get_contents("php://input"), true);

    if (!$datos || !isset($datos["usuario"]) || !isset($datos["password"])) {
        echo json_encode([
            "success" => false,
            "error" => "Datos incompletos"
        ]);
        exit();
    }

    $usuario = $datos["usuario"];
    $password = $datos["password"];

    $sql = "
    SELECT usuario
    FROM administrador
    WHERE usuario = ?
    AND password_hash = ?
    ";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }

    $stmt->bind_param(
        "ss",
        $usuario,
        $password
    );

    $stmt->execute();

    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0){

        $admin = $resultado->fetch_assoc();
        
        // Crear sesión segura
        $_SESSION["admin_id"] = $admin["usuario"]; // Usar usuario como ID
        $_SESSION["admin_usuario"] = $admin["usuario"];
        $_SESSION["admin_login_time"] = time();
        
        // Regenerar ID de sesión por seguridad
        session_regenerate_id(true);

        echo json_encode([
            "success" => true
        ]);

    }else{

        echo json_encode([
            "success" => false
        ]);

    }

    $stmt->close();

} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}