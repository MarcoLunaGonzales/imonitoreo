<?php



require_once 'conexion.php';

require_once 'functions.php';

require_once 'styles.php';



$dbh = new Conexion();



$sqlX="SET NAMES 'utf8'";

$stmtX = $dbh->prepare($sqlX);

$stmtX->execute();



//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON

$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");

$stmt->execute();

$codigoIndicadorPON=0;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

  $codigoIndicadorPON=$row['valor_configuracion'];

}



$codigoIndicador=$codigo;

$nombreIndicador=nameIndicador($codigoIndicador);

$nombreObjetivo=nameObjetivoxIndicador($codigoIndicador);



$table="actividades_poa";

$moduleName="Ejecucion de Actividades POAI";



$globalUser=$_SESSION["globalUser"];

$globalGestion=$_SESSION["globalGestion"];

$globalUnidad=$_SESSION["globalUnidad"];

$globalArea=$_SESSION["globalArea"];

$globalAdmin=$_SESSION["globalAdmin"];



//SACAMOS LAS FECHAS DE REGISTRO DEL MES EN CURSO

$fechaActual=date("Y-m-d");

$sqlFechaEjecucion="SELECT f.mes, f.anio, DATE_FORMAT(f.fecha_fin, '%d/%m')fecha_fin from fechas_registroejecucion f 

where f.fecha_inicio<='$fechaActual' and f.fecha_fin>='$fechaActual'";

//echo $sqlFechaEjecucion;

$stmt = $dbh->prepare($sqlFechaEjecucion);

$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

  $codMesX=$row['mes'];

  $codAnioX=$row['anio'];

  $fechaFinRegistroX=$row['fecha_fin'];

}

$nombreMes=nameMes($codMesX);

//FIN FECHAS



$nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$globalUnidad,$globalArea);





// Preparamos

$sql="SELECT a.codigo, a.orden, a.nombre, (SELECT n.abreviatura from normas n where n.codigo=a.cod_normapriorizada)as normapriorizada,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_normapriorizada)as sectorpriorizado,
(SELECT n.abreviatura from normas n where n.codigo=a.cod_norma)as norma,
(SELECT s.abreviatura from normas n, sectores s where n.cod_sector=s.codigo and n.codigo=a.cod_norma)as sector,
(SELECT t.abreviatura from tipos_seguimiento t where t.codigo=a.cod_tiposeguimiento)as tipodato, 
a.producto_esperado, a.cod_unidadorganizacional, a.cod_area, a.cod_tiporesultado, (1) as datoclasificador,
          (1) as codigodetalleclasificador, a.cod_periodo, a.poai
 from actividades_poa a where a.cod_indicador='$codigoIndicador' and a.cod_estado=1 ";

if($globalAdmin==0){
  $sql.=" and a.cod_area in ($globalArea) and a.cod_unidadorganizacional in ($globalUnidad) and a.cod_personal='$globalUser' ";
}

$sql.=" order by a.cod_unidadorganizacional, a.cod_area, a.orden";
//echo $sql;
$stmt = $dbh->prepare($sql);
$stmt->execute();


