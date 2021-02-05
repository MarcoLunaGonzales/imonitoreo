<?php

require_once 'conexion.php';
$dbh = new Conexion();

$table="gestiones";
$moduleName="Gestiones";


$globalAdmin=$_SESSION["globalAdmin"];
// Preparamos
$sql="SELECT codigo, nombre, abreviatura, (select er.nombre from estados_referenciales er, gestiones_datosadicionales gd where er.codigo=gd.cod_estado and gd.cod_gestion=g.codigo) as estado, (select ep.nombre from estados_poa ep, gestiones_datosadicionales gd where ep.codigo=gd.cod_estadopoa and gd.cod_gestion=g.codigo) as estadopoa FROM $table g where cod_estado in (1,2,3) order by 1 desc";
//echo $sql;
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('estado', $estado);
$stmt->bindColumn('estadopoa', $estadopoa);


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
                          <th>Nombre</th>
                          <th>Estado</th>
                          <th>Estado POA</th>
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
                          <td><?=$nombre;?></td>
                          <td><?=$estado;?></td>
                          <td><?=$estadopoa;?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=configurarGestion&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-success" title="Configurar Gestion">
                              <i class="material-icons">settings</i>
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
                    <button class="btn btn-rose" onClick="location.href='index.php?opcion=listGestionesExtendidas'">Configurar Gestiones Extendidas</button>
                </div>
			  
            </div>
          </div>  
        </div>
    </div>
