<?php

require_once 'conexion.php';

//FUNCION PARA MOSTRAR LA ALERTA CORRESPONDIENTE SUCCESS O ERROR
function showAlertSuccessError($bandera, $url){
   if($bandera==true){
      echo "<script>
         alerts.showSwal('success-message','$url');
      </script>";
   }
   if ($bandera==false){
      echo "<script>
         alerts.showSwal('error-message','$url');
      </script>";
   }
}

function showAlertSuccessError2($bandera, $url){
   if($bandera==true){
      echo "<script>
         alerts.showSwal('success-message2','$url');
      </script>";
   }
   if ($bandera==false){
      echo "<script>
         alerts.showSwal('error-message2','$url');
      </script>";
   }
}

function nameMes($month){
  setlocale(LC_TIME, 'es_ES');
  $monthNum  = $month;
  $dateObj   = DateTime::createFromFormat('!m', $monthNum);
  $monthName = strftime('%B', $dateObj->getTimestamp());
  return $monthName;
}

function abrevMes($month){
  if($month==1){    return ("Ene");   }
  if($month==2){    return ("Feb");  }
  if($month==3){    return ("Mar");  }
  if($month==4){    return ("Abr");  }
  if($month==5){    return ("May");  }
  if($month==6){    return ("Jun");  } 
  if($month==7){    return ("Jul");  }
  if($month==8){    return ("Ago");  }
  if($month==9){    return ("Sep");  }
  if($month==10){    return ("Oct");  }         
  if($month==11){    return ("Nov");  }         
  if($month==12){    return ("Dic");  }             
}


function gestionDefaultReport(){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT g.cod_gestion from gestiones_datosadicionales g where g.cod_estado=1");
   $stmt->execute();
   $nombreX=0;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['cod_gestion'];
   }
   return($nombreX);
}

function mesDefaultReport(){
   $dbh = new Conexion();
   $mes=date("m");
   return($mes);
}


function nameGestion($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM gestiones where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}


function buscarAbreviaturaServicio($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT abreviatura FROM servicios_oi where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['abreviatura'];
   }
   return($nombreX);
}

function nameVersion($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT abreviatura FROM versiones_poa where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['abreviatura'];
   }
   return($nombreX);
}

function nameCargo($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM cargos where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameCuenta($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM po_plancuentas where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameIAF($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM iaf where abreviatura=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}


function estadoPOAGestion($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT cod_estadopoa FROM gestiones_datosadicionales where cod_gestion=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX=1;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['cod_estadopoa'];
   }
   return($nombreX);
}

function obtieneOrdenPOA($indicador, $unidad, $area){
  $dbh = new Conexion();
  $sql="SELECT (IFNULL(max(a.orden)+1,1)) as orden from actividades_poa a where a.cod_indicador='$indicador' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area'";
  $stmt = $dbh->prepare($sql);
    //echo $sql;
   $stmt->execute();
   $codigoX=0;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigoX=$row['orden'];
   }
   return($codigoX);  
}

function getCodigoEstadoPON(){
  $dbh = new Conexion();
  $sql="SELECT (IFNULL(max(e.codigo)+1,1)) as codigo from estados_pon e";
  $stmt = $dbh->prepare($sql);
   $stmt->execute();
   $codigoX=0;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigoX=$row['codigo'];
   }
   return($codigoX);  
}


function nameArea($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM areas where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function partidaComponentesSIS($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("select c.partida from componentessis c where c.codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="0";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['partida'];
   }
   return($nombreX);
}

function nameAccNum($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre_en FROM external_costs where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre_en'];
   }
   return($nombreX);
}

function abrevAccNum($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT abreviatura FROM external_costs where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['abreviatura'];
   }
   return($nombreX);
}

function abrevArea($codigo){
   $dbh = new Conexion();
   $sql="SELECT distinct(abreviatura) FROM areas where codigo in ($codigo)";
   $stmt = $dbh->prepare($sql);
   //echo $sql;
   $stmt->execute();
   $cadenaAreas="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cadenaAreas.=$row['abreviatura']."-";
   }
   $cadenaAreas = substr($cadenaAreas, 0, -1); 
   return($cadenaAreas);
}

function nameFondo($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM po_fondos where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameOrganismo($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM po_organismos where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}


function codigosGrupoFondo($codigo){
   $dbh = new Conexion();
   $sql="";
   if($codigo==0){
      $sql="SELECT codigo FROM po_fondos";
   }else{
      $sql="SELECT codigo FROM po_fondos where cod_grupo in ($codigo)";
   }
   $stmt = $dbh->prepare($sql);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['codigo'].",";
   }
   $nombreX.="0";
   return($nombreX);
}

function nameGrupoFondo($codigo){
   $dbh = new Conexion();
   $sql="";
   if($codigo==0){
     $sql="SELECT abreviatura FROM po_fondos";
   }else{
     $sql="SELECT abreviatura FROM po_fondos where cod_grupo in ($codigo)";    
   }
   $stmt = $dbh->prepare($sql);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['abreviatura'].".";
   }
   return($nombreX);
}


function abrevFondo($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT abreviatura FROM po_fondos where codigo in ($codigo)");
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['abreviatura'].".";
   }
   return($nombreX);
}

function abrevOrganismo($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM po_organismos where codigo in ($codigo)");
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['nombre']." - ";
   }
   return($nombreX);
}

function nameUnidad($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM unidades_organizacionales where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameActividad($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM actividades_poa where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function namePersonal($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM personal2 where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function abrevUnidad($codigo){
   $dbh = new Conexion();
   $sql="SELECT abreviatura FROM unidades_organizacionales where codigo in ($codigo)";
   //echo $sql;
   $stmt = $dbh->prepare($sql);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['abreviatura']."-";
   }
   $nombreX = substr($nombreX, 0, -1); 
   return($nombreX);
}


function nameObjetivo($codigo){
	$dbh = new Conexion();
	$stmt = $dbh->prepare("SELECT nombre FROM objetivos where codigo=:codigo");
	$stmt->bindParam(':codigo',$codigo);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$nombreX=$row['nombre'];
	}
	return($nombreX);
}

function nameSectorEconomico($codigo){
  $dbh = new Conexion();
  $stmt = $dbh->prepare("SELECT nombre FROM sectores_economicos where codigo=:codigo");
  $stmt->bindParam(':codigo',$codigo);
  $stmt->execute();
  $nombreX="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nombreX=$row['nombre'];
  }
  return($nombreX);
}

