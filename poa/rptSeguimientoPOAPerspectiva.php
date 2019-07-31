<?php
set_time_limit(0);

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../functionsPOSIS.php';
require_once '../styles.php';

session_start();

$gestionX=$_POST["gestion"];
$mes=$_POST["mes"];
$unidadOrganizacionalArray=$_POST["unidad_organizacional"];
$areasArray=$_POST["areas"];
$version=$_POST["version"];

$unidadOrganizacionalArray=implode(",", $unidadOrganizacionalArray);
$areasArray=implode(",", $areasArray);

$nameUnidades=abrevUnidad($unidadOrganizacionalArray);
$nameAreas=abrevArea($areasArray);

$anio=nameGestion($gestionX);

$dbh = new Conexion();
$moduleName="Seguimiento POA - $mes $anio";

//DEFINIMOS VARIABLES DE SESION
//echo $fondoArray."fondoArray";
$_SESSION['anioTemporal']=$anio;
$_SESSION['mesTemporal']=$mes;
$_SESSION['versionTemporal']=$version;



$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalPerfil=$_SESSION["globalPerfil"];

//$globalUnidadesReports=$_SESSION["globalUnidadesReports"];
//$globalAreasReports=$_SESSION["globalAreasReports"];

$globalUnidadesReports=$unidadOrganizacionalArray;
$globalAreasReports=$areasArray;

$_SESSION["globalUnidadesReports"]=$unidadOrganizacionalArray;
$_SESSION["globalAreasReports"]=$areasArray;

$globalAdmin=$_SESSION["globalAdmin"];
$globalUserPON=$_SESSION["globalUserPON"];

$indicadoresOmitir=obtieneValorConfig(26);


$sql="SELECT count(distinct(i.codigo))as contador, o.cod_perspectiva
    FROM objetivos o, indicadores i, indicadores_unidadesareas iua
  WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador";
