<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("conexion.php");

$sql = "SELECT * FROM examen";
$resultado = $conexion->query($sql);

while($fila = $resultado->fetch_assoc()){
    echo $fila["materia"] . "<br>";
}
?>

<?php
include("conexion.php");

$sql = "SELECT * FROM examen";
$resultado = $conexion->query($sql);