function nameObjetivoxIndicador($codigo){
  $dbh = new Conexion();
  $stmt = $dbh->prepare("SELECT o.nombre FROM objetivos o, indicadores i where i.cod_objetivo=o.codigo and i.codigo=:codigo");
  $stmt->bindParam(':codigo',$codigo);
  $stmt->execute();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nombreX=$row['nombre'];
  }
  return($nombreX);
}


function nameIndicador($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM indicadores where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function nameHito($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM hitos where codigo in (:codigo)");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['nombre']." - ";
   }
   return($nombreX);
}

function nameEstadoPOA($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT nombre FROM estados_actividadespoa where codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function obtenerCodigoPON(){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
   $stmt->execute();
   $codigoPON=0;
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigoPON=$row['valor_configuracion'];
   }
   return($codigoPON);
}

function nameMeta($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT t.nombre FROM indicadores i, tipos_resultado t where t.codigo=i.cod_tiporesultadometa and  i.codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX=$row['nombre'];
   }
   return($nombreX);
}

function dateSolicitud($codigo){
   $dbh = new Conexion();
   $stmt = $dbh->prepare("SELECT fecha FROM solicitud_fondos s where s.codigo=:codigo");
   $stmt->bindParam(':codigo',$codigo);
   $stmt->execute();
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $fechaX=$row['fecha'];
   }
   return($fechaX);
}

function obtenerUnidadesReport($codigo){
  $dbh = new Conexion();
  $sql="";
  if($codigo=="0"){
    $sql="SELECT u.codigo from unidades_organizacionales u";
  }else{
    $sql="SELECT u.codigo from unidades_organizacionales u where u.codigo in ($codigo)";
  }
  //echo "codigo.".$codigo." ".$sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigo=$row['codigo'];
      $cadena.=",".$codigo;
  }
  $cadena=substr($cadena, 1);
  return($cadena);    
}

function obtenerAreasReport($codigo){
  $dbh = new Conexion();
  $sql="";
  if($codigo=="0"){
    $sql="SELECT a.codigo from areas a";
  }else{
    $sql="SELECT a.codigo from areas a where a.codigo in ($codigo)";
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigo=$row['codigo'];
      $cadena.=",".$codigo;
  }
  $cadena=substr($cadena, 1);
  return($cadena);    
}

function obtenerFondosReport($codigo){
  $dbh = new Conexion();
  $sql="";
  if($codigo=="0"){
    $sql="SELECT p.codigo, p.nombre from po_fondos p";
  }else{
    $sql="SELECT p.codigo, p.nombre from po_fondos p, unidades_organizacionales u where p.cod_unidadorganizacional=u.codigo and u.codigo in ($codigo)";
  }
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigo=$row['codigo'];
      $cadena.=",".$codigo;
  }
  $cadena=substr($cadena, 1);
  return($cadena);    
}

function obtenerOrganismosReport($codigo){
  $dbh = new Conexion();
  $sql="";
  if($codigo=="0"){
    $sql="SELECT p.codigo, p.nombre from po_organismos p";
  }else{
    $sql="SELECT p.codigo, p.nombre from po_organismos p, areas a where p.cod_area=a.codigo and a.codigo in ($codigo)";
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codigo=$row['codigo'];
      $cadena.=",".$codigo;
  }
  $cadena=substr($cadena, 1);
  return($cadena);    
}

//ACUMULADO 0=POR MES; 1=ACUMULADO; 2=TODA LA GESTION
function planificacionPorIndicador($indicador, $area, $unidad, $mes, $acumulado){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(sum(ap.value_numerico),0)as cantidad from actividades_poa a, actividades_poaplanificacion ap where a.codigo=ap.cod_actividad and a.cod_indicador='$indicador' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area' and a.clave_indicador=1 ";
  if($acumulado==0){
    $sql.=" and ap.mes='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and ap.mes<='$mes' ";  
  }
//  echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadPlanificada=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadPlanificada=$row['cantidad'];
  }
  return($cantidadPlanificada);
}

function planificacionPorActividad($actividad, $area, $unidad, $mes, $acumulado){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(sum(ap.value_numerico),0)as cantidad from actividades_poa a, actividades_poaplanificacion ap where a.codigo=ap.cod_actividad and a.codigo='$actividad' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area'";
  if($acumulado==0){
    $sql.=" and ap.mes='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and ap.mes<='$mes' ";  
  }
//  echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadPlanificada=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadPlanificada=$row['cantidad'];
  }
  return($cantidadPlanificada);
}


//ACUMULADO 0=POR MES; 1=ACUMULADO; 2=TODA LA GESTION
function planificacionPorIndicadorVersion($indicador, $area, $unidad, $mes, $acumulado, $version){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(sum(ap.value_numerico),0)as cantidad from actividades_poa_version a, actividades_poaplanificacion_version ap where a.codigo=ap.cod_actividad and a.cod_indicador='$indicador' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area' and a.clave_indicador=1 and a.cod_version=ap.cod_version and a.cod_version=$version";
  if($acumulado==0){
    $sql.=" and ap.mes='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and ap.mes<='$mes' ";  
  }
//  echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadPlanificada=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadPlanificada=$row['cantidad'];
  }
  return($cantidadPlanificada);
}

//ACUMULADO 0=POR MES; 1=ACUMULADO; 2=TODA LA GESTION
function ejecucionPorIndicador($indicador, $area, $unidad, $mes, $acumulado){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(sum(ap.value_numerico),0)as cantidad from actividades_poa a, actividades_poaejecucion ap where a.codigo=ap.cod_actividad and a.cod_indicador='$indicador' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area' and a.clave_indicador=1 ";
  if($acumulado==0){
    $sql.=" and ap.mes='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and ap.mes<='$mes' ";  
  }
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadPlanificada=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadPlanificada=$row['cantidad'];
  }
  return($cantidadPlanificada);
}

