<?php

require_once 'conexion.php';
require_once 'styles.php';

$globalAdmin=$_SESSION["globalAdmin"];

$dbh = new Conexion();

$table="objetivos";
$moduleName="Objetivos Estrategicos";


$globalGestion=$_SESSION["globalGestion"];

// Preparamos
$sql="SELECT o.codigo, o.nombre, (SELECT p.nombre from perspectivas p WHERE p.codigo=o.cod_perspectiva) as perspectiva, o.abreviatura, o.descripcion, (SELECT g.nombre from gestiones g WHERE g.codigo=o.cod_gestion) as gestion
  FROM objetivos o WHERE o.cod_estado=1 and o.cod_tipoobjetivo=1 and o.cod_gestion='$globalGestion' ORDER BY perspectiva, o.abreviatura";
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('perspectiva', $perspectiva);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('descripcion', $descripcion);
$stmt->bindColumn('gestion', $gestion);
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
                    <table class="table table-striped" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center" data-orderable="false">-</th>
                          <th data-orderable="false">Gestion</th>
                          <th>Perspectiva</th>
                          <th>Abreviatura</th>
                          <th>Nombre</th>
                          <th data-orderable="false">Descripcion</th>
                          <th class="text-center" data-orderable="false">Hitos</th>
                          <th class="text-center" data-orderable="false">Indicadores</th>
                          <th class="text-right" data-orderable="false">Actions</th>
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
                            <a href='index.php?opcion=listIndicadores&codigo=<?=$codigo;?>' rel="tooltip" title="Ver Indicadores" class="<?=$buttonDetail;?>">
                              <i class="material-icons">description</i>
                            </a>
                          </td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=editObjetivo&codigo=<?=$codigo;?>' rel="tooltip" class="<?=$buttonEdit;?>">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteObjetivo&codigo=<?=$codigo;?>')">
                              <i class="material-icons">close</i>
                            </button>
                            <?php
                            }
                            ?>
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
              <?php
              if($globalAdmin==1){
              ?>
				      <div class="card-body">
                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerObjetivo'">Registrar</button>
              </div>
              <?php
              }
              ?>
            </div>
          </div>  
        </div>
    </div>
