<?php
require_once 'conexion.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$table="po_plancuentas";
$moduleName="Plan de Cuentas";

$globalAdmin=$_SESSION["globalAdmin"];

// Preparamos
$sql="SELECT p.codigo, p.nombre, p.nivel,
(select count(*) from plancuentas_costosdirectos pcd where p.codigo=pcd.cod_plancuenta)as bandera FROM $table p order by 1";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('nivel', $nivel);
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
                <table id="tablePaginator" class="table table-striped">
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th>Codigo</th>
                      <th>Nombre</th>
                      <th>Nivel</th>
                      <th class="text-right">Costo Directo</th>
                      <th class="text-right">-</th>
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
                      <td><?=$codigo;?></td>
                      <td><?=$nombre;?></td>
                      <td><?=$nivel;?></td>
                      <td class="td-actions text-right">
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
                  <tfooter>
                  </tfooter>
                </table>
              </div>
            </div>
          </div>
          <?php
          if($globalAdmin==1){
          ?>
          <div class="card-body">
                <a href="?opcion=addCostosDirectos" class="btn">Registrar Costos Directos</a>
          </div>
          <?php
          }
          ?>	  
        </div>
    </div>  
  </div>
</div>