function cursosPorUnidadAnt($unidad, $anio, $mes, $acumulado, $tipocurso){
  $dbh = new Conexion();
  $cadenaEstados=obtieneValorConfig(27);
  //$sql="SELECT count(*) as cantidad, c.id_oficina from ext_cursos c where YEAR(c.fecha_inicio)='$anio' and c.gestion='$anio' and c.estado in ($cadenaEstados) and c.id_oficina in ($unidad) ";
  $sql="SELECT count(*) as cantidad, c.id_oficina from ext_cursos c where YEAR(c.fecha_inicio)='$anio' and c.estado in ($cadenaEstados) and c.id_oficina in ($unidad) ";
  if($acumulado==0){
    $sql.=" and MONTH(c.fecha_inicio)='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and MONTH(c.fecha_inicio)<='$mes' ";  
  }
  if($tipocurso!=""){
    $sql.=" and c.tipo in ('$tipocurso')";
  }
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $numeroCursos=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $numeroCursos=$row['cantidad'];
  }
  return($numeroCursos);  
}

function cursosPorUnidad($unidad, $anio, $mes, $acumulado, $tipocurso){
  $dbh = new Conexion();
  $sql="SELECT eac.d_oficina, eac.cod_curso, eac.nromodulo ,count(*)as cuenta from ext_alumnos_cursos eac where eac.curso_gestion='$anio' and eac.cod_curso not in ('') and eac.cod_curso in (select distinct(ec.codigocurso) from ext_cursos ec where ec.id_oficina in ($unidad)) ";

  if($acumulado==0){
    $sql.=" and YEAR(eac.fechainicio)='$anio' and MONTH(eac.fechainicio)='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and YEAR(eac.fechainicio)='$anio' and MONTH(eac.fechainicio)<='$mes' ";  
  }
  if($tipocurso!=""){
    $sql.=" and eac.d_tipo in ('$tipocurso')";
  }
  $sql.=" GROUP BY eac.d_oficina, eac.cod_curso, eac.nromodulo ";

  //echo $sql."<br>";

  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $numeroCursos=0;
  $cantidadAlumnos=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadAlumnos=$cantidadAlumnos+$row['cuenta'];
      $numeroCursos++;
  }
  return($numeroCursos);  
}

function alumnosPorUnidad($unidad, $anio, $mes, $acumulado, $tipocurso){
  $dbh = new Conexion();
  $sql="SELECT eac.d_oficina, eac.cod_curso, eac.idmodulo ,count(*)as cuenta from ext_alumnos_cursos eac where eac.curso_gestion='$anio' and eac.cod_curso not in ('') and eac.cod_curso in (select distinct(ec.codigocurso) from ext_cursos ec  ";
  
  if($unidad!=0){
    $sql.=" where ec.id_oficina in ($unidad)) ";
  }else{
    $sql.=" ) ";
  }

  if($acumulado==0){
    $sql.=" and YEAR(eac.fechainicio)='$anio' and MONTH(eac.fechainicio)='$mes' ";
  }
  if($acumulado==1){
    $sql.=" and YEAR(eac.fechainicio)='$anio' and MONTH(eac.fechainicio)<='$mes' ";  
  }
  if($tipocurso!=""){
    $sql.=" and eac.d_tipo in ('$tipocurso')";
  }
  $sql.=" GROUP BY eac.d_oficina, eac.cod_curso, eac.idmodulo ";

  //echo $sql."<br>";

  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $numeroCursos=0;
  $cantidadAlumnos=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadAlumnos=$cantidadAlumnos+$row['cuenta'];
      $numeroCursos++;
  }
  return($cantidadAlumnos);    
}

function serviciosPorUnidad($unidad, $anio, $mes, $acumulado, $tipoServicio, $vista){//vista 1 cantidad, 2 monto bs.
  $dbh = new Conexion();
  $sql="SELECT sum(e.monto_facturado)as monto, sum(e.cantidad)as cantidad from ext_servicios e, servicios_oi_detalle sd, servicios_oi so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anio and e.id_oficina in ($unidad) and so.codigo in ($tipoServicio)";
  if($acumulado==0){
    $sql.=" and MONTH(e.fecha_factura)=$mes ";
  }
  if($acumulado==1){
    $sql.=" and MONTH(e.fecha_factura)<=$mes ";  
  }
 // echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadServicios=0;
  $montoServicios=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadServicios=$row['cantidad'];
      $montoServicios=$row['monto'];
  }
  $variableDevolver=0;
  if($vista==1){
    $variableDevolver=$cantidadServicios;
  }else{
    $variableDevolver=$montoServicios;
  }
  return($variableDevolver);  
}

function serviciosPorUnidadTCP($unidad, $area, $anio, $mes, $acumulado, $tipoServicio, $vista){//vista 1 cantidad, 2 monto bs.
  $dbh = new Conexion();
  
  $tablaServicios="";
  $tablaServiciosDet="";
  if($area==38){
    $tablaServicios="servicios_tcs";
    $tablaServiciosDet="servicios_tcs_detalle";
  }
  if($area==39){
    $tablaServicios="servicios_tcp";
    $tablaServiciosDet="servicios_tcp_detalle";
  }
  if($area==40){
    $tablaServicios="servicios_tlq";
    $tablaServiciosDet="servicios_tlq_detalle";
  }

  $sql="SELECT sum(e.monto_facturado*0.87)as monto, sum(e.cantidad)as cantidad from ext_servicios e, $tablaServiciosDet sd, $tablaServicios so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anio and e.id_oficina in ($unidad) and so.codigo in ($tipoServicio)";
  if($acumulado==0){
    $sql.=" and MONTH(e.fecha_factura)=$mes ";
  }
  if($acumulado==1){
    $sql.=" and MONTH(e.fecha_factura)<=$mes ";  
  }
 // echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadServicios=0;
  $montoServicios=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadServicios=$row['cantidad'];
      $montoServicios=$row['monto'];
  }
  $variableDevolver=0;
  if($vista==1){
    $variableDevolver=$cantidadServicios;
  }else{
    $variableDevolver=$montoServicios;
  }
  return($variableDevolver);  
}

