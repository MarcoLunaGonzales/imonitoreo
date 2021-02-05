<?php
set_time_limit(0);

require_once 'functions.php';
require_once 'conexion.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$gestionAnterior="1205";
$gestionNueva="3584";

$sqlDelete="DELETE from actividades_poaplanificacion where cod_actividad in (select codigo from actividades_poa where 
	cod_gestion='$gestionNueva')";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from actividades_poa where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from indicadores_unidadesareas where cod_indicador in (select codigo from indicadores where cod_gestion='$gestionNueva');";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from indicadores where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from objetivos where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from componentessis where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();

$sqlDelete="DELETE from external_costs where cod_gestion='$gestionNueva'";
$stmtDel=$dbh->prepare($sqlDelete);
$stmtDel->execute();



$sqlObj="SELECT codigo, nombre from objetivos where cod_gestion='$gestionAnterior'";
$stmt = $dbh->prepare($sqlObj);
$stmt->execute();
$stmt->bindColumn('codigo', $codigoObj);
$stmt->bindColumn('nombre', $nombreObj);

while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
	echo "obj: ".$codigoObj." ".$nombreObj."<br>";

	$sqlInsertObj="INSERT INTO objetivos (nombre, cod_perspectiva, abreviatura, cod_tipoobjetivo, descripcion,   cod_gestion, cod_estado, cod_indicador) 
	SELECT nombre, cod_perspectiva, abreviatura, cod_tipoobjetivo, descripcion, '$gestionNueva', cod_estado, cod_indicador FROM objetivos where codigo='$codigoObj'";
	//echo $sqlInsertObj."<br>";
	$stmtInsertObj = $dbh->prepare($sqlInsertObj);
	$stmtInsertObj->execute();

	$lastObjetivo = $dbh->lastInsertId();

	$sqlInd="SELECT codigo, nombre FROM indicadores where cod_objetivo='$codigoObj'";
	$stmtInd = $dbh->prepare($sqlInd);
	$stmtInd->execute();
	$stmtInd->bindColumn('codigo', $codigoIndicador);
	$stmtInd->bindColumn('nombre', $nombreIndicador);

	while ($rowIndicador = $stmtInd->fetch(PDO::FETCH_BOUND)) {
		echo "ind: ".$codigoIndicador." ".$nombreIndicador."<br>";
		$sqlInsertInd="INSERT INTO indicadores (nombre, cod_objetivo, cod_periodo, descripcion_calculo, 
	  			lineamiento, cod_tipocalculo, cod_gestion, cod_estado, cod_tiporesultado, cod_tiporesultadometa,
  				cod_tipoobjetivo, cod_clasificador) 
  				SELECT nombre, '$lastObjetivo', cod_periodo, descripcion_calculo, 
	  			lineamiento, cod_tipocalculo, '$gestionNueva', cod_estado, cod_tiporesultado, cod_tiporesultadometa,
  				cod_tipoobjetivo, cod_clasificador from indicadores where codigo='$codigoIndicador'";
  		$stmtInsertInd = $dbh->prepare($sqlInsertInd);
		$stmtInsertInd->execute();

		$lastIndicador = $dbh->lastInsertId();

		$sqlInsertInd="INSERT INTO indicadores_unidadesareas (cod_indicador, cod_unidadorganizacional, cod_area, cod_clasificador) SELECT '$lastIndicador', cod_unidadorganizacional, cod_area, cod_clasificador FROM indicadores_unidadesareas where cod_indicador='$codigoIndicador'";
		$stmtInsertInd = $dbh->prepare($sqlInsertInd);
		$stmtInsertInd->execute();

		$sqlAct="SELECT codigo, nombre from actividades_poa where cod_indicador='$codigoIndicador'";
		$stmtAct = $dbh->prepare($sqlAct);
		$stmtAct->execute();
		$stmtAct->bindColumn('codigo', $codigoActividad);
		$stmtAct->bindColumn('nombre', $nombreActividad);

		while ($rowActividad = $stmtAct->fetch(PDO::FETCH_BOUND)) {
			echo "ACT: ".$codigoActividad." ".$nombreActividad."<br>";
			//CODIGO POA	
			$stmtCod = $dbh->prepare("SELECT IFNULL(max(a.codigo)+1,1)as codigo from actividades_poa a");
			$stmtCod->execute();
			while ($rowCod = $stmtCod->fetch(PDO::FETCH_ASSOC)) {
			  $codigoPOA=$rowCod['codigo'];
			}

			$sqlInsertAct="INSERT INTO actividades_poa (codigo, cod_gestion, orden, nombre, cod_normapriorizada, cod_norma, cod_tiposeguimiento, producto_esperado, clave_indicador, cod_indicador, cod_unidadorganizacional, cod_area, cod_estado, cod_tiporesultado, cod_datoclasificador, cod_comite, cod_estadopon, cod_modogeneracionpon, cod_personal, poai, cod_tipoactividad, cod_periodo,   actividad_extra, cod_hito, observaciones, solicitante, cod_tiposolicitante) 
				SELECT '$codigoPOA', '$gestionNueva', orden, nombre, cod_normapriorizada, cod_norma, cod_tiposeguimiento, 	producto_esperado, clave_indicador, '$lastIndicador', cod_unidadorganizacional, cod_area, cod_estado, cod_tiporesultado, cod_datoclasificador, cod_comite, cod_estadopon, cod_modogeneracionpon, cod_personal, poai, cod_tipoactividad, cod_periodo,   actividad_extra, cod_hito, observaciones, solicitante, cod_tiposolicitante FROM actividades_poa WHERE codigo='$codigoActividad' ";
			//echo $sqlInsertAct."<br>";
			$stmtInsertAct = $dbh->prepare($sqlInsertAct);
			$stmtInsertAct->execute();
			//$lastActividad = $dbh->lastInsertId();

			$sqlInsertAct="INSERT INTO actividades_poaplanificacion (cod_actividad, mes, value_numerico, value_string, value_booleano, fecha_planificacion) SELECT '$codigoPOA', mes, value_numerico, value_string, value_booleano, fecha_planificacion FROM actividades_poaplanificacion where cod_actividad='$codigoActividad'";
			$stmtInsertAct = $dbh->prepare($sqlInsertAct);
			$stmtInsertAct->execute();

		}		
	}
}

$sqlInsertAct="INSERT INTO componentessis (nombre, abreviatura, nivel, cod_padre, cod_estado, partida, cod_personal, cod_gestion) SELECT nombre, abreviatura, nivel, cod_padre, cod_estado, partida, cod_personal, '$gestionNueva' FROM componentessis WHERE cod_gestion='$gestionAnterior'";
$stmtInsertAct = $dbh->prepare($sqlInsertAct);
$stmtInsertAct->execute();

$sqlInsertAct="INSERT INTO external_costs (nombre, nombre_en, abreviatura, cod_estado, cod_gestion) SELECT nombre, nombre_en, abreviatura, cod_estado, '$gestionNueva' FROM external_costs WHERE cod_gestion='$gestionAnterior'";
$stmtInsertAct = $dbh->prepare($sqlInsertAct);
$stmtInsertAct->execute();

//ACA INSERTAMOS EL PROYECTO SIS

?>