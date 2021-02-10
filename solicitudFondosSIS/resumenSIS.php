<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$globalAdmin=$_SESSION["globalAdmin"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$globalServerArchivos=$_SESSION["globalServerArchivos"];

$anioInicio=nameGestion($globalGestion);
$datosExtendida=obtenerAnioFinMesFinGestionExtendia($globalGestion);
$anioFin=$datosExtendida[0];
$mesFinal=$datosExtendida[1];

$dbh = new Conexion();

$banderaReg=verificaRegistrosSIS($anioInicio);
//echo $banderaReg;
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
                          <th data-orderable="false">Detalle de Gastos (AccNum)-Mes</th>
                          <th data-orderable="false">Detalle de Gastos (AccNum)-Acum</th>
                          <th data-orderable="false">Balance de Cuentas</th>
                       	  <th>Archivo 1</th>
                          <th>Archivo 2</th>
                          <th>UploadArchivo 1</th>
                          <th>UploadArchivo 2<th>
                        </tr>
                      </thead>
                      <tbody>
<?php
                  for ($anio=$anioInicio; $anio<=(int)$anioFin; $anio++) { 
                         if($anio==$anioInicio){
                           $finMes=12;
                         }else{
                           $finMes=$mesFinal;
                         }

                      	for($i=1;$i<=$finMes;$i++) {
                          $sqlCount="";
                          $sqlCount="SELECT archivo, id FROM sis_archivos where anio='$anio' and mes='$i' and nro_archivo=1"; 
                          $stmtX = $dbh->prepare($sqlCount);
                          $stmtX->execute();
                          $contadorReg1=0;
                          $nameArchivo1="";
                          $idArchivo1=0;
                          while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
                            $nameArchivo1=$row['archivo'];
                            $idArchivo1=$row['id'];
                          }

                          $sqlCount="";
                          $sqlCount="SELECT archivo, id FROM sis_archivos where anio='$anio' and mes='$i' and nro_archivo=2"; 
                          //echo $sqlCount;
                          $stmtX = $dbh->prepare($sqlCount);
                          $stmtX->execute();
                          $contadorReg2=0;
                          $nameArchivo2="";
                          $idArchivo2=0;
                          while ($row = $stmtX->fetch(PDO::FETCH_ASSOC)) {
                            $nameArchivo2=$row['archivo'];
                            $idArchivo2=$row['id'];
                          }
?>
                        <tr>
                	  		<td><?=$anio;?></td>
                          	<td><?=nameMes($i);?></td>
                          	<td class="td-actions text-center">
                            	<a href='solicitudFondosSIS/rptSeguimientoAnualSIS.php?codigo_proy=1&gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
        	                      <i class="material-icons">input</i>
	                            </a>
    	                	</td>
                      	<td class="td-actions text-center">
                        	<a href='solicitudFondosSIS/rptDetalleGastosSIS.php?codigo_proy=1&gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
                            		<i class="material-icons">open_in_new</i>
	                            </a>
    	                	</td>

                        <td class="td-actions text-center">
                          <a href='solicitudFondosSIS/reporteGastosSISAccNum.php?codigo_proy=1&gestion=<?=$globalGestion;?>&mes=<?=$i?>&tiporeporte=0' rel="tooltip" class="" target="_blank">
                                <i class="material-icons">open_in_new</i>
                              </a>
                        </td>                        
                      	
                        <td class="td-actions text-center">
                          <a href='solicitudFondosSIS/reporteGastosSISAccNum.php?codigo_proy=1&gestion=<?=$globalGestion;?>&mes=<?=$i?>&tiporeporte=1' rel="tooltip" class="" target="_blank">
                                <i class="material-icons">open_in_new</i>
                              </a>
                        </td>

                        <td class="td-actions text-center">
                            	<a href='solicitudFondosSIS/rptBalanceCuentasSIS.php?codigo_proy=1&gestion=<?=$globalGestion;?>&mes=<?=$i?>' rel="tooltip" class="" target="_blank">
                            		<i class="material-icons">web_asset</i>
	                            </a>
    	                	</td> 
    	                	<td class="td-actions text-center">
                          <div id="divArchivo1<?=$i;?>">
                            <?php
                            if($nameArchivo1!=0){
                            ?>
                            <a href='<?=$globalServerArchivos?>descargar_archivo.php?idR=<?=$nameArchivo1;?>' rel="tooltip" class="" target="_blank">
                            		<i class="material-icons">attachment</i>
                            </a>
                            <?php
                              if($globalAdmin==1){
                            ?>
                            <button class="<?=$buttonCancel;?> btn-round" onClick="alerts.showSwal('warning-message-and-confirmation','javascript:ajaxDeleteArchivo(\'<?=$globalServerArchivos;?>\',\'<?=$nameArchivo1?>\',\'divArchivo1<?=$i;?>\',12,\'<?=$idArchivo1;?>\');')">
                                <i class="material-icons">delete_forever</i>
                            </button>
                            <?php
                              }
                            }
                            ?>
                          </div>
    	                	</td>
    	                	<td class="td-actions text-center">
    	                		<div id="divArchivo2<?=$i;?>">
                          <?php
                          if($nameArchivo2!=0){
                          ?>
                            <a href='<?=$globalServerArchivos?>descargar_archivo.php?idR=<?=$nameArchivo2;?>' rel="tooltip" class="" target="_blank">
                              <i class="material-icons">attachment</i>
                            </a>
                            <?php
                              if($globalAdmin==1){
                            ?>
                            <button class="<?=$buttonCancel;?> btn-round" onclick="alerts.showSwal('warning-message-and-confirmation','javascript:ajaxDeleteArchivo(\'<?=$globalServerArchivos;?>\',\'<?=$nameArchivo2?>\',\'divArchivo2<?=$i;?>\',12,\'<?=$idArchivo2;?>\');')">
                                <i class="material-icons">delete_forever</i>
                            </button>
                          <?php
                            }
                          }
                          ?>
                          </div>
    	                	</td>    	                	
                        <td class="td-actions text-center">
                          <?php
                          if($globalAdmin==1){
                          ?>
                          <a href="#" class="<?=$buttonMorado;?> btn-round" data-toggle="modal" data-target="#myModal" title="Cargar" onClick="ajaxArchivosSIS(<?=$anio?>,<?=$i?>,<?=$idArchivo1?>,'divArchivo1<?=$i;?>');">
                                <i class="material-icons">cloud_upload</i>
                          </a>
                          <?php
                          }
                          ?>
                        </td>

                        <td class="td-actions text-center">
                          <?php
                          if($globalAdmin==1){
                          ?>
                          <a href="#" class="<?=$buttonMorado;?> btn-round" data-toggle="modal" data-target="#myModal" title="Cargar" onClick="ajaxArchivosSIS(<?=$anio?>,<?=$i?>,<?=$idArchivo2?>,'divArchivo2<?=$i;?>');">
                                <i class="material-icons">cloud_upload</i>
                          </a>
                          <?php
                          }
                          ?>
                        </td>

                        </tr>
<?php
                    }
						}//for anio
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
<form id="formuploadajaxsis" enctype="multipart/form-data" class="form-horizontal" method="post">
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
        <button type="submit" class="<?=$buttonMorado;?>" value="Subir Archivo">Subir</button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
</form>
<!--  End Modal -->