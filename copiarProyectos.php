<?php
set_time_limit(0);

require_once 'functions.php';
require_once 'conexion.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$gestionAnterior="1204";
$gestionNueva="1205";

$sqlDelete="DELETE from componentessis where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from external_costs where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();


$sqlObj="SELECT codigo, nombre from componentessis where cod_gestion='$gestionAnterior'";
$stmt = $dbh->prepare($sqlObj);
$stmt->execute();
$stmt->bindColumn('codigo', $codigoComp);
$stmt->bindColumn('nombre', $nombreComp);

$arrayCompAntiguo = array();
$arrayCompNuevo = array();

$indice=0;
while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
	//echo "codcompo: ".$codigoComp." ".$nombreComp."<br>";

	$sqlInsertComp="INSERT INTO componentessis (nombre, abreviatura, nivel, cod_padre, cod_estado, partida, cod_personal, cod_gestion) SELECT nombre, abreviatura, nivel, cod_padre, cod_estado, partida, cod_personal, '$gestionNueva' FROM componentessis WHERE cod_gestion='$gestionAnterior' and codigo='$codigoComp'";

	//echo $sqlInsertObj."<br>";
	$stmtInsertComp = $dbh->prepare($sqlInsertComp);
	$stmtInsertComp->execute();

	$lastComponente = $dbh->lastInsertId();

	$arrayCompAntiguo[$indice]=$codigoComp;
	$arrayCompNuevo[$indice]=$lastComponente;

	$indice++;
}


$sqlInsertAct="INSERT INTO external_costs (nombre, nombre_en, abreviatura, cod_estado, cod_gestion) SELECT nombre, nombre_en, abreviatura, cod_estado, '$gestionNueva' FROM external_costs WHERE cod_gestion='$gestionAnterior'";
$stmtInsertAct = $dbh->prepare($sqlInsertAct);
$stmtInsertAct->execute();

//ACA INSERTAMOS EL PROYECTO SIS

//var_dump($arrayCompAntiguo);
//var_dump($arrayCompNuevo);

$longitud = count($arrayCompAntiguo);
 
for($i=0; $i<$longitud; $i++){
	//echo $arrayCompAntiguo[$i]." ";
	//echo $arrayCompNuevo[$i];
	//echo "<br>";
	$sqlUpd="UPDATE componentessis set cod_padre='$arrayCompNuevo[$i]' where cod_padre='$arrayCompAntiguo[$i]' and cod_gestion='$gestionNueva' ";
	echo $sqlUpd."<br>";
	$stmtUpd = $dbh->prepare($sqlUpd);
	$stmtUpd->execute();
}


?>