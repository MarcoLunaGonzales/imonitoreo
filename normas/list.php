<?php

require_once 'conexion.php';
$dbh = new Conexion();

$table="normas";
$moduleName="Normas";

// Preparamos
$stmt = $dbh->prepare("SELECT n.codigo, n.nombre, n.abreviatura, 
(select s.nombre from sectores s where s.codigo=n.cod_sector)as sector,
(select count(*) from normas_priorizadas np where np.codigo=n.codigo)as priorizada FROM $table n where n.cod_estado=1 order by 4,2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('sector', $sector);
$stmt->bindColumn('priorizada', $bandera);


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
                          <th class="text-center">-</th>
                          <th>Sector</th>
                          <th>Nombre</th>
                          <th>Abreviatura</th>
                          <th>Norma Priorizada</th>
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
                          <td><?=$sector;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$abreviatura;?></td>
                          <td>
                            <div class="card-icon">
                              <i class="material-icons"><?=$iconCheck;?></i>
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
              <?php
              if($globalAdmin==1){
              ?>
      				<div class="card-body">
                <button class="btn" onClick="location.href='index.php?opcion=registerNormaPriorizada'">Registrar Normas Priorizadas</button>
              </div>
              <?php
              }
              ?>
            </div>
          </div>  
        </div>
    </div>
