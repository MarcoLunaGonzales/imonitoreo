<?php

require_once 'conexion.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$table="ibnfinanciero2000.cargos";
$moduleName="Cargos";

$globalAdmin=$_SESSION["globalAdmin"];

// Preparamos
//$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM $table where cod_estado=1 order by 2");
$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM $table where cod_estadoreferencial=1 order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$urlIfinanciero="../ifinanciero/index.php?opcion=cargosLista&q=".$_SESSION["globalUser"];
?>

<div class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title"><?=$moduleName?></h4>
                  <a href="index.php?opcion=listCargosInactivos" class="<?=$buttonCeleste;?> btn-round" title="Ver Cargos Inactivos">
                        <i class="material-icons">bookmark_border</i>
                  </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nombre</th>
                          <th>Abreviatura</th>
                          <th>Funciones</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
						$index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$abreviatura;?></td>
                          <td class="td-actions text-center">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <!--<a href='index.php?opcion=listFunciones&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-info">
                              <i class="material-icons">list</i>
                            </a>-->

                            <?php
                            }
                            ?>
                          </td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                              echo "<small class='text-rose'>Editar desde Financiero</small>";
                            ?>
                            <!--<a href='index.php?opcion=editCargo&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-success">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteCargo&codigo=<?=$codigo;?>')">
                              <i class="material-icons">close</i>
                            </button>-->
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
                    <!--<button class="btn" onClick="location.href='index.php?opcion=registerCargo'">Registrar</button>-->
                    <a href='<?=$urlIfinanciero?>' target="_blank" class="btn btn-warning" title="Lista de Unidades - FINANCIERO">
                              <i class="material-icons">link</i> Cargos del Financiero
                    </a>
                </div>
		          <?php
              }
              ?>
            </div>
          </div>  
        </div>
    </div>
