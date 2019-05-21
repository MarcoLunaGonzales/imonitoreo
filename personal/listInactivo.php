<?php

require_once 'conexion.php';
require_once 'functions.php';
$dbh = new Conexion();

$globalAdmin=$_SESSION["globalAdmin"];

$table="personal2";
$moduleName="Personal Inactivo";

// Preparamos
$sql="SELECT codigo, nombre, (select a.abreviatura from areas a where a.codigo=p.cod_area)as area, (select u.nombre from unidades_organizacionales u where u.codigo=p.cod_unidad)as unidad, 
  (select pu.nombre from perfiles_usuario pu, personal_datosadicionales pd where pd.perfil=pu.codigo and pd.cod_personal=p.codigo)as perfil, (select pd.cod_estado from personal_datosadicionales pd where pd.cod_personal=p.codigo)as estado FROM $table p order by 4,2";
$stmt = $dbh->prepare($sql);
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('area', $area);
$stmt->bindColumn('unidad', $unidad);
$stmt->bindColumn('perfil', $perfil);
$stmt->bindColumn('estado', $estado);

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
                  <h4 class="card-title"><?=$moduleName?>
                  </h4>
                  <a href="index.php?opcion=listPersonal" class="<?=$buttonCeleste;?> btn-round" title="Ver Usuarios Activos">
                        <i class="material-icons">person</i>
                  </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nombre</th>
                          <th>Unidad</th>
                          <th>Area</th>
                          <th>Areas Adicionales</th>
                          <th>Perfil</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
						            $index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
                          $areasAdicionales="";
                          $areasAdicionales=buscarAreasAdicionales($codigo,2);
                          if($estado==2){
?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$unidad;?></td>
                          <td><?=$area;?></td>
                          <td><?=$areasAdicionales;?></td>
                          <td><?=$perfil;?></td>
                          <td class="td-actions text-center">
                            <?php
                            if($globalAdmin==1){
                            ?>

                            <a href="index.php?opcion=activarPersonal&codigo=<?=$codigo;?>" rel="tooltip" class="btn btn-success" title="Activar Personal">
                              <i class="material-icons">person</i>
                            </a>
                            <?php
                            }
                            ?>
                          </td>
                        </tr>
                        <?php
						            $index++;
						              }
                        }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
				<div class="card-body">
                    <!--button class="btn" onClick="location.href='index.php?opcion=registerArea'">Registrar</button-->
                </div>
			  
            </div>
          </div>  
        </div>
    </div>
