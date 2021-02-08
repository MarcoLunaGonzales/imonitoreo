<?php

require_once 'conexion.php';
require_once 'styles.php';

$dbh = new Conexion();

$globalAdmin=$_SESSION["globalAdmin"];
$globalGestion=$_SESSION["globalGestion"];
// $codigo_proy=$codigo;
$codigo_proy=$_SESSION["globalProyecto"];

//echo "cod proye: ".$codigo_proy." fin";

if($codigo_proy=="" || $codigo_proy=='' || $codigo_proy=="0"){
  $codigo_proy=$codigo_proy;
  include("principal_actividades.php");
}else{
  
  $nombre_proyecto=obtener_nombre_proyecto($codigo_proy);

  $sqlX="SET NAMES 'utf8'";
  $stmtX = $dbh->prepare($sqlX);
  $stmtX->execute();


  $table="componentessis";
  $moduleName="Actividades - Proyecto ".$nombre_proyecto;

  // Preparamos
  $sql="SELECT cp.codigo, cp.nombre, cp.abreviatura, cp.nivel, (select abreviatura 
  from componentessis cpc where cp.cod_padre=cpc.codigo)cod_padre, partida, (select p.nombre from personal2 p where p.codigo=cp.cod_personal)as personal, (select g.nombre from gestiones g where g.codigo=cp.cod_gestion)as gestion FROM $table cp where cp.cod_estado=1 and cp.cod_gestion='$globalGestion' and cod_proyecto=$codigo_proy;";
//  echo $sql;
  $stmt = $dbh->prepare($sql);
  // Ejecutamos
  $stmt->execute();
  // bindColumn
  $stmt->bindColumn('codigo', $codigo);
  $stmt->bindColumn('nombre', $nombre);
  $stmt->bindColumn('abreviatura', $abreviatura);
  $stmt->bindColumn('nivel', $nivel);
  $stmt->bindColumn('cod_padre', $cod_padre);
  $stmt->bindColumn('partida', $partida);
  $stmt->bindColumn('personal', $personal);
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
                           <th>Codigo</th>
                           <th>Gestion</th>
                            <th>Nombre</th>
                            <th>Partida</th>
                            <th data-orderable="false">Nivel</th>
                            <th data-orderable="false">Padre</th>
                            <th data-orderable="false">Responsable</th>
                            <th class="text-right" data-orderable="false">Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                        	$index=1;
                        	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                        ?>
                          <tr>
                            <td><?=$abreviatura;?></td>
                            <td><?=$gestion;?></td>
                            <td><?=$nombre;?></td>
                            <td><?=$partida;?></td>
                            <td><?=$nivel;?></td>
                            <td><?=$cod_padre;?></td>
                            <td><?=$personal;?></td>
                            <td class="td-actions text-right">
                              <?php
                              if($globalAdmin==1){
                              ?>
                              <a href='index.php?opcion=editComponenteSIS&codigo=<?=$codigo;?>' rel="tooltip" class="<?=$buttonEdit;?>">
                                <i class="material-icons">edit</i>
                              </a>
                              <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteComponenteSIS&codigo=<?=$codigo;?>')">
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
                      <button class="<?=$button;?>" onClick="location.href='index.php?opcion=registerComponenteSIS'">Registrar</button>
                  </div>
                <?php
                }
                ?>
              </div>
          </div>  
    </div>
  </div>

<?php } ?>