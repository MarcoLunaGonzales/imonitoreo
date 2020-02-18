<?php

require_once 'conexion.php';
require_once 'styles.php';

$globalAdmin=$_SESSION["globalAdmin"];
$globalGestion=$_SESSION["globalGestion"];
$codigo_proy=$_SESSION["globalProyecto"];
// echo $codigo_proy;
if($codigo_proy==''){
  $codigo_proy=$codigo_proy;
  include("principal_actividades.php");
}else{
  $nombre_proyecto=obtener_nombre_proyecto($codigo_proy);

  $dbh = new Conexion();

  $sqlX="SET NAMES 'utf8'";
  $stmtX = $dbh->prepare($sqlX);
  $stmtX->execute();

  $table="external_costs";
  $moduleName="External Costs - Proyecto ".$nombre_proyecto;

  // Preparamos
  $sql="SELECT e.codigo, e.nombre, e.nombre_en, e.abreviatura, (select g.nombre from gestiones g where g.codigo=e.cod_gestion)as gestion FROM $table e where e.cod_estado=1 and e.cod_gestion='$globalGestion' and cod_proyecto=$codigo_proy";
  //echo $sql;
  $stmt = $dbh->prepare($sql);
  // Ejecutamos
  $stmt->execute();
  // bindColumn
  $stmt->bindColumn('codigo', $codigo);
  $stmt->bindColumn('nombre', $nombre);
  $stmt->bindColumn('nombre_en', $nombreEn);
  $stmt->bindColumn('abreviatura', $abreviatura);
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
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Codigo</th>
                          <th>Gestion</th>
                          <th>Nombre</th>
                          <th>Name</th>
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
                          <td><?=$abreviatura;?></td>
                          <td><?=$gestion;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$nombreEn;?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=editExternalCostsSIS&codigo=<?=$codigo;?>' rel="tooltip" class="<?=$buttonEdit;?>">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteExternalCostsSIS&codigo=<?=$codigo;?>')">
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
                    <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerExternalCostsSIS'">Registrar</button>
              </div>
              <?php
              }
              ?>
		  
            </div>
        </div>  
      </div>
  </div>

<?php } ?>