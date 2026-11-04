<?php
include "conexion.php";

header('Content-Type: application/json');

$carrera = $_GET['carrera'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$materia = $_GET['materia'] ?? '';

$sql = "SELECT * FROM examen WHERE 1=1";

if (!empty($carrera)) {
    $sql .= " AND carrera = '" . $conexion->real_escape_string($carrera) . "'";
}

if (!empty($semestre)) {
    $sql .= " AND semestre = '" . $conexion->real_escape_string($semestre) . "'";
}

if (!empty($materia)) {
    $sql .= " AND materia LIKE '%" . $conexion->real_escape_string($materia) . "%'";
}

$sql .= " ORDER BY materia ASC";

$result = $conexion->query($sql);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);