function serviciosPorUnidadDetalle($unidad, $anio, $mes, $acumulado, $tipoServicio, $vista){//vista 1 cantidad, 2 monto bs.
  $dbh = new Conexion();
  $sql="SELECT sum(e.monto_facturado*0.87)as monto, sum(e.cantidad)as cantidad from ext_servicios e, servicios_oi_detalle sd, servicios_oi so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anio and e.id_oficina in ($unidad) and sd.codigo in ($tipoServicio)";
  if($acumulado==0){
    $sql.=" and MONTH(e.fecha_factura)=$mes ";
  }
  if($acumulado==1){
    $sql.=" and MONTH(e.fecha_factura)<=$mes ";  
  }
 // echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadServicios=0;
  $montoServicios=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadServicios=$row['cantidad'];
      $montoServicios=$row['monto'];
  }
  $variableDevolver=0;
  if($vista==1){
    $variableDevolver=$cantidadServicios;
  }else{
    $variableDevolver=$montoServicios;
  }
  return($variableDevolver);  
}

function serviciosPorUnidadDetalleTCP($unidad, $area, $anio, $mes, $acumulado, $tipoServicio, $vista){//vista 1 cantidad, 2 monto bs.
  $dbh = new Conexion();
  $tablaServicios="";
  $tablaServiciosDet="";
  if($area==38){
    $tablaServicios="servicios_tcs";
    $tablaServiciosDet="servicios_tcs_detalle";
  }
  if($area==39){
    $tablaServicios="servicios_tcp";
    $tablaServiciosDet="servicios_tcp_detalle";
  }
  if($area==40){
    $tablaServicios="servicios_tlq";
    $tablaServiciosDet="servicios_tlq_detalle";
  }
  $sql="SELECT sum(e.monto_facturado*0.87)as monto, sum(e.cantidad)as cantidad from ext_servicios e, $tablaServiciosDet sd, $tablaServicios so where so.codigo=sd.cod_servicio and e.idclaservicio=sd.codigo and YEAR(e.fecha_factura)=$anio and e.id_oficina in ($unidad) and sd.codigo in ($tipoServicio)";
  if($acumulado==0){
    $sql.=" and MONTH(e.fecha_factura)=$mes ";
  }
  if($acumulado==1){
    $sql.=" and MONTH(e.fecha_factura)<=$mes ";  
  }
 // echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadServicios=0;
  $montoServicios=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadServicios=$row['cantidad'];
      $montoServicios=$row['monto'];
  }
  $variableDevolver=0;
  if($vista==1){
    $variableDevolver=$cantidadServicios;
  }else{
    $variableDevolver=$montoServicios;
  }
  return($variableDevolver);  
}

function cutString($string, $count){
  $string=substr($string, 0, $count);
  return $string;
}

function clean_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    $string = str_replace(
        array('.',',',';','  '),
        array('','','',' '),
        $string
    );
    $string = str_replace("'","",$string);

    $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
    $reemplazar=array("", "", "", "");
    $string=str_ireplace($buscar,$reemplazar,$string);

    $buscar=array("ª","/");
    $reemplazar=array("","");
    $string=str_ireplace($buscar,$reemplazar,$string);

    return $string;
}

function string_sanitize($s) { 
  $result = preg_replace("/[^a-zA-Z0-9]+/", "", $s); 
  return $result; 
} 

function formatNumberInt($valor) { 
   $float_redondeado=number_format($valor, 0); 
   return $float_redondeado; 
}

function formatNumberDec($valor) { 
   $float_redondeado=number_format($valor, 2); 
   return $float_redondeado; 
}

function colorPorcentajeIngreso($porcentaje){
  $colorDevolver="";
  if($porcentaje<80){
    $colorDevolver="bg-danger";
  }
  if($porcentaje>=80 && $porcentaje<95){
    $colorDevolver="bg-warning";
  }
  if($porcentaje>=95){
    $colorDevolver="bg-success";
  }
  return($colorDevolver);
}

function colorPorcentajeEgreso($porcentaje){
  $colorDevolver="";
  if($porcentaje<80){
    $colorDevolver="bg-success";
  }
  if($porcentaje>=80 && $porcentaje<95){
    $colorDevolver="bg-warning";
  }
  if($porcentaje>=95){
    $colorDevolver="bg-danger";
  }
  return($colorDevolver);
}

function buscarHijosUO($cod_unidad){
  $dbh = new Conexion();
  $sql="select u.cod_unidadorganizacionalhijo from unidadesorganizacionales_hijos u where u.cod_unidadorganizacional='$cod_unidad'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadenaHijos=$cod_unidad;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codUnidadHijo=$row['cod_unidadorganizacionalhijo'];
      $cadenaHijos.=",".$codUnidadHijo;
  }
  return($cadenaHijos);  
}

function buscarAreasAdicionales($cod_personal,$tipo){//1 codigos , 2 nombres
  $dbh = new Conexion();
  $sql="SELECT pa.cod_area, (select a.abreviatura from areas a where a.codigo=pa.cod_area)as nombre from personal_areas pa where pa.cod_personal='$cod_personal'";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="0";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codAreaAdi=$row['cod_area'];
      $nombreAreaAdi=$row['nombre'];
      if($tipo==1){
        $cadena.=",".$codAreaAdi;
      }
      if($tipo==2){
        $cadena.=",".$nombreAreaAdi;
      }
  }
  //$cadena=substr($cadena, 2);
  return($cadena);  
}

function buscarUnidadesAdicionales($cod_personal,$tipo){//1 codigos , 2 nombres
  $dbh = new Conexion();
  $sql="SELECT pa.cod_unidad, (select a.abreviatura from unidades_organizacionales a where a.codigo=pa.cod_unidad)as nombre from personal_unidadesorganizacionales pa where pa.cod_personal='$cod_personal'";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cadena="0";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $codAreaAdi=$row['cod_unidad'];
      $codUnidadHijos=buscarHijosUO($codAreaAdi);
      $nombreAreaAdi=$row['nombre'];
      if($tipo==1){
        $cadena.=",".$codUnidadHijos;
      }
      if($tipo==2){
        $cadena.=",".$nombreAreaAdi;
      }
  }
  //$cadena=substr($cadena, 2);
  return($cadena);  
}

