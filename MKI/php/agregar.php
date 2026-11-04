<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php';
include 'utils.php';

$id_admin = 1;

$carrera   = $_POST['carrera'] ?? '';
$semestre  = $_POST['semestre'] ?? '';
$materia   = $_POST['materia'] ?? '';
$fecha     = $_POST['fecha'] ?? '';
$turno     = $_POST['turno'] ?? '';
$edificio  = $_POST['edificio'] ?? '';
$salon     = $_POST['salon'] ?? '';
$profesor  = $_POST['profesor'] ?? '';
$hora_inicio = $_POST['hora_inicio'] ?? '';

// Validar que no haya campos vacíos
if (empty($carrera) || empty($semestre) || empty($materia) || empty($fecha) || 
    empty($turno) || empty($edificio) || empty($salon) || empty($profesor) || empty($hora_inicio)) {
    die("ERROR: Todos los campos son obligatorios");
}

/* HORARIO AUTOMÁTICO */
$hora_fin = date("H:i:s", strtotime($hora_inicio . " +3 hours"));

/* VALIDAR TRASLAPE */
if (hayTraslape($conexion, $fecha, $salon, $profesor, $hora_inicio, $hora_fin)) {
    die("TRASLAPE: Conflicto detectado. Existe otro ETS en el mismo horario/salón/profesor");
}

$stmt = $conexion->prepare("
INSERT INTO examen 
(id_administrador, carrera, semestre, materia, fecha, turno, edificio, salon, profesor_evaluador, hora_inicio, hora_fin)
VALUES (?,?,?,?,?,?,?,?,?,?,?)
");

if (!$stmt) {
    die("ERROR: Error en la preparación de la consulta: " . $conexion->error);
}

$stmt->bind_param(
    "issssssssss",
    $id_admin,
    $carrera,
    $semestre,
    $materia,
    $fecha,
    $turno,
    $edificio,
    $salon,
    $profesor,
    $hora_inicio,
    $hora_fin
);

if (!$stmt->execute()) {
    die("ERROR: Error al guardar en la base de datos: " . $stmt->error);
}

echo "OK";