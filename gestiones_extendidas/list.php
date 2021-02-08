<?php

require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';
$dbh = new Conexion();

$table="gestiones_extendidas";
$moduleName="Gestiones Extendidas";


$globalAdmin=$_SESSION["globalAdmin"];
// Preparamos
$sql="SELECT id_gestion, anio_inicio, mes_inicio,anio_final,mes_final FROM $table order by 1 desc";
//echo $sql;
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('id_gestion', $id_gestion);
$stmt->bindColumn('anio_inicio', $anio_inicio);
$stmt->bindColumn('mes_inicio', $mes_inicio);
$stmt->bindColumn('anio_final', $anio_final);
$stmt->bindColumn('mes_final', $mes_final);

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
                    <table class="table table-striped" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Gestión</th>
                          <th>Anio Inicio</th>
                          <th>Mes Inicio</th>
                          <th>Anio Final</th>
                          <th>Mes Final</th>
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
                          <td><?=nameGestion($id_gestion);?></td>
                          <td><?=$anio_inicio;?></td>
                          <td><?=abrevMes($mes_inicio);?></td>
                          <td><?=$anio_final;?></td>
                          <td><?=abrevMes($mes_final);?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=configurarGestionExtendida&id_gestion=<?=$id_gestion;?>' rel="tooltip" class="btn btn-success" title="Editar Gestion Extendida">
                              <i class="material-icons">edit</i>
                            </a>
                            <a href='gestiones_extendidas/delete.php?id_gestion=<?=$id_gestion;?>' rel="tooltip" class="btn btn-danger" title="Eliminar Gestion Extendida">
                              <i class="material-icons">remove</i>
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
				<div class="card-body">
                    <button class="btn" onClick="location.href='index.php?opcion=registerGestionExtendida'">Registrar</button>
                    <button class="btn btn-danger" onClick="location.href='index.php?opcion=listGestiones'">Volver</button>
                </div>
			            
            </div>
          </div>  
        </div>
    </div>
