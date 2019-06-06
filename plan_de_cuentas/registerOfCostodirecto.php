<?php

require_once 'conexion.php';
require_once 'functions.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$table="po_plancuentas";
$moduleName="Registrar Cuentas de Costos Directos";

// Preparamos
$sql="SELECT p.codigo, p.nombre, p.nivel,
(select count(*) from plancuentas_costosdirectos pcd where p.codigo=pcd.cod_plancuenta)as bandera FROM $table p where p.codigo like '5%' order by 1";

//echo $sql;

$stmt = $dbh->prepare($sql);

// Ejecutamos
$stmt->execute(); 
// bindColumn
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
                  <h6 class="card-title">Por favor active la casilla para registrar el Costo Directo</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form method="post" action="plan_de_cuentas/saveOfCostodirecto.php">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th>Codigo</th>
                          <th>Nombre</th>
                          <th>Nivel</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
						$index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
?>
                        <tr>
                          <td align="center">
                          <div class="form-check">
                            <label class="form-check-label">
                              <input class="form-check-input" type="checkbox" name="cuentas[]" value="<?=$codigo?>" <?=($bandera>0)?"checked":"";?> >
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                          </td>
                          <td><?=$codigo;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$nivel;?></td>
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
                    <button class="btn" type="submit">Guardar</button>
                </div>
			     </form>
            </div>
          </div>  
        </div>
    </div>