function obtieneEjecucionSistema($mes,$anio,$clasificador,$unidad,$area,$indicador,$codigoClasificador){
  $dbh = new Conexion();
  $unidadHijos=buscarHijosUO($unidad);
  $valueRegistros=0;

  //echo "ingresando a la funcion";
  
  //echo "clasificador:".$clasificador;
  //ESTA LINEA ES PARA SEC
  if($clasificador==3){
    $codIndicadorContar=obtieneValorConfig(16);
    $codIndicadorSumar=obtieneValorConfig(17);
    
    if($codIndicadorSumar==$indicador){
      $sql="SELECT sum(importe_neto)as registros from ext_cursos e where  MONTH(e.fecha_factura)=$mes and YEAR(e.fecha_factura)=$anio and e.id_programa='$codigoClasificador'";
    }else{
      $sql="SELECT count(distinct(e.codigocurso)) as registros from ext_cursos e where  MONTH(e.fecha_factura)=$mes and YEAR(e.fecha_factura)=$anio and e.id_programa='$codigoClasificador'";
    }
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }
  //ESTA LINEA ES PARA TCP
  if($clasificador==1 && $area==39){
    $codIndicadorContar=obtieneValorConfig(32);
    $codIndicadorSumar=obtieneValorConfig(17);
    if($codIndicadorContar==$indicador){
      $sql="SELECT sum(e.cantidad) as registros from ext_servicios e where YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes and e.id_area=$area and e.id_cliente=$codigoClasificador";
    }
    if($codIndicadorSumar==$indicador){
      $sql="SELECT sum(e.monto_facturado) as registros from ext_servicios e where YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes and e.id_area=$area and e.id_cliente=$codigoClasificador";      
    }
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
      if($codIndicadorSumar==$indicador){
        $valueRegistros=$valueRegistros*0.87;
      }      
    }
  }
  //ESTA LINEA ES PARA TCS
  if($clasificador==1 && $area==38){
    $codIndicadorContar=obtieneValorConfig(33);
    $codIndicadorSumar=obtieneValorConfig(17);
    if($codIndicadorContar==$indicador){
      $sql="SELECT sum(e.cantidad) as registros from ext_servicios e where YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes and e.id_area=$area and e.id_cliente=$codigoClasificador";
    }
    if($codIndicadorSumar==$indicador){
      $sql="SELECT sum(e.monto_facturado) as registros from ext_servicios e where YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes and e.id_area=$area and e.id_cliente=$codigoClasificador";      
    }
   //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
      if($codIndicadorSumar==$indicador){
        $valueRegistros=$valueRegistros*0.87;
      }      
    }
  }

  //ESTA LINEA ES PARA LOS SERVICIOS OI
  if($clasificador==2){
    $codIndicadorContar=obtieneValorConfig(16);
    $codIndicadorSumar=obtieneValorConfig(17);
    $sql="";
    if($codIndicadorContar==$indicador){
      //AQUI HACEMOS LA MODIFICACION DESDE LA TABLA DE SOLICITUDFACTURACION
      $abreviaturaServicio=buscarAbreviaturaServicio($codigoClasificador);
      //$sql="SELECT sum(e.cantidad)as registros from ext_solicitudfacturacion e where e.codigoserviciocurso like '%$abreviaturaServicio%' and YEAR(e.fecha)='$anio' and MONTH(e.fecha)='$mes' and e.idestado not in (266) and e.idoficina in ($unidadHijos)";  
      $sql="SELECT sum(e.cantidad)as registros from ext_servicios e, servicios_oi_detalle sd where e.idclaservicio=sd.codigo and sd.cod_servicio=$codigoClasificador and e.id_oficina in ($unidadHijos) and YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes and e.id_area='$area';"; 
      //echo $sql; 
      
    }
    if($codIndicadorSumar==$indicador){
        $abreviaturaServicio=buscarAbreviaturaServicio($codigoClasificador);
        //$sql="SELECT sum(e.montobs)as registros from ext_solicitudfacturacion e where e.codigoserviciocurso like '%$abreviaturaServicio%' and YEAR(e.fecha)='$anio' and MONTH(e.fecha)='$mes' and e.idestado not in (266) and e.idoficina in ($unidadHijos)";  
        $sql="SELECT sum(e.monto_facturado) as registros from ext_servicios e, servicios_oi_detalle sd where e.idclaservicio=sd.codigo and sd.cod_servicio=$codigoClasificador and e.id_oficina in ($unidadHijos) and YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes and e.id_area='$area';";
    }
    //echo $sql;
    //echo $codIndicadorContar." ".$codIndicadorSumar." ".$indicador." ".$sql." </br>";
    
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
      if($codIndicadorSumar==$indicador){
        $valueRegistros=$valueRegistros*0.87;
      }
    }
  }

  //ESTA LINEA ES PARA LOS SERVICIOS TLQ
  if($clasificador==4){
    $sql="SELECT sum(e.cantidad)as registros from ext_servicios e, servicios_tlq_detalle sd where e.idclaservicio=sd.codigo and sd.cod_servicio=$codigoClasificador and YEAR(e.fecha_factura)=$anio and MONTH(e.fecha_factura)=$mes;";
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }
  //echo $sql;

  return($valueRegistros);
}

function obtieneValorConfig($codigo){
  $dbh = new Conexion();
  $stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion='$codigo'");
  $stmt->execute();
  $valor="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $valor=$row['valor_configuracion'];
  }  
  return $valor;
}



function obtieneTablaClasificador($indicador, $unidad, $area){
  $dbh = new Conexion();
  $sqlClasificador="SELECT IFNULL(i.cod_clasificador,0)as clasificador FROM indicadores_unidadesareas i where i.cod_indicador='$indicador' and i.cod_unidadorganizacional in ($unidad) and i.cod_area in ($area)";
//  echo $sqlClasificador;
  $stmtClasificador = $dbh->prepare($sqlClasificador);
  $stmtClasificador->execute();
  $codClasificador=0;
  while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
    $codClasificador=$rowClasificador['clasificador'];
  }
  $codigoTabla=$codClasificador;
  //sacamos el nombre de la tabla
  $sqlClasificador="SELECT c.tabla FROM clasificadores c where c.codigo=$codigoTabla";
  //echo $sqlClasificador;
  $stmtClasificador = $dbh->prepare($sqlClasificador);
  $stmtClasificador->execute();
  $nombreTablaClasificador="";
  while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
    $nombreTablaClasificador=$rowClasificador['tabla'];
  }
  return $nombreTablaClasificador;
}



