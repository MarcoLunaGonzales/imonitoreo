<?php

require_once 'conexion.php';
$dbh = new Conexion();

// Preparamos
$stmt = $dbh->prepare("SELECT anio, mes, fecha_inicio, fecha_fin FROM fechas_registroejecucion order by 1,2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('anio', $anio);
$stmt->bindColumn('mes', $mes);
$stmt->bindColumn('fecha_inicio', $fechaInicio);
$stmt->bindColumn('fecha_fin', $fechaFin);

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
                  <h4 class="card-title">Fechas de Registro de Ejecucion de POA</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Año</th>
                          <th>Mes</th>
                          <th>Fecha Inicio</th>
                          <th>Fecha Fin</th>
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
                          <td><?=$anio;?></td>
                          <td><?=$mes;?></td>
                          <td><?=$fechaInicio;?></td>
                          <td><?=$fechaFin;?></td>
                          <td class="td-actions text-right">
                            <a href='index.php?opcion=editFechaRegistro&anio=<?=$anio;?>&mes=<?=$mes;?>' rel="tooltip" class="btn btn-success">
                              <i class="material-icons">edit</i>
                            </a>
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
            </div>
          </div>  
        </div>
    </div>
