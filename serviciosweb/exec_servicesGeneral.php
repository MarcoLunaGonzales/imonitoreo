<?php
set_time_limit(0);

require_once 'call_services.php';
require_once '../conexion.php';
require_once '../functions.php';

$dbh = new Conexion();

$sIde = "monitoreo"; 
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17";


//GESTIONES
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"111");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="gestiones";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok gestiones<br>";


//AREAS
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"6");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="areas";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok areas<br>";

//OFICINAS / UNIDADES ORGANIZACIONALES
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"45");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="unidades_organizacionales";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok oficinas<br>";



//SECTORES
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "tipoLista"=>"Sectores"); 
$url="http://ibnored.ibnorca.org/wsibno/catalogo/ws-sector-comite.php";
$tableInsert="sectores";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

foreach ($obj as $objDet){
	$codigoX=$objDet->idSector;
	$nombreX=strtoupper(clean_string($objDet->titulo));
	$abreviaturaX=strtoupper(clean_string($objDet->titulo));
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok sectores<br>";


//NORMAS
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "TipoLista"=>"Todos");
$url="http://ibnored.ibnorca.org/wsibno/catalogo/ws-catalogo-nal.php";
$tableInsert="normas";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdNorma;
	$nombreX=strtoupper(clean_string($objDet->NombreNorma));
	$abreviaturaX=strtoupper($objDet->CodigoNorma);
	$codSectorX=$objDet->IdSector;
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_sector,cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_sector, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_sector', $codSectorX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok normas<br>";

//PROGRAMAS - CURSOS
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"52");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="programas";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok programas<br>";


//SERVICIOS OI
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"107");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="servicios_oi";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok servicios oi<br>";


//SERVICIOS TLQ
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"403");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="servicios_tlq";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok servicios tlq<br>";

//SERVICIOS TCP
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"108");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="servicios_tcp";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok servicios tcp<br>";


//SERVICIOS TCP
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"109");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="servicios_tcs";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok servicios tcs<br>";


//IAF
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"HijoPadre", "padre"=>"755");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="iaf";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "ok IAF<br>";


//CLIENTES
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "lista"=>"Clientes"); 
$url="http://ibnored.ibnorca.org/wsibno/cliente/ws-cliente-listas.php";
$tableInsert="clientes";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdCliente;
	$nombreX=strtoupper(clean_string($objDet->NombreRazon));
	$idCiudad=strtoupper($objDet->IdCiudad);
	$estadoX="1";

	//sacamos la unidad para insertar
	$stmt = $dbh->prepare("SELECT codigo, nombre, cod_unidad FROM ciudades where codigo=:codigo");
	$stmt->bindParam(':codigo',$idCiudad);
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$codigoUnidadX=$row['cod_unidad'];
	}

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, cod_estado, cod_unidad) VALUES (:codigo, :nombre, :cod_estado, :cod_unidad)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$stmt->bindParam(':cod_unidad', $codigoUnidadX);
	$flagSuccess=$stmt->execute();
}
echo "ok Clientes<br>";



/*ESTA TABLA NO CARGAR NUNCA- SI SE CARGA SE DEBEN ACOMODAR MANUALMENTE LOS INDICES DE RELACION CON UNIDADES
//OFICINAS
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "padre"=>"53");
$url="http://ibnored.ibnorca.org/wsibno/clasificador/ws-clasificador-post.php";
$tableInsert="ciudades";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
	$codigoX=$objDet->IdClasificador;
	$nombreX=strtoupper(clean_string($objDet->Descripcion));
	$abreviaturaX=strtoupper($objDet->Abrev);
	$estadoX="1";

	$stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, abreviatura, cod_estado) VALUES (:codigo, :nombre, :abreviatura, :cod_estado)");
	$stmt->bindParam(':codigo', $codigoX);
	$stmt->bindParam(':nombre', $nombreX);
	$stmt->bindParam(':abreviatura', $abreviaturaX);
	$stmt->bindParam(':cod_estado', $estadoX);
	$flagSuccess=$stmt->execute();
}
echo "OK CIUDADES<br>";
*/


?>