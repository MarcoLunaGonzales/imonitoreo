<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();

$table="objetivos";
$moduleName="Objetivos Operativos";

// Preparamos
$sql="SELECT o.codigo, o.nombre, o.descripcion, (SELECT g.nombre from gestiones g WHERE g.codigo=o.cod_gestion) as gestion, i.nombre as nombreindicador, (select o.nombre from objetivos o where o.codigo=i.cod_objetivo)objetivoest
  FROM objetivos o, indicadores i 
WHERE o.cod_indicador=i.codigo and o.cod_estado=1 and o.cod_tipoobjetivo=2 ORDER BY o.nombre";
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('descripcion', $descripcion);
$stmt->bindColumn('gestion', $gestion);
$stmt->bindColumn('nombreindicador', $nombreIndicador);
$stmt->bindColumn('objetivoest', $objetivoEst);

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
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Gestion</th>
                          <th>Obj. Estrategico</th>
                          <th>Ind. Estrategico</th>
                          <th>Nombre</th>
                          <th>Descripcion</th>
                          <th class="text-center">Hitos</th>
                          <th class="text-center">Indicadores</th>
                          <th class="text-right">Actions</th>
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
                          <td><?=$objetivoEst;?></td>
                          <td><?=$nombreIndicador;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$descripcion;?></td>
                          <?php
                          $stmt2 = $dbh->prepare("select o.cod_hito, h.abreviatura from objetivos_hitos o, hitos h where o.cod_hito=h.codigo and o.cod_objetivo='$codigo' ORDER BY 2");
                          $stmt2->execute();
                          $cadenaHitos="";
                          while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                            $codigoX=$row2['cod_hito'];
                            $nombreX=$row2['abreviatura'];
                            $cadenaHitos.=$nombreX." - ";
                          }
                          ?>
                          <td><?=$cadenaHitos;?></td>
                          <td class="text-center">
                            <a href='index.php?opcion=listIndicadoresOp&codigo=<?=$codigo;?>' rel="tooltip" title="Ver Indicadores" class="<?=$buttonDetail;?>">
                              <i class="material-icons">description</i>
                            </a>
                          </td>
                          <td class="td-actions text-right">
                            <a href='index.php?opcion=editObjetivoOp&codigo=<?=$codigo;?>' rel="tooltip" class="<?=$buttonEdit;?>">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteObjetivoOp&codigo=<?=$codigo;?>')">
                              <i class="material-icons">close</i>
                            </button>
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
                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerObjetivoOp'">Registrar</button>
                </div>
            </div>
          </div>  
        </div>
    </div>
