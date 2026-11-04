<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php';
include 'utils.php';

$id = $_POST['id'];

$materia = $_POST['materia'];
$carrera = $_POST['carrera'];
$semestre = $_POST['semestre'];
$fecha = $_POST['fecha'];
$turno = $_POST['turno'];
$edificio = $_POST['edificio'];
$salon = $_POST['salon'];
$profesor = $_POST['profesor'];

/* 🔥 HORARIO AUTOMÁTICO */
$hora_inicio = $_POST['hora_inicio'] ?? '';
$hora_fin = date("H:i:s", strtotime($hora_inicio . " +3 hours"));

if (
    hayTraslape(
        $conexion,
        $fecha,
        $salon,
        $profesor,
        $hora_inicio,
        $hora_fin,
        $id
    )
) {
    die("ERROR: TRASLAPE DETECTADO");
}

$stmt = $conexion->prepare("
UPDATE examen SET
materia=?,
carrera=?,
semestre=?,
fecha=?,
turno=?,
edificio=?,
salon=?,
profesor_evaluador=?,
hora_inicio=?,
hora_fin=?
WHERE id_examen=?
");

$stmt->bind_param(
    "ssisssssssi",
    $materia,
    $carrera,
    $semestre,
    $fecha,
    $turno,
    $edificio,
    $salon,
    $profesor,
    $hora_inicio,
    $hora_fin,
    $id
);

$stmt->execute();

echo "OK";