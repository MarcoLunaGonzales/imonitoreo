<?php

require_once 'conexion.php';
require_once 'functions.php';

$dbh = new Conexion();

$urlRedirect="?opcion=versionarPOA";

//RECIBIMOS LAS VARIABLES
$codigo=$codigo;


$stmt = $dbh->prepare("DELETE actividades_poa_version where cod_version=:codigo");
$stmt->bindParam(':codigo', $codigo);// Prepare
$flagSuccess=$stmt->execute();

$sqlInsert1="INSERT INTO actividades_poa_version(codigo,cod_gestion,orden,nombre,cod_normapriorizada,cod_norma,cod_tiposeguimiento,
producto_esperado,clave_indicador,cod_indicador,cod_unidadorganizacional,cod_area,created_at,modified_at,created_by,
modified_by,cod_estado,cod_tiporesultado,cod_datoclasificador,cod_comite,cod_estadopon,cod_modogeneracionpon,cod_personal,
poai,cod_tipoactividad,cod_periodo,actividad_extra,cod_hito,observaciones,solicitante,cod_tiposolicitante,cod_version)
SELECT codigo,cod_gestion,orden,nombre,cod_normapriorizada,cod_norma,cod_tiposeguimiento,
producto_esperado,clave_indicador,cod_indicador,cod_unidadorganizacional,cod_area,created_at,modified_at,created_by,
modified_by,cod_estado,cod_tiporesultado,cod_datoclasificador,cod_comite,cod_estadopon,cod_modogeneracionpon,cod_personal,
poai,cod_tipoactividad,cod_periodo,actividad_extra,cod_hito,observaciones,solicitante,cod_tiposolicitante,$codigo FROM actividades_poa";
$stmt = $dbh->prepare($sqlInsert1);
$flagSuccess=$stmt->execute();


$stmt = $dbh->prepare("DELETE actividades_poaplanificacion_version where cod_version=:codigo");
$stmt->bindParam(':codigo', $codigo);// Prepare
$flagSuccess=$stmt->execute();

$sqlInsert1="INSERT INTO actividades_poaplanificacion_version (cod_actividad,mes,value_numerico,
value_string,value_booleano,fecha_planificacion,cod_version)
SELECT cod_actividad,mes,value_numerico,
value_string,value_booleano,fecha_planificacion,$codigo from actividades_poaplanificacion";
$stmt = $dbh->prepare($sqlInsert1);
$flagSuccess=$stmt->execute();



$stmt = $dbh->prepare("DELETE po_presupuesto_version where cod_version=:codigo");
$stmt->bindParam(':codigo', $codigo);// Prepare
$flagSuccess=$stmt->execute();

$sqlInsert1="INSERT INTO po_presupuesto_version(cod_cuenta,cod_fondo,cod_gestion,cod_ano,cod_mes,cod_organismo,monto,cod_version)
SELECT cod_cuenta,cod_fondo,cod_gestion,cod_ano,cod_mes,cod_organismo,monto,$codigo from 
po_presupuesto";
$stmt = $dbh->prepare($sqlInsert1);
$flagSuccess=$stmt->execute();


showAlertSuccessError(true,$urlRedirect);

?>
