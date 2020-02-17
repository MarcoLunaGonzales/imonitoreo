<?php

error_reporting(-1);
set_time_limit(0);

$mysqli = new mysqli("192.168.20.12", "ingresobd", "ingresoibno", "ibnorca");

if (!($sentencia = $mysqli->prepare("CALL sp_cubo_solFactura"))) {
    echo "Falló la preparación: (" . $mysqli->errno . ") " . $mysqli->error;
}

if (!$sentencia->execute()) {
    echo "Falló la ejecución: (" . $sentencia->errno . ") " . $sentencia->error;
}

do {
    if ($resultado = $sentencia->get_result()) {
        printf("---\n");
        var_dump(mysqli_fetch_all($resultado));
        mysqli_free_result($resultado);
    } else {
        if ($sentencia->errno) {
            echo "Store failed: (" . $sentencia->errno . ") " . $sentencia->error;
        }
    }
} while ($sentencia->more_results() && $sentencia->next_result());

?>