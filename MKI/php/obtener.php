<?php

header("Content-Type: application/json");

include "conexion.php";

$id = $_GET['id'] ?? null;

if (!$id) {
    echo json_encode(["error" => "NO ID"]);
    exit;
}

$sql = "SELECT * FROM examen WHERE id_examen = ?";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "ERROR PREPARE"]);
    exit;
}

$stmt->bind_param("i", $id);

if (!$stmt->execute()) {
    echo json_encode(["error" => "ERROR EXECUTE"]);
    exit;
}

$result = $stmt->get_result();
$data = $result->fetch_assoc();

echo json_encode($data ?: ["error" => "NOT FOUND"]);