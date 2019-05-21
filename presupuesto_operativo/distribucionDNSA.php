<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

$moduleName="Distribucion Porcentajes DN & SA";

?>

<div class="content">
	<div class="container-fluid">

		<div class="col-md-12">		
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header card-header-text <?=$colorCardDetail?>">
                  <div class="card-text">
                    <p class="card-category">Distribucion Porcentajes - PO</p>
                  </div>
                </div>
                <div class="card-body table-responsive">
                  <table class="table table-hover">
                    <thead>
						<tr>
						<th class="text-center font-weight-bold">Unidad\Area</th>
                    <?php
					$stmtA = $dbh->prepare("SELECT codigo, nombre FROM po_organismos where codigo not in (0,501,502,710) ORDER BY 2");
					$stmtA->execute();
					while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
						$codigoO=$rowA['codigo'];
						$nombreO=$rowA['nombre'];
					?>
						<th colspan="2" class="text-center font-weight-bold"><?=$nombreO?></th>
					<?php	
					}
					?>
						<th colspan="2" class="text-center font-weight-bold">Totales</th>
						</tr>
						<tr>
						<th>-</th>
					<?php
					$stmtA->execute();
					while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
						$codigoO=$rowA['codigo'];
						$nombreO=$rowA['nombre'];
					?>
						<th class="text-center font-weight-bold">DN</th>
						<th class="text-center font-weight-bold">SA</th>
					<?php	
					}
                    ?>
                    	<th class="text-center font-weight-bold">Total DN</th>
						<th class="text-center font-weight-bold">Total SA</th>
                    	</tr>
                    </thead>
                    <tbody>
	                    <?php
						$stmtU = $dbh->prepare("SELECT codigo, nombre FROM po_fondos ORDER BY 2");
						$stmtU->execute();
						
						while ($rowU = $stmtU->fetch(PDO::FETCH_ASSOC)) {
							$codigoF=$rowU['codigo'];
							$nombreF=$rowU['nombre'];
						?>                      
						<tr>
							<td class="text-left font-weight-bold"><?=$nombreF?></td>
							<?php
							$stmtA->execute();
							$totalDN=0;
							$totalSA=0;
							while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
								$codigoO=$rowA['codigo'];
								$nombreO=$rowA['nombre'];

								$sqlDetalle="SELECT porcentaje_dn, porcentaje_sa from po_distribucionunidadesareas where cod_fondo='$codigoF' and cod_organismo='$codigoO'";
								//echo $sqlDetalle;
								$porcentajeDNX=0;
								$porcentajeSAX=0;
								$stmtDetalle = $dbh->prepare($sqlDetalle);
								$stmtDetalle->execute();
								while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
									$porcentajeDNX=$rowDetalle['porcentaje_dn'];
									$porcentajeSAX=$rowDetalle['porcentaje_sa'];
									$totalSA=$totalSA+$porcentajeSAX;
									$totalDN=$totalDN+$porcentajeDNX;
								}
							?>
							<td class="text-right">
						    	<span><?=$porcentajeDNX;?> %</span>
							</td>
							<td class="text-right">
						    	<span><?=$porcentajeSAX;?> %</span>
							</td>
							<?php	
							}
							?>
							<td class="text-right font-weight-bold"><?=$totalDN;?> %</td>
		                    <td class="text-right font-weight-bold"><?=$totalSA;?> %</td>
							<?php
						}
	                    ?>
                      	</tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>


			  <div class="card-footer ml-auto mr-auto">
				<button class="<?=$button;?>" onClick="location.href='index.php?opcion=configuracionDistribucion'">Editar</button>
			  </div>
		</div>
	
	</div>
</div>