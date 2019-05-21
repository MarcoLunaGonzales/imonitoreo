<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();

$table="tipos_seguimiento";
$moduleName="Tipos de Seguimiento";

// Preparamos
$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura FROM $table where cod_estado=1");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);

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
                    <table class="table" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center" data-orderable="false">-</th>
                          <th>Nombre</th>
                          <th>Abreviatura</th>
                          <th class="text-right" data-orderable="false">Actions</th>
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
                          <td class="td-actions text-right">
                            <a href='index.php?opcion=editTiposSeg&codigo=<?=$codigo;?>' rel="tooltip" class="<?=$buttonEdit;?>">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteTiposSeg&codigo=<?=$codigo;?>')">
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
                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerTiposSeg'">Registrar</button>
                </div>
			  
            </div>
          </div>  
        </div>
    </div>
