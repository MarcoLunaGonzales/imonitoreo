<?php

require_once 'conexion.php';
require_once 'functions.php';
$dbh = new Conexion();

$globalAdmin=$_SESSION["globalAdmin"];

$table="personal2";
$moduleName="Personal";

// Preparamos
$sql="SELECT codigo, nombre, (select a.abreviatura from areas a where a.codigo=p.cod_area)as area, (select u.nombre from unidades_organizacionales u where u.codigo=p.cod_unidad)as unidad, 
  (select pu.nombre from perfiles_usuario pu, personal_datosadicionales pd where pd.perfil=pu.codigo and pd.cod_personal=p.codigo)as perfil, (select pd.cod_estado from personal_datosadicionales pd where pd.cod_personal=p.codigo)as estado,
  (select c.nombre from cargos c, personal_datosadicionales pd where pd.cod_cargo=c.codigo and pd.cod_personal=p.codigo)as cargo, 
  (select pd.usuario_pon from personal_datosadicionales pd where pd.cod_personal=p.codigo)as usuariopon
   FROM $table p order by 4,2";
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
$stmt->bindColumn('cargo', $cargo);
$stmt->bindColumn('usuariopon', $usuarioPON);

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
                  <a href="index.php?opcion=listPersonalInactivo" class="<?=$buttonCeleste;?> btn-round" title="Ver Usuarios Inactivos">
                        <i class="material-icons">person_outline</i>
                  </a>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Nombre</th>
                          <th>Cargo</th>
                          <th>Unidad</th>
                          <th>Area</th>
                          <th>Unidad Trabajo</th>
                          <th>Area Trabajo</th>
                          <th>Perfil</th>
                          <th>Usuario PON</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
						$index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {

                          if($usuarioPON==1){
                            $estadoUsuarioPON="USUARIO PON";
                          }else if($usuarioPON==2){
                            $estadoUsuarioPON="ADMIN PON";
                          }else{
                            $estadoUsuarioPON="NO";
                          }
                          $areasAdicionales="";
                          $areasAdicionales=buscarAreasAdicionales($codigo,2);
                          $unidadesAdicionales="";
                          $unidadesAdicionales=buscarUnidadesAdicionales($codigo,2);

                          if($estado!=2){
?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$nombre;?></td>
                          <td><?=$cargo;?></td>
                          <td><?=$unidad;?></td>
                          <td><?=$area;?></td>
                          <td><?=$unidadesAdicionales;?></td>
                          <td><?=$areasAdicionales;?></td>
                          <td><?=$perfil;?></td>
                          <td><?=$estadoUsuarioPON;?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=editPersonal&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-success">
                              <i class="material-icons" title="Administrar Acceso">fingerprint</i>
                            </a>

                            <a href='index.php?opcion=addAreas&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-success">
                              <i class="material-icons" title="Adicionar Area">library_add</i>
                            </a>

                            <a href='index.php?opcion=addUnidades&codigo=<?=$codigo;?>' rel="tooltip" class="btn btn-success">
                              <i class="material-icons" title="Adicionar Unidades">library_add</i>
                            </a>

                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deletePersonal&codigo=<?=$codigo;?>')">
                              <i class="material-icons" title="Inactivar Personal">person_add_disabled</i>
                            </button>
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