if($globalAdmin==0){
  $sql.=" and iua.cod_area in ($globalAreasReports) and iua.cod_unidadorganizacional in ($globalUnidadesReports) ";
}
$sql.=" group by o.cod_perspectiva";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stmt->bindColumn('cod_perspectiva', $cod_perspectiva);
$stmt->bindColumn('contador', $contador);
$cantIndicadoresCli=0;
$cantIndicadoresFin=0;
$cantIndicadoresIns=0;
$cantIndicadoresProc=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  if($cod_perspectiva==3){
    $cantIndicadoresCli=$contador;
  }
  if($cod_perspectiva==4){
    $cantIndicadoresFin=$contador;
  }
  if($cod_perspectiva==1){
    $cantIndicadoresIns=$contador;
  }
  if($cod_perspectiva==2){
    $cantIndicadoresProc=$contador;
  }
}
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
            <h4 class="card-title"><?=$moduleName?></h4>
            <h6 class="card-title">Unidad: <?=$nameUnidades;?> Area: <?=$nameAreas;?></h6>

          </div>



          <div class="row">
            <div class="col-lg-5 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                  <div class="card-icon">
                    <!--a href="rptSeguimientoPOA.php?gestion=<?=$gestionX;?>&mes=<?=$mes;?>&version=<?=$version;?>&perspectiva=3" target="_BLANK">
                    </a-->
                    <i class="material-icons">person_pin</i>
                  </div>
                  <p class="card-category">Perspectiva</p>
                  <h3 class="card-title">Clientes</h3>
                </div>
                <div class="card-body">
                  <ol>
                  <?php
                  $codigoPerspectiva=3;
                  $sql="SELECT i.nombre as nombreindicador, i.codigo as codigoindicador, o.abreviatura
                      FROM objetivos o, indicadores i, indicadores_unidadesareas iua
                    WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador and o.cod_perspectiva in ($codigoPerspectiva)";
                  $sql.=" and iua.cod_area in ($areasArray) and iua.cod_unidadorganizacional in ($unidadOrganizacionalArray) ";
                  if($globalPerfil==7){
                    $sql.=" and i.codigo not in ($indicadoresOmitir)";
                  }
                  $sql.=" group by i.codigo ORDER BY o.abreviatura, i.nombre";
                  //echo $sql;
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('nombreindicador', $nombreIndicador);
                  $stmt->bindColumn('codigoindicador', $codigoIndicador);
                  $stmt->bindColumn('abreviatura', $abreviaturaObj);
                  while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                    $url="../graficos/rptPOA.php?tipo=1&codigo=$codigoIndicador&gestion=$gestionX&anio=$anio&mes=$mes&version=$version&perspectiva=$codigoPerspectiva&codActividad=0";

                  ?>
                    <li class="text-left small"><a href='<?=$url;?>' rel="tooltip" target="_BLANK">
                      <?=$abreviaturaObj." - ".$nombreIndicador." (".$codigoIndicador.")";?>
                      </a></li>                
                  <?php
                  }
                  ?>
                  </ol>
                </div>
                <div class="card-footer">
                  <div class="card-category">
                    <i class="material-icons text-danger">apps</i>
                    # Indicadores: <?=$cantIndicadoresCli;?>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-5 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <!--a href="rptSeguimientoPOA.php?gestion=<?=$gestionX;?>&mes=<?=$mes;?>&version=<?=$version;?>&perspectiva=4" target="_BLANK">
                      
                    </a-->
                    <i class="material-icons">attach_money</i>
                  </div>
                  <p class="card-category">Perspectiva</p>
                  <h3 class="card-title">Financiera</h3>
                </div>

                <div class="card-body">
                  <ol>
                  <?php
                  $codigoPerspectiva=4;
                  $sql="SELECT i.nombre as nombreindicador, i.codigo as codigoindicador, o.abreviatura
                      FROM objetivos o, indicadores i, indicadores_unidadesareas iua
                    WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador and o.cod_perspectiva in ($codigoPerspectiva)";
                  $sql.=" and iua.cod_area in ($areasArray) and iua.cod_unidadorganizacional in ($unidadOrganizacionalArray) ";
                  if($globalPerfil==7){
                    $sql.=" and i.codigo not in ($indicadoresOmitir)";
                  }
                  $sql.=" group by i.codigo ORDER BY o.abreviatura, i.nombre";
                  //echo $sql;
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('nombreindicador', $nombreIndicador);
                  $stmt->bindColumn('codigoindicador', $codigoIndicador);
                  $stmt->bindColumn('abreviatura', $abreviaturaObj);
                  while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                    $url="../graficos/rptPOA.php?tipo=1&codigo=$codigoIndicador&gestion=$gestionX&anio=$anio&mes=$mes&version=$version&perspectiva=$codigoPerspectiva&codActividad=0";
                  ?>
                    <li class="text-left small"><a href='<?=$url;?>' rel="tooltip" target="_BLANK">
                      <?=$abreviaturaObj." - ".$nombreIndicador." (".$codigoIndicador.")";?>
                      </a></li>                
                  <?php
                  }
                  ?>
                  </ol>
                </div>


                <div class="card-footer">
                  <div class="card-category">
                    <i class="material-icons">apps</i>
                    # Indicadores: <?=$cantIndicadoresFin;?>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-5 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                  <div class="card-icon">
                    <!--a href="rptSeguimientoPOA.php?gestion=<?=$gestionX;?>&mes=<?=$mes;?>&version=<?=$version;?>&perspectiva=1" target="_BLANK">
                    </a-->
                    <i class="material-icons">store</i>
                  </div>
                  <p class="card-category">Perspectiva</p>
                  <h3 class="card-title">Institucional</h3>
                </div>

                <div class="card-body">
                  <ol>
                  <?php
                  $codigoPerspectiva=1;

                  $sql="SELECT i.nombre as nombreindicador, i.codigo as codigoindicador, o.abreviatura
                      FROM objetivos o, indicadores i, indicadores_unidadesareas iua
                    WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador and o.cod_perspectiva in ($codigoPerspectiva)";
                  $sql.=" and iua.cod_area in ($areasArray) and iua.cod_unidadorganizacional in ($unidadOrganizacionalArray) ";
                  if($globalPerfil==7){
                    $sql.=" and i.codigo not in ($indicadoresOmitir)";
                  }
                  $sql.=" group by i.codigo ORDER BY o.abreviatura, i.nombre";
                  //echo $sql;
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('nombreindicador', $nombreIndicador);
                  $stmt->bindColumn('codigoindicador', $codigoIndicador);
                  $stmt->bindColumn('abreviatura', $abreviaturaObj);
                  while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                    $url="../graficos/rptPOA.php?tipo=1&codigo=$codigoIndicador&gestion=$gestionX&anio=$anio&mes=$mes&version=$version&perspectiva=$codigoPerspectiva&codActividad=0";

                  ?>
                    <li class="text-left small"><a href='<?=$url;?>' rel="tooltip" target="_BLANK">
                      <?=$abreviaturaObj." - ".$nombreIndicador." (".$codigoIndicador.")";?>
                      </a></li>                
                  <?php
                  }
                  ?>
                  </ol>
                </div>

                <div class="card-footer">
                  <div class="card-category">
                    <i class="material-icons">apps</i>
                    # Indicadores: <?=$cantIndicadoresIns;?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-6">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <!--a href="rptSeguimientoPOA.php?gestion=<?=$gestionX;?>&mes=<?=$mes;?>&version=<?=$version;?>&perspectiva=2" target="_BLANK">
                    </a-->
                    <i class="material-icons">blur_on</i>
                  </div>
                  <p class="card-category">Perspectivas</p>
                  <h3 class="card-title">Procesos Internos</h3>
                </div>

                <div class="card-body">
                  <ol>
                  <?php
                  $codigoPerspectiva=2;
                  $sql="SELECT i.nombre as nombreindicador, i.codigo as codigoindicador, o.abreviatura
                      FROM objetivos o, indicadores i, indicadores_unidadesareas iua
                    WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador and o.cod_perspectiva in ($codigoPerspectiva)";
                  $sql.=" and iua.cod_area in ($areasArray) and iua.cod_unidadorganizacional in ($unidadOrganizacionalArray) ";
                  if($globalPerfil==7){
                    $sql.=" and i.codigo not in ($indicadoresOmitir)";
                  }
                  $sql.=" group by i.codigo ORDER BY o.abreviatura, i.nombre";
                  //echo $sql;
                  $stmt = $dbh->prepare($sql);
                  $stmt->execute();
                  $stmt->bindColumn('nombreindicador', $nombreIndicador);
                  $stmt->bindColumn('codigoindicador', $codigoIndicador);
                  $stmt->bindColumn('abreviatura', $abreviaturaObj);
                  while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                  $url="../graficos/rptPOA.php?tipo=1&codigo=$codigoIndicador&gestion=$gestionX&anio=$anio&mes=$mes&version=$version&perspectiva=$codigoPerspectiva&codActividad=0";
                  ?>
                    <li class="text-left small"><a href='<?=$url;?>' rel="tooltip" target="_BLANK">
                      <?=$abreviaturaObj." - ".$nombreIndicador." (".$codigoIndicador.")";?>
                      </a></li>                
                  <?php
                  }
                  ?>
                  </ol>
                </div>

                <div class="card-footer">
                  <div class="card-category">
                    <i class="material-icons">blur_on</i>
                    # Indicadores: <?=$cantIndicadoresProc;?>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>  
  </div>
</div>

