<?php

require_once 'conexion.php';
require_once 'functions.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$codigoCargo=$codigo;
$nombreCargo=nameCargo($codigoCargo);

$table="cargos_funciones";
$moduleName="Funciones por Cargo";

$globalAdmin=$_SESSION["globalAdmin"];

// Preparamos
$stmt = $dbh->prepare("SELECT c.cod_cargo, c.cod_funcion, c.nombre_funcion, c.peso from $table c where c.cod_cargo='$codigoCargo' and c.cod_estado=1 order by 3;
");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('cod_cargo', $codCargo);
$stmt->bindColumn('cod_funcion', $codFuncion);
$stmt->bindColumn('nombre_funcion', $nombreFuncion);
$stmt->bindColumn('peso', $peso);

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
                  <h5 class="card-title">Cargo: <?=$nombreCargo;?></h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table" id="tablePaginator">
                      <thead>
                        <tr>
                          <th class="text-center">#</th>
                          <th>Funcion</th>
                          <th>Peso</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
						$index=1;
                      	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
?>
                        <tr>
                          <td align="center"><?=$index;?></td>
                          <td><?=$nombreFuncion;?></td>
                          <td><?=$peso;?></td>
                          <td class="td-actions text-right">
                            <?php
                            if($globalAdmin==1){
                            ?>
                            <a href='index.php?opcion=editFuncionCargo&codigo=<?=$codFuncion;?>' rel="tooltip" class="btn btn-success">
                              <i class="material-icons">edit</i>
                            </a>
                            <button rel="tooltip" class="btn btn-danger" onclick="alerts.showSwal('warning-message-and-confirmation','index.php?opcion=deleteFuncionCargo&codigo=<?=$codFuncion;?>')">
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
                    <button class="btn" onClick="location.href='index.php?opcion=registerFuncionCargo&codigo=<?=$codCargo;?>'">Registrar</button>
                </div>
		          <?php
              }
              ?>
            </div>
          </div>  
        </div>
    </div>