function obtieneCodigoClasificador($indicador, $unidad, $area){
  $dbh = new Conexion();
  //echo "indicador-".$indicador." area.".$area;
  $sqlClasificador="SELECT IFNULL(i.cod_clasificador,0)as clasificador FROM indicadores_unidadesareas i where i.cod_indicador='$indicador' and i.cod_unidadorganizacional='$unidad' and i.cod_area='$area'";
//  echo $sqlClasificador;
  $stmtClasificador = $dbh->prepare($sqlClasificador);
  $stmtClasificador->execute();
  $codClasificador=0;
  while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
    $codClasificador=$rowClasificador['clasificador'];
  }
  $codigoTabla=$codClasificador;
  return $codigoTabla;
}

function obtieneDatoClasificador($datoClasi,$nombreTabla){
  $dbh = new Conexion();
  if($nombreTabla=="clientes"){
    $sqlClasificador="SELECT concat(c.nombre,' (',u.abreviatura,')',' ',c.codigo)as nombre from clientes c, unidades_organizacionales u where u.codigo=c.cod_unidad and c.codigo='$datoClasi'";
    $stmtClasificador = $dbh->prepare($sqlClasificador);
    $stmtClasificador->execute();
    $nombreClasi="";
    while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
      $nombreClasi=$rowClasificador['nombre'];
    }
  }else{
    $sqlClasificador="SELECT nombre from $nombreTabla where codigo='$datoClasi'";
    $stmtClasificador = $dbh->prepare($sqlClasificador);
    $stmtClasificador->execute();
    $nombreClasi=0;
    while ($rowClasificador = $stmtClasificador->fetch(PDO::FETCH_ASSOC)) {
      $nombreClasi=$rowClasificador['nombre'];
    }
  }
  return($nombreClasi);
}

function obtieneActRetrasadas($codigoActividad,$anio,$mes,$codIndicador,$unidad,$area){
  $dbh = new Conexion();
  
  $sql="SELECT ap.mes, ap.value_numerico as planificado, 
  (select ae.value_numerico from actividades_poaejecucion ae where ae.mes=ap.mes and ap.cod_actividad=ae.cod_actividad) as ejecutado
  from actividades_poaplanificacion ap where ap.cod_actividad=$codigoActividad and ap.mes<=$mes";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $observacion="";
  $totalPlani=0;
  $totalEj=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $mes=$row['mes'];
    $valorPlanificado=$row['planificado'];
    $valorEjecutado=$row['ejecutado'];
    $totalPlani+=$valorPlanificado;
    $totalEj+=$valorEjecutado;
  }
  if($totalPlani>$totalEj){
    $observacion="<a href='graficos/detalleActividadPOA.php?codIndicador=$codIndicador&unidad=$unidad&area=$area&codActividad=$codigoActividad' target='_blank'><i class='material-icons' style='color:orange' title='Actividades Pendientes'>error</i></a>";
  }else{
    $observacion="";
    $sql="SELECT sum(ap.value_numerico) as planificado, (select sum(ae.value_numerico) from actividades_poaejecucion ae where ap.cod_actividad=ae.cod_actividad) as ejecutado from actividades_poaplanificacion ap where ap.cod_actividad=$codigoActividad";
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $totalPlani=0;
    $totalEj=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $totalPlani=$row['planificado'];
      $totalEj=$row['ejecutado'];
    }
    if($totalEj>=$totalPlani && $totalPlani>0){
      $observacion="<a href='graficos/detalleActividadPOA.php?codIndicador=$codIndicador&unidad=$unidad&area=$area&codActividad=$codigoActividad' target='_blank'><i class='material-icons' style='color:#37F95D' title='Completed'>check_circle</i></a>";
    }
  }
  return($observacion);
}

function verificaRegistrosSIS($anio){
  $dbh = new Conexion();
  $bandera=0;
  $sql="SELECT count(*)as contador from sis_archivos s where s.anio=$anio";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidadRegistros=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidadRegistros=$row['contador'];
  }
  if($cantidadRegistros==0){
    $bandera=1;
    for($i=1;$i<=12;$i++){
      $sqlCodigo=
      $sqlInsert="INSERT into sis_archivos(anio, mes, nro_archivo, archivo) values ('$anio','$i',1,'0')";
      $stmtInsert = $dbh->prepare($sqlInsert);
      $stmtInsert->execute();

      $sqlInsert="INSERT into sis_archivos(anio, mes, nro_archivo, archivo) values ('$anio','$i',2,'0')";
      $stmtInsert = $dbh->prepare($sqlInsert);
      $stmtInsert->execute();
    }
  }
  return($bandera);  
}

function verificaRegistroEjecucion($codigoActividad,$anio,$mes){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(SUM(a.id),0)as id from actividades_poaejecucion a where a.cod_actividad=$codigoActividad and a.mes=$mes";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $idRegistro=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $idRegistro=$row['id'];
  }
  if($idRegistro==0){
    $sqlInsert="INSERT INTO actividades_poaejecucion(cod_actividad, mes, value_numerico) values ('$codigoActividad','$mes',0)";
    $stmtInsert=$dbh->prepare($sqlInsert);
    $stmtInsert->execute();

    $sql="SELECT a.id as id from actividades_poaejecucion a where a.cod_actividad=$codigoActividad and a.mes=$mes";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $idRegistro=0;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idRegistro=$row['id'];
    }
  }
  return($idRegistro);
}


function verificaArchivoEjecucion($idRegistroEjecucion){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(SUM(a.archivo),0)as archivo from actividades_poaejecucion a where a.id=$idRegistroEjecucion";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $archivo=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $archivo=$row['archivo'];
  }
  return($archivo);
}

function obtenerResponsableSIS($codigoComponente){
  $dbh = new Conexion();
  $sql="SELECT p.nombre from personal2 p, componentessis c where c.cod_personal=p.codigo and c.codigo=$codigoComponente";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $personal="";
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $personal="Responsable: (".$row['nombre'].")";
  }
  return($personal);  
}

