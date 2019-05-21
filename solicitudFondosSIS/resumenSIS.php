<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalAdmin=$_SESSION["globalAdmin"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$anio=nameGestion($globalGestion);

$dbh = new Conexion();

?>
<div class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header <?=$colorCard;?> card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Resumen SIS</h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                         <th>Año</th>
                          <th>Mes</th>
                          <th data-orderable="false">Seguimiento</br>Detallado</th>
                          <th data-orderable="false">Detalle de Gastos</th>
                          <th data-orderable="false">Detalle de Gastos (AccNum)</th>
                          <th data-orderable="false">Balance de Cuentas</th>
                       	  <th>Archivo 1</th>
                          <th>Archivo 2</th>
                          <th>Cargar Archivos</th>
                        </tr>
                      </thead>
                      <tbody>
<?php
                      	for($i=1;$i<=12;$i++) {
                          $sqlCount="";
                          $sqlCount="SELECT count(*)as nro_registros, archivo FROM sis_archivos where anio='$anio' and mes='$i' and nro_archivo=1"; 
                          $stmtX = $dbh->prepare($sqlCount);
                          $stmtX->execute();
                          $contadorReg1=0;
                          $nameArchivo1="";
                          while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
                            $contadorReg1=$row['nro_registros'];
                            $nameArchivo1=$row['archivo'];
                          }

                          $sqlCount="";
                          $sqlCount="SELECT count(*)as nro_registros, archivo FROM sis_archivos where anio='$anio' and mes='$i' and nro_archivo=2"; 
                          //echo $sqlCount;
                          $stmtX = $dbh->prepare($sqlCount);
                          $stmtX->execute();
                          $contadorReg2=0;
                          $nameArchivo2="";
                          while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
                            $contadorReg2=$row['nro_registros'];
                            $nameArchivo2=$row['archivo'];
                          }
?>
                        <tr>
                	  		<td><?=$anio;?></td>
                          	<td><?=nameMes($i);?></td>
                          	<td class="td-actions text-center">
                            	<a href='solicitudFondosSIS/rptSeguimientoAnualSIS.php?gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
        	                      <i class="material-icons">input</i>
	                            </a>
    	                	</td>
                      	<td class="td-actions text-center">
                        	<a href='solicitudFondosSIS/rptDetalleGastosSIS.php?gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
                            		<i class="material-icons">open_in_new</i>
	                            </a>
    	                	</td>

                        <td class="td-actions text-center">
                          <a href='solicitudFondosSIS/reporteGastosSISAccNum.php?gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
                                <i class="material-icons">open_in_new</i>
                              </a>
                        </td>                        
                          	<td class="td-actions text-center">
                            	<a href='solicitudFondosSIS/rptBalanceCuentasSIS.php?gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
                            		<i class="material-icons">web_asset</i>
	                            </a>
    	                	</td> 
    	                	<td class="td-actions text-center">
                          <a href='filesSIS/<?=$nameArchivo1;?>' rel="tooltip" class="" target="_blank">
                                <?php
                                if($contadorReg1>0){
                                ?>
                            		<i class="material-icons">attachment</i>
                                <?php
                                }
                                ?>
	                            </a>
    	                	</td>
    	                	<td class="td-actions text-center">
    	                		<a href='filesSIS/<?=$nameArchivo2;?>' rel="tooltip" class="" target="_blank">
                              <?php
                                if($contadorReg2>0){
                                ?>
                                  <i class="material-icons">attachment</i>
                                <?php
                                }
                              ?>	                            
                            </a>
    	                	</td>    	                	
                        <td class="td-actions text-center">
                          <?php
                          if($globalAdmin==1){
                          ?>
                          <a href="#" class="<?=$buttonMorado;?> btn-round" data-toggle="modal" data-target="#myModal" title="Cargar" onClick="ajaxArchivosSIS(<?=$anio?>,<?=$i?>);">
                                <i class="material-icons">cloud_upload</i>
                          </a>
                          <?php
                          }
                          ?>
                        </td>

                        </tr>
<?php
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


<!-- Classic Modal -->
<form id="form1" enctype="multipart/form-data" class="form-horizontal" action="solicitudFondosSIS/saveFiles.php" method="post">
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adjuntar Archivo SIS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body" style="text-align:center;">

      </div>
      <div class="modal-footer">
        <button type="submit" class="<?=$buttonMorado;?>" >Subir</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</form>
<!--  End Modal -->