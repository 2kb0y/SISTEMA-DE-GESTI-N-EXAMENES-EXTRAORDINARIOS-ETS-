<?php

header("Content-Type: application/json");
include "conexion.php";

$carrera = $_GET['carrera'] ?? '';
$semestre = $_GET['semestre'] ?? '';
$materia = $_GET['materia'] ?? '';

$sql = "SELECT * FROM examen WHERE 1=1";

if ($carrera != "") {
    $carrera = $conexion->real_escape_string($carrera);
    $sql .= " AND carrera='$carrera'";
}

if ($semestre != "") {
    $semestre = $conexion->real_escape_string($semestre);
    $sql .= " AND semestre='$semestre'";
}

if ($materia != "") {
    $materia = $conexion->real_escape_string($materia);
    $sql .= " AND materia LIKE '%$materia%'";
}

$sql .= " ORDER BY semestre ASC, materia ASC";

$result = $conexion->query($sql);

$data = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);