function calcularClientesSECPeriodo($unidad,$area,$mes,$anio){
  $dbh = new Conexion();

  $cadenaEstados=obtieneValorConfig(27);

  $fechaFin=$anio."-".$mes."-01";
  $fechaIni=date('Y-m-d',strtotime($fechaFin.'-11 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'+1 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'-1 day'));

  $sql="SELECT count(distinct(eac.cialumno))as cantidad from ext_alumnos_cursos eac where eac.fechainicio BETWEEN '$fechaIni' and '$fechaFin' and eac.cod_curso in (select distinct(ec.codigocurso) from ext_cursos ec where ec.id_oficina in ($unidad));";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);    
}

function calcularClientesPeriodo($unidad,$area,$mes,$anio){
  $dbh = new Conexion();
  $fechaFin=$anio."-".$mes."-01";
  $fechaIni=date('Y-m-d',strtotime($fechaFin.'-11 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'+1 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'-1 day'));

  $sql="SELECT count(distinct(e.id_cliente))as cantidad FROM ext_servicios e where e.id_area in($area) and e.id_oficina in ($unidad) and e.fecha_factura BETWEEN '$fechaIni' and '$fechaFin'";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);    
}

function calcularClientesSECRetenidos($unidad,$area,$mes,$anio){
  $dbh = new Conexion();
  $cadenaEstados=obtieneValorConfig(27);

  $fechaFin=$anio."-".$mes."-01";
  $fechaIni=date('Y-m-d',strtotime($fechaFin.'-11 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'+1 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'-1 day'));

  $fechaIniAnt=date('Y-m-d',strtotime($fechaIni.'-1 year'));
  $fechaFinAnt=date('Y-m-d',strtotime($fechaFin.'-1 year'));

  $sql="SELECT count(distinct(e.cialumno))as cantidad from ext_alumnos_cursos e where e.fechainicio BETWEEN '$fechaIni' and '$fechaFin' and e.cod_curso in (select distinct(ec.codigocurso) from ext_cursos ec where ec.id_oficina in ($unidad) and ec.estado in ($cadenaEstados)) and e.cialumno in (SELECT distinct(e.cialumno) from ext_alumnos_cursos e where e.fechainicio BETWEEN '$fechaIniAnt' and '$fechaFinAnt' and e.cod_curso in (select distinct(ec.codigocurso) from ext_cursos ec where ec.id_oficina in ($unidad) and ec.estado in ($cadenaEstados)))";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);    
}


function calcularAlumnosGrupoEtario($unidad,$area,$mes,$anio,$edadmin,$edadmax){
  $dbh = new Conexion();

  $cadenaEstados=obtieneValorConfig(27);

  $fechaActual=$anio."-".$mes."-01";

  $sql="SELECT count(distinct(eac.cialumno))as cantidad from ext_alumnos_cursos eac where YEAR(eac.fechainicio)=$anio and  MONTH(eac.fechainicio)<='$mes' and eac.cod_curso in (select distinct(ec.codigocurso) from ext_cursos ec where ec.gestion='$anio' ";
  if($unidad!=0){
    $sql.=" and ec.id_oficina in ($unidad) ";
  }
  if($edadmin==0 && $edadmax==0){
    $sql.=")";
  }else{
      $sql.=") and IFNULL(TIMESTAMPDIFF(YEAR, eac.fechanacimiento, '$fechaActual'),-1000)>$edadmin and IFNULL(TIMESTAMPDIFF(YEAR, eac.fechanacimiento, '$fechaActual'),-1000)<=$edadmax ";
  }
  
//  echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);    
}

function calcularClientesRetenidos($unidad,$area,$mes,$anio){
  $dbh = new Conexion();
  $fechaFin=$anio."-".$mes."-01";
  $fechaIni=date('Y-m-d',strtotime($fechaFin.'-11 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'+1 month'));
  $fechaFin=date('Y-m-d',strtotime($fechaFin.'-1 day'));

  $fechaIniAnt=date('Y-m-d',strtotime($fechaIni.'-1 year'));
  $fechaFinAnt=date('Y-m-d',strtotime($fechaFin.'-1 year'));

  $sql="SELECT count(distinct(ee.id_cliente))as cantidad from ext_servicios ee where ee.id_area in ($area) and ee.id_oficina in ($unidad) and ee.fecha_factura BETWEEN '$fechaIni' and '$fechaFin' and ee.id_cliente in (select distinct(e.id_cliente) from ext_servicios e where e.id_area in ($area) and e.id_oficina in ($unidad) and e.fecha_factura BETWEEN '$fechaIniAnt' and '$fechaFinAnt')";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);    
}

function obtenerCantEmpresasCertificados($unidad,$anioTemporal,$mesTemporal,$area1,$area2,$ambos,$acumulado,$vista)//AMBOS=1 SACAR LOS CERTIFICADOS EN AMBOS TCP Y TCS
{
  $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));
  $txtOmitirRM=obtieneValorConfig(30);
  $estadosOmitir=obtieneValorConfig(31);


  $dbh = new Conexion();
  $sql="SELECT count(distinct(e.idcliente))as cantidad from ext_certificados e where e.idarea=$area1 and e.idestado not in ($estadosOmitir) and e.norma not like '%$txtOmitirRM%' and e.norma not in ('N/A','') ";
  if($vista==1){
    if($acumulado==0){
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)='$mesTemporal' ";
    }else{
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<='$mesTemporal' ";
    }    
  }else{
    $sql.=" and e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' ";
  }
  if($unidad>0){
    $sql.=" and e.idoficina in ($unidad) ";
  } 
  
  //echo $sql;
  
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);      
}


