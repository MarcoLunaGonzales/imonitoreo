<?php

require_once 'conexion.php';
require_once 'functions.php';
$dbh = new Conexion();

$table="personal_areas";
$moduleName="Registrar Areas Adicionales por Persona";

$codPersonal=$codigo;
$nombrePersonal=namePersonal($codPersonal);

// Preparamos
$sql="SELECT a.codigo, a.nombre, a.abreviatura, (select count(*) from personal_areas pa where a.codigo=pa.cod_area and pa.cod_personal='$codPersonal')as bandera FROM areas a where a.cod_estado=1 order by 2";
$stmt = $dbh->prepare($sql);
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
                  <h4 class="card-title">Persona: <?=$nombrePersonal;?></h4>
                  <h6 class="card-title">Por favor active la casilla para registrar el Area</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form method="post" action="personal/saveOfArea.php">
                      <input type="hidden" name="cod_personal" value="<?=$codigo?>">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">-</th>
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
                              <input class="form-check-input" type="checkbox" name="areas[]" value="<?=$codigo?>" <?=($bandera>0)?"checked":"";?> >
                              <span class="form-check-sign">
                                <span class="check"></span>
                              </span>
                            </label>
                          </div>
                          </td>
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
