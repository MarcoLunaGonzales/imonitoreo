<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();


//SACAMOS LA CONFIGURACION PARA REDIRECCIONAR EL PON
$stmt = $dbh->prepare("SELECT valor_configuracion FROM configuraciones where id_configuracion=6");
$stmt->execute();
$codigoIndicadorPON=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  $codigoIndicadorPON=$row['valor_configuracion'];
}

$table="poa";
$moduleName="POAI Ejecución";

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
//FIN FECHAS


// Preparamos
$sql="SELECT (select p.nombre from perspectivas p where p.codigo=o.cod_perspectiva)as perspectiva, o.codigo, o.abreviatura, o.descripcion, (SELECT g.nombre from gestiones g WHERE g.codigo=o.cod_gestion) as gestion, i.nombre as nombreindicador, i.codigo as codigoindicador
  FROM objetivos o, indicadores i, indicadores_unidadesareas iua
WHERE o.codigo=i.cod_objetivo and o.cod_estado=1 and i.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' and i.codigo=iua.cod_indicador ";
if($globalAdmin==0){
  $sql.=" and iua.cod_area in ($globalArea) and iua.cod_unidadorganizacional in ($globalUnidad)";
}
$sql.=" GROUP BY i.codigo ORDER BY perspectiva, abreviatura";

//echo $sql;

$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();

// bindColumn

$stmt->bindColumn('perspectiva', $perspectiva);
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('descripcion', $descripcion);
$stmt->bindColumn('gestion', $gestion);
$stmt->bindColumn('nombreindicador', $nombreIndicador);
$stmt->bindColumn('codigoindicador', $codigoIndicador);



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
                  <h4 class="card-title"><?=$moduleName;?></h4>
                  <h6 class="card-title">Mes Ejecucion: <?=$codMesX;?> Fecha Limite Registro: <?=$fechaFinRegistroX;?></h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th data-orderable="false">Gestion</th>
                          <th>Perspectiva</th>
                          <th>Obj. Est.</th>
                          <th>Ind. Estrategico</th>
                          <th class="text-center" data-orderable="false">Actividades</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                      ?>
                        <tr>
                          <td class="text-center"><?=$index;?></td>
                          <td><?=$gestion;?></td>
                          <td><?=$perspectiva;?></td>
                          <td><?=$abreviatura;?></td>
                          <td><?=$nombreIndicador;?></td>
                          <td class="text-center">
                            <a href='index.php?opcion=listActividadesPOAIEjecucion&codigo=<?=$codigoIndicador;?>&codigoPON=<?=$codigoIndicadorPON;?>' rel="tooltip" title="Ver Actividades" class="<?=$buttonDetail;?>">
                              <i class="material-icons">description</i>
                            </a>
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

            </div>
          </div>  
        </div>
    </div>
