<?php

function hayTraslape($conexion, $fecha, $salon, $profesor, $inicio, $fin, $id_excluir = null)
{
    $sql = "
    SELECT id_examen
    FROM examen
    WHERE fecha = ?
    AND (
        salon = ?
        OR profesor_evaluador = ?
    )
    AND (
        hora_inicio < ?
        AND hora_fin > ?
    )
    ";

    // si es edición, excluir el mismo registro
    if ($id_excluir !== null) {
        $sql .= " AND id_examen != ?";
    }

    $stmt = $conexion->prepare($sql);

    if ($id_excluir !== null) {
        $stmt->bind_param(
            "sssssi",
            $fecha,
            $salon,
            $profesor,
            $fin,
            $inicio,
            $id_excluir
        );
    } else {
        $stmt->bind_param(
            "sssss",
            $fecha,
            $salon,
            $profesor,
            $fin,
            $inicio
        );
    }

    $stmt->execute();

    return $stmt->get_result()->num_rows > 0;
}