function obtenerCantCertificados($unidad,$anioTemporal,$mesTemporal,$area1,$ambos,$acumulado,$vista)
{
  $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));
  $txtOmitirRM=obtieneValorConfig(30);
  $estadosOmitir=obtieneValorConfig(31);

  $dbh = new Conexion();
  $sql="SELECT count(*)as cantidad from ext_certificados e where  e.idarea=$area1 and e.idestado not in ($estadosOmitir) and e.norma not like '%$txtOmitirRM%' and e.norma not in ('N/A','') ";
  if($vista==1){
    if($acumulado==0){
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)='$mesTemporal' ";
    }else{
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<='$mesTemporal' ";
    }
  }else{
    $sql.=" and e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' ";    
    //$sql.=" and e.fechavalido>='$fechaVistaFin' ";    
  }
  if($unidad>0){
    $sql.=" and e.idoficina in ($unidad) ";
  } 
  
  //echo $sql;
  
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);      
}


function obtenerCantCertificadosNorma($unidad,$anioTemporal,$mesTemporal,$area1,$norma,$acumulado,$vista)
{
  $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));

  $txtOmitirRM=obtieneValorConfig(30);
  $estadosOmitir=obtieneValorConfig(31);


  $dbh = new Conexion();
  $sql="SELECT count(*)as cantidad from ext_certificados e where e.idarea=$area1 and e.idestado not in ($estadosOmitir) and e.norma not like '%$txtOmitirRM%' and e.norma not in ('N/A','')";
  if($norma==""){
    if($vista==1){
      $sql.=" and e.norma in (SELECT ee.norma from ext_certificados ee where YEAR(ee.fechaemision)=$anioTemporal and ee.idarea='$area1') ";
    }else{
      $sql.=" and e.norma in (SELECT ee.norma from ext_certificados ee where e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' and ee.idarea='$area1') ";
    }
  }else{
    $sql.=" and e.norma='$norma' ";
  }
  if($vista==1){
    if($acumulado==0){
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)='$mesTemporal' ";
    }else{
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<='$mesTemporal' ";
    }
  }else{
    $sql.=" and e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' ";        
  }
  if($unidad>0){
    $sql.=" and e.idoficina in ($unidad) ";
  } 
  
  //echo $sql;
  
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);      
}




function obtenerCantCertificadosIAF($unidad,$anioTemporal,$mesTemporal,$area1,$iaf,$acumulado,$vista)
{
  $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));
  $txtOmitirRM=obtieneValorConfig(30);
  $estadosOmitir=obtieneValorConfig(31);

  $dbh = new Conexion();
  $sql="SELECT count(*)as cantidad from ext_certificados e where e.idarea=$area1 and e.idestado not in ($estadosOmitir) and e.norma not like '%$txtOmitirRM%' and e.norma not in ('N/A','') ";
  if($iaf==-1){
    if($vista==1){
      $sql.=" and e.iaf in (SELECT ee.iaf from ext_certificados ee where  YEAR(ee.fechaemision)=$anioTemporal and ee.idarea='$area1') ";
    }else{
      $sql.=" and e.iaf in (SELECT ee.iaf from ext_certificados ee where e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' and ee.idarea='$area1') ";
    }
  }else{
    $sql.=" and e.iaf='$iaf' ";
  }
  if($vista==1){
    if($acumulado==0){
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)='$mesTemporal' ";
    }else{
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<='$mesTemporal' ";
    }
  }else{
    $sql.=" and e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' ";    
  }
  if($unidad>0){
    $sql.=" and e.idoficina in ($unidad) ";
  } 
  
  //echo $sql;
  
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);      
}


function obtenerCantEmpresasOrganismo($unidad,$anioTemporal,$mesTemporal,$area1,$organismoCert,$acumulado,$vista){

  $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));
  $txtOmitirRM=obtieneValorConfig(30);
  $estadosOmitir=obtieneValorConfig(31);

  $dbh = new Conexion();
  $sql="SELECT count(distinct(e.idcliente))as cantidad from ext_certificados e where e.idarea=$area1 and e.idestado not in ($estadosOmitir) and e.norma not like '%$txtOmitirRM%' and e.norma not in ('N/A','') ";
  if($vista==1){
    if($acumulado==0){
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)='$mesTemporal' ";
    }else{
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<='$mesTemporal' ";
    }    
  }else{
    $sql.=" and e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' ";        
  }

  if($unidad>0){
    $sql.=" and e.idoficina in ($unidad) ";
  } 
  if($organismoCert>0){
    $sql.=" and e.idcertificadorexterno in ($organismoCert) ";
  }
  //echo $sql;  
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);      
}


function obtenerCantCertificadosOrganismo($unidad,$anioTemporal,$mesTemporal,$area1,$organismoCert,$acumulado,$vista){
  $dbh = new Conexion();

  $fechaVistaIni=$anioTemporal."-".$mesTemporal."-01";
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaIni.'+1 month'));
  $fechaVistaFin=date('Y-m-d',strtotime($fechaVistaFin.'-1 day'));
  $txtOmitirRM=obtieneValorConfig(30);
  $estadosOmitir=obtieneValorConfig(31);
  
  $sql="SELECT count(*)as cantidad from ext_certificados e where e.idarea=$area1 and e.idestado not in ($estadosOmitir) and e.norma not like '%$txtOmitirRM%' and e.norma not in ('N/A','') ";
  if($vista==1){
    if($acumulado==0){
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)='$mesTemporal' ";
    }else{
      $sql.=" and YEAR(e.fechaemision)='$anioTemporal' and MONTH(e.fechaemision)<='$mesTemporal' ";
    }
  }else{
    $sql.=" and e.fechaemision<='$fechaVistaFin' and e.fechavalido>='$fechaVistaFin' ";            
  }
  if($unidad>0){
    $sql.=" and e.idoficina in ($unidad) ";
  } 
  if($organismoCert>0){
    $sql.=" and e.idcertificadorexterno in ($organismoCert) ";
  }
  //echo $sql;  
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  $cantidad=0;
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cantidad=$row['cantidad'];
  }
  return($cantidad);      
}

function obtener_nombre_proyecto($codigo){
  $dbh = new Conexion();
  $nombre = '';
  $sql="SELECT nombre
  from proyectos_financiacionexterna where codigo=$codigo";
  $stmt = $dbh->prepare($sql);
  $stmt->execute();
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombre=$row['nombre'];
  }
  return $nombre;
}

function calcularValorEnPoncentaje($valor,$total){
  $porcentaje=0;
  if($total>0){
    $porcentaje=($valor*100)/$total;
  }     
  return $porcentaje;
}

?>
