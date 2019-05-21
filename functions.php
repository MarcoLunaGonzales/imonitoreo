<?php

require_once 'conexion.php';

//FUNCION PARA MOSTRAR LA ALERTA CORRESPONDIENTE SUCCESS O ERROR
function showAlertSuccessError($bandera, $url){
   if($bandera==true){
      echo "<script>
         alerts.showSwal('success-message','$url');
      </script>";
   }else{
      echo "<script>
         alerts.showSwal('error-message','$url');
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
   $sql="SELECT abreviatura FROM areas where codigo in ($codigo)";
   $stmt = $dbh->prepare($sql);
   //echo $sql;
   $stmt->execute();
   $cadenaAreas="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $cadenaAreas=$cadenaAreas."-".$row['abreviatura'];
   }
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
   $stmt = $dbh->prepare("SELECT codigo FROM po_fondos where cod_grupo in ($codigo)");
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
   $stmt = $dbh->prepare("SELECT abreviatura FROM po_fondos where cod_grupo in ($codigo)");
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
   $stmt = $dbh->prepare("SELECT abreviatura FROM unidades_organizacionales where codigo in ($codigo)");
   $stmt->execute();
   $nombreX="";
   while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $nombreX.=$row['abreviatura']." - ";
   }
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
  $sql="SELECT IFNULL(sum(ap.value_numerico),0)as cantidad from actividades_poa a, actividades_poaplanificacion ap where a.codigo=ap.cod_actividad and a.cod_indicador='$indicador' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area' ";
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

//ACUMULADO 0=POR MES; 1=ACUMULADO; 2=TODA LA GESTION
function ejecucionPorIndicador($indicador, $area, $unidad, $mes, $acumulado){
  $dbh = new Conexion();
  $sql="SELECT IFNULL(sum(ap.value_numerico),0)as cantidad from actividades_poa a, actividades_poaejecucion ap where a.codigo=ap.cod_actividad and a.cod_indicador='$indicador' and a.cod_unidadorganizacional='$unidad' and a.cod_area='$area' ";
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
  return($cadena);  
}

function obtieneEjecucionSistema($mes,$anio,$clasificador,$unidad,$area,$indicador,$codigoClasificador){
  $dbh = new Conexion();
  $unidadHijos=buscarHijosUO($unidad);
  $valueRegistros=0;
  if($clasificador==3){
    $sql="SELECT count(*)as registros from ext_cursos e where e.id_oficina in ($unidadHijos) and MONTH(e.fecha_inicio)=$mes and YEAR(e.fecha_inicio)=$anio and e.id_programa='$codigoClasificador'";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }
  //ESTA LINEA ES PARA TCP
  if($clasificador==1 && $area==39){
    $sql="SELECT count(*)as registros from ext_planauditorias e where e.id_cliente=$codigoClasificador and e.codigoservicio like '%TCP%' and YEAR(e.fecha_realizada)=$anio and MONTH(e.fecha_realizada)=$mes";
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }
  //ESTA LINEA ES PARA TCS
  if($clasificador==1 && $area==38){
    $sql="SELECT count(*)as registros from ext_planauditorias e where e.id_cliente=$codigoClasificador and e.codigoservicio like '%TCS%' and YEAR(e.fecha_realizada)=$anio and MONTH(e.fecha_realizada)=$mes";
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }

  //ESTA LINEA ES PARA LOS SERVICIOS OI
  if($clasificador==2){
    $sql="SELECT sum(e.cantidad)as registros from ext_servicios e, servicios_oi_detalle sd where e.idclaservicio=sd.codigo and sd.cod_servicio=$codigoClasificador and e.id_oficina in ($unidadHijos) and YEAR(e.fecha_registro)=$anio and MONTH(e.fecha_registro)=$mes;";
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }

  //ESTA LINEA ES PARA LOS SERVICIOS TLQ
  if($clasificador==4){
    $sql="SELECT sum(e.cantidad)as registros from ext_servicios e, servicios_tlq_detalle sd where e.idclaservicio=sd.codigo and sd.cod_servicio=$codigoClasificador and e.id_oficina in ($unidadHijos) and YEAR(e.fecha_registro)=$anio and MONTH(e.fecha_registro)=$mes;";
    //echo $sql;
    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      $valueRegistros=$row['registros'];
    }
  }

  return($valueRegistros);
}

?>
