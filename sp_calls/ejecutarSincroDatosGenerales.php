<?php

set_time_limit(0);
require_once '../serviciosweb/call_services.php';
require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

?>


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header <?=$colorCard;?> card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Sincronizacion de Datos Generales</h4>
            <h6 class="card-title">Datos a sincronizar: Gestiones, Unidades Organizacionales, Areas, Sectores, Normas, Programas, Servicios, Codigos IAF, Clientes</h6>
          </div>
          <div class="card-body">
                  
<?php

echo "<h6>Hora Inicio Proceso: " . date("Y-m-d H:i:s")."</h6>";

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
echo "Gestiones Sincronizado!!<br>";


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
echo "Areas Sincronizado!!<br>";

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
echo "Unidades Organizacionales Sincronizado!!<br>";



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
echo "Sectores Sincronizado!!<br>";


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
echo "Normas Sincronizado!!<br>";

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
echo "Programas(Cursos) Sincronizado!!<br>";


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
echo "Servicios OI Sincronizado<br>";


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
echo "Servicios TLQ Sincronizado!!<br>";

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
echo "Servicios TCP Sincronizado!!<br>";


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
echo "Servicios TCS Sincronizado!!<br>";


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
echo "Codigos IAF Sincronizado!!<br>";


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
  $nombreX=strtoupper(clean_string($objDet->NombreCliente));
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
echo "Clientes Sincronizado!!<br>";


//PERSONAL

$stmt = $dbh->prepare("ALTER TABLE personal_areas DROP FOREIGN KEY personal_areas_fk1;");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE personal_areas DROP FOREIGN KEY personal_areas_fk2");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE personal_datosadicionales DROP FOREIGN KEY personal_datosadicionales_fk1");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE personal_unidadesorganizacionales DROP FOREIGN KEY personal_unidadesorganizacionales_fk1");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE personal_unidadesorganizacionales DROP FOREIGN KEY personal_unidadesorganizacionales_fk2");
$stmt->execute();


$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey,"accion"=>"ListarPersonal");
$url="http://ibnored.ibnorca.org/wsibno/lista/ws-lst-personal.php";

$tableInsert="personal2";
$json=callService($parametros, $url);
$obj=json_decode($json);

$stmtDel=$dbh->prepare("DELETE FROM $tableInsert");
$flagDel=$stmtDel->execute();

$detalle=$obj->lista;
foreach ($detalle as $objDet){
  $codigoX=$objDet->IdPersonal;
  $nombreX=strtoupper(clean_string($objDet->NombreApellido));
  $idArea=$objDet->IdArea;
  $idOficina=$objDet->IdOficina;
  $cargo=$objDet->Cargo;

  $stmt = $dbh->prepare("INSERT INTO $tableInsert (codigo, nombre, cod_area, cod_unidad) VALUES (:codigo, :nombre, :cod_area, :cod_unidad)");
  $stmt->bindParam(':codigo', $codigoX);
  $stmt->bindParam(':nombre', $nombreX);
  $stmt->bindParam(':cod_area', $idArea);
  $stmt->bindParam(':cod_unidad', $idOficina);
  $flagSuccess=$stmt->execute();
}
echo "Personal Sincronizado!!<br>";

$stmt = $dbh->prepare("ALTER TABLE `personal_areas` ADD CONSTRAINT `personal_areas_fk1` FOREIGN KEY (`cod_personal`) REFERENCES `personal2` (`codigo`);");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `personal_areas` ADD CONSTRAINT `personal_areas_fk2` FOREIGN KEY (`cod_area`) REFERENCES `areas` (`codigo`);");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `personal_datosadicionales` ADD CONSTRAINT `personal_datosadicionales_fk1` FOREIGN KEY (`cod_personal`) REFERENCES `personal2` (`codigo`);");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `personal_unidadesorganizacionales` ADD CONSTRAINT `personal_unidadesorganizacionales_fk1` FOREIGN KEY (`cod_personal`) REFERENCES `personal2` (`codigo`);");
$stmt->execute();
$stmt = $dbh->prepare("ALTER TABLE `personal_unidadesorganizacionales` ADD CONSTRAINT `personal_unidadesorganizacionales_fk2` FOREIGN KEY (`cod_unidad`) REFERENCES `unidades_organizacionales` (`codigo`);");
$stmt->execute();


echo "<h6>Hora Fin Proceso Mayores: " . date("Y-m-d H:i:s")."</h6>";
?>

          </div>
        </div>
      </div>
    </div>  
  </div>
</div>