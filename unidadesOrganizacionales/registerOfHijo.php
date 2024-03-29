<?php

require_once 'conexion.php';
require_once 'functions.php';
$dbh = new Conexion();

$moduleName="Registrar Hijos de Oficina";

$codUnidad=$codigo;
$nombreUnidad=nameUnidad($codUnidad);

// Preparamos
$stmt = $dbh->prepare("SELECT u.codigo, u.nombre, u.abreviatura, 
(select count(*) from unidadesorganizacionales_hijos uh where u.codigo=uh.cod_unidadorganizacionalhijo and uh.cod_unidadorganizacional='$codUnidad')as bandera 
FROM unidades_organizacionales u where u.cod_estado=1 order by 2");
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
                  <h6 class="card-title">Oficina: <?=$nombreUnidad;?></h6>
                  <h6 class="card-title">Por favor active la casilla para registrar el Hijo</h6>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <form method="post" action="unidadesOrganizacionales/saveOfHijo.php">
                      <input type="hidden" name="codigo_unidad" value="<?=$codUnidad?>">
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
                              <input class="form-check-input" type="checkbox" name="hijos[]" value="<?=$codigo?>" <?=($bandera>0)?"checked":"";?> >
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