$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('orden', $orden);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('normapriorizada', $normaPriorizada);
$stmt->bindColumn('sectorpriorizado', $sectorPriorizado);
$stmt->bindColumn('norma', $norma);
$stmt->bindColumn('sector', $sector);
$stmt->bindColumn('tipodato', $tipoDato);
$stmt->bindColumn('producto_esperado', $productoEsperado);
$stmt->bindColumn('cod_unidadorganizacional', $codUnidad);
$stmt->bindColumn('cod_area', $codArea);
$stmt->bindColumn('cod_tiporesultado', $codTipoDato);
$stmt->bindColumn('datoclasificador', $datoclasificador);
$stmt->bindColumn('codigodetalleclasificador', $codigodetalleclasificador);
$stmt->bindColumn('cod_periodo', $codPeriodo);
$stmt->bindColumn('poai', $poai);

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

                  <h4 class="card-title text-danger">Mes Ejecucion: <?=$nombreMes;?> - Fecha Limite: <?=$fechaFinRegistroX;?></h4>

                  <h6 class="card-title">Objetivo: <?=$nombreObjetivo?></h6>

                  <h6 class="card-title">Indicador: <?=$nombreIndicador?></h6>





                </div>

                <div class="card-body">

                  <div class="table-responsive">

                    <table class="table table-condensed table-striped" id="tablePaginatorFixed">

                      <thead>

                        <tr>

                          <th class="text-center">-</th>

                          <th></th>

                          <th></th>

                          <th></th>

                          <th></th>

                          <th></th>

                          <th></th>

                          <th colspan="2" class="font-weight-bold table-success small">Ejecutado</th>

                          <th></th>

                          <th></th>

                        </tr>

                        <tr>

                          <th class="text-center">-</th>

                          <th>Area</th>

                          <th>Actividad</th>

                          <th>Producto Esperado</th>

                          <th>Seg.</th>

                          <th>Clasificador</th>

                          <th class="table-warning">Plan</th>

                          <th class="table-success">Sist.</th>

                          <th class="table-success">POAI</th>

                          <th>Explicacion<br>Logro</th>

                          <th>Archivo</th>

                        </tr>

                      </thead>

                      <tbody>

                      <?php

                        $index=1;

                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {

                          $abrevArea=abrevArea($codArea);

                          $abrevUnidad=abrevUnidad($codUnidad);



                          $codigoTablaClasificador=obtieneCodigoClasificador($codigoIndicador,$codUnidad,$codArea);

                          $nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$codUnidad,$codArea);

                          $nombreDatoClasificador=obtieneDatoClasificador($codigodetalleclasificador,$nombreTablaClasificador);





                          //SACAMOS LA PLANIFICACION

                          if($codPeriodo==0){

                            $sqlRecupera="SELECT value_numerico, fecha_planificacion from actividades_poaplanificacion where cod_actividad='$codigo' and mes='0'";                            

                          }else{

                            $sqlRecupera="SELECT value_numerico, fecha_planificacion from actividades_poaplanificacion where cod_actividad='$codigo' and mes='$codMesX'";

                          }



                          //echo $sqlRecupera;

                          $stmtRecupera = $dbh->prepare($sqlRecupera);

                          $stmtRecupera->execute();

                          $valueNumero=0;

                          while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {

                            $valueNumero=$rowRec['value_numerico'];

                            $fechaPlanificacion=$rowRec['fecha_planificacion'];

                          }



                          $sqlRecupera="SELECT value_numerico, descripcion, archivo, fecha_ejecucion from actividades_poaejecucion where cod_actividad=:cod_actividad and mes=:cod_mes";

                          $stmtRecupera = $dbh->prepare($sqlRecupera);

                          $stmtRecupera->bindParam(':cod_actividad',$codigo);

                          $stmtRecupera->bindParam(':cod_mes',$codMesX);

                          $stmtRecupera->execute();

                          $valueNumeroEj=0;

                          $descripcionLogroEj="";

                          $archivoEj="";

                          $fechaEjecucion="";

                          while ($rowRec = $stmtRecupera->fetch(PDO::FETCH_ASSOC)) {

                            $valueNumeroEj=$rowRec['value_numerico'];

                            $descripcionLogroEj=$rowRec['descripcion'];

                            $archivoEj=$rowRec['archivo'];

                            $fechaEjecucion=$rowRec['fecha_ejecucion'];



                          }

                          //FIN PLANIFICACION



                          $valueEjecutadoSistema=0;

                          if($codigoTablaClasificador!=0){

                            $valueEjecutadoSistema=obtieneEjecucionSistema($codMesX,$codAnioX,$codigoTablaClasificador,$codUnidad,$codArea,$codigoIndicador,$codigodetalleclasificador);

                          }

                      ?>

                        <tr>

                          <td class="text-center"><?=$index;?></td>

                          <td class="text-left small"><?=$abrevArea."-".$abrevUnidad;?></td>

                          <td class="text-left font-weight-bold small"><?=$nombre;?></td>

                          <td class="text-left small"><?=$productoEsperado;?></td>

                          <td class="text-left small"><?=$tipoDato;?></td>

                          <td class="text-left small"><?=$datoclasificador;?>(<?=$codigodetalleclasificador;?>)</td>

                          <?php

                          if($codPeriodo==0 && $poai==1){

                            $nombreEstadoPOA=nameEstadoPOA($valueNumero);

                          ?>

                          <td class="text-left table-warning font-weight-bold">

                            <?=$nombreEstadoPOA;?>

                            <?=$fechaPlanificacion;?>

                          </td>

                          <?php

                          }else{

                          ?>

                          <td class="text-center table-warning font-weight-bold">

                            <?=($valueNumero==0)?"-":formatNumberDec($valueNumero);?>

                          </td>

                          <?php

                          }

                          ?>

                            <td class="text-center table-success font-weight-bold">

                              <?=($valueEjecutadoSistema==0)?"-":formatNumberDec($valueEjecutadoSistema);?>

                            </td>

                            <?php

                            if($codPeriodo==0 && $poai==1){

                              $nombreEstadoPOAEj=nameEstadoPOA($valueNumeroEj);

                            ?>

                            <td class="text-center table-success font-weight-bold">

                            <?=$nombreEstadoPOAEj;?>

                            <?=$fechaEjecucion;?>

                            </td>

                            <?php

                            }else{

                            ?>

                            <td class="text-center table-success font-weight-bold"">

                              <?=($valueNumeroEj==0)?"-":formatNumberDec($valueNumeroEj);?>

                            </td>

                            <?php

                            }

                            ?>

                            <td><?=$descripcionLogroEj?></td>

                          <?php

                            if($archivoEj!=""){

                                $iconCheckFile="attach_file";

                              }else{

                                $iconCheckFile="";

                              }

                          ?>

                            <td><div class="card-icon">

                                <a href="filesApp/<?=$archivoEj;?>" target="_blank">

                                  <i class="material-icons"><?=$iconCheckFile;?></i>

                                </a>

                              </div>

                            </td>

                        </tr>

            <?php

            							$index++;

            						}

            ?>

                      </tbody>

                    </table>

                  </div>

                </div>

              </div>

        				<div class="card-body">

                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerPOAIEjecucion&codigo=<?=$codigoIndicador?>'">Registrar Ejecucion</button>   

                </div>

            </div>

          </div>  

        </div>

    </div>

