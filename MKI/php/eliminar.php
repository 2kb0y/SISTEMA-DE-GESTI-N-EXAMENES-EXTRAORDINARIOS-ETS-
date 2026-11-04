<?php

include 'conexion.php';

$id = $_GET['id'];

$stmt = $conexion->prepare("DELETE FROM examen WHERE id_examen=?");
$stmt->bind_param("i", $id);

$stmt->execute();

echo "OK";