<?php

require_once 'conexion.php';
$dbh = new Conexion();

$table="normas";
$moduleName="Definir Normas Priorizadas";

// Preparamos
$stmt = $dbh->prepare("SELECT n.codigo, n.nombre, n.abreviatura, 
(select count(*) from normas_priorizadas np where n.codigo=np.codigo)as banderapriorizada, 
(select s.nombre from sectores s where s.codigo=n.cod_sector)as sector FROM $table n where n.cod_estado=1 order by 5,2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('banderapriorizada', $banderapriorizada);
$stmt->bindColumn('sector', $sector);

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
                  <h6 class="card-title">Por favor active la casilla para definir las normas priorizadas</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form method="post" action="normas/savePriorizada.php">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
                          <th>Sector</th>
                          <th>Nombre</th>
                          <th>Abreviatura</th>
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
                              <input class="form-check-input" type="checkbox" name="priorizada[]" value="<?=$codigo?>" <?=($banderapriorizada>0)?"checked":"";?> >
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                          </td>
                          <td><?=$sector;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$abreviatura;?></td>
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
