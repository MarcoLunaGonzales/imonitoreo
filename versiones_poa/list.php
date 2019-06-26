<?php

require_once 'conexion.php';
$dbh = new Conexion();

$table="versiones_poa";
$moduleName="Versiones POA";

$globalAdmin=$_SESSION["globalAdmin"];

// Preparamos
$stmt = $dbh->prepare("SELECT codigo, nombre, abreviatura, fecha FROM $table where cod_estado=1");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('fecha', $fecha);

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
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nombre</th>
                          <th>Abreviatura</th>
                          <th>Fecha Registro</th>
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
                          <td><?=$fecha;?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <button rel="tooltip" class="btn btn-success" onclick="alerts.showSwal('warning-message-and-confirmation2','index.php?opcion=generarVersionPOA&codigo=<?=$codigo;?>')">
                              <i class="material-icons" title="Crar Version">autorenew</i>
                            </button>
                            
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteVersionPOA&codigo=<?=$codigo;?>')">
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
                    <button class="btn" onClick="location.href='index.php?opcion=registerVersionPOA'">Registrar</button>
                </div>
		          <?php
              }
              ?>
            </div>
          </div>  
        </div>
    </div>
