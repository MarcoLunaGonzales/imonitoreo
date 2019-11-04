<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$codIndicador=$codigo_indicador;
$codArea=$codigo_area;
$codUnidad=$codigo_unidad;
$codSector=$codigo_sector;

$table="actividades_poa";

$urlRedirect="?opcion=listPOA&area=".$codArea."&unidad=".$codUnidad."&sector=".$codSector;


$sql="UPDATE $table set cod_estado=2 where cod_indicador='$codIndicador' and cod_unidadorganizacional='$codUnidad' and cod_area='$codArea'";
//echo $sql;
$stmt = $dbh->prepare($sql);
$flagSuccess=$stmt->execute();

showAlertSuccessError($flagSuccess,$urlRedirect);

?>