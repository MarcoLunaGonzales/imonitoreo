<?php

require_once 'conexion.php';
$dbh = new Conexion();

$table="areas";
$moduleName="Areas";

$globalAdmin=$_SESSION["globalAdmin"];

// Preparamos
$stmt = $dbh->prepare("SELECT a.codigo, a.nombre, a.abreviatura,
(select count(*) from areas_poa apoa where a.codigo=apoa.cod_area)as bandera FROM $table a where a.cod_estado=1 order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('bandera', $bandera);


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
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nombre</th>
                          <th>Abreviatura</th>
                          <th class="text-right">POA</th>
                          <th class="text-right">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
						$index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $iconCheck="";
                          if($bandera>0){
                            $iconCheck="check_circle_outline";
                          }else{
                            $iconCheck="";
                          }
?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$abreviatura;?></td>
                          <td class="td-actions text-right">
                            <div class="card-icon">
                              <i class="material-icons"><?=$iconCheck;?></i>
                            </div>
                          </td>

                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=registerOfCargo&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-success" title="Registrar Cargos">
                              <i class="material-icons">playlist_add</i>
                            </a>
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
                    <button class="btn" onClick="location.href='index.php?opcion=registerAreaPOA'">Registrar Areas para POA</button>
              </div>
              <?php
              }
              ?>
			  
            </div>
          </div>  
        </div>
    </div>
