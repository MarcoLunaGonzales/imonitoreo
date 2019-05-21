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
		  <form id="form1" class="form-horizontal" action="presupuesto_operativo/saveDistribucion.php" method="post">
		
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-header card-header-text <?=$colorCardDetail?>">
                  <div class="card-text">
                    <p class="card-category">Configurar Porcentajes de Distribucion - PO</p>
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
							while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
								$codigoO=$rowA['codigo'];
								$nombreO=$rowA['nombre'];

								$sqlDetalle="SELECT porcentaje_dn, porcentaje_sa from po_distribucionunidadesareas where cod_fondo='$codigoF' and cod_organismo='$codigoO'";
								//echo $sqlDetalle;
								$stmtDetalle = $dbh->prepare($sqlDetalle);
								$stmtDetalle->execute();
								while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
									$porcentajeDNX=$rowDetalle['porcentaje_dn'];
									$porcentajeSAX=$rowDetalle['porcentaje_sa'];
								}
							?>
							<td>
						    	<input class="form-control input-sm" type="number" name="DN|<?=$codigoF?>|<?=$codigoO?>" value="<?=$porcentajeDNX;?>">
							</td>
							<td>
						    	<input class="form-control input-sm" type="number" name="SA|<?=$codigoF?>|<?=$codigoO?>" value="<?=$porcentajeSAX;?>">
							</td>
							<?php	
							}
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
				<button type="submit" class="<?=$button;?>">Guardar</button>
			  </div>
		  </form>
		</div>
	
	</div>
</div>