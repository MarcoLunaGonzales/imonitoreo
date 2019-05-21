<?php 
	require_once '../conexion.php';
	require_once '../functions.php';
	require_once '../styles.php';

	$dbh = new Conexion();

	$codigo=$_GET["codigo"];

	$fechaSolicitud=dateSolicitud($codigo);

?>
<div class="col-sm-12">
  <div class="card">
    <div class="card-header card-header-text <?=$colorCardDetail?>">
      <div class="card-text">
        <h6 class="card-category">Fecha Solicitud: <?=$fechaSolicitud;?></h6>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
			<th class="text-primary">#</th>
			<th class="text-primary">Componente</th>
			<th class="text-primary">Monto</th>
        </thead>
        <tbody>
            <?php
            $indice=1;
			$stmtDetalle = $dbh->prepare("SELECT (SELECT concat(c.abreviatura,' ',c.nombre)from componentessis c where c.codigo=sd.cod_componente)componente, sd.monto from solicitudfondos_detalle sd where sd.codigo=$codigo order by 1");
			$stmtDetalle->execute();
			$montoTotal=0;
			while ($rowDetalle = $stmtDetalle->fetch(PDO::FETCH_ASSOC)) {
				$componenteX=$rowDetalle['componente'];
				$montoX=$rowDetalle['monto'];
				$montoTotal+=$montoX;
			?>                      
			<tr>
				<td><?=$indice;?></td>
				<td><?=$componenteX;?></td>
				<td class="text-right"><?=formatNumberDec($montoX);?></td>
          	</tr>
			
			<?php
				$indice++;	
			}
            ?>
            <tr>
				<td>-</td>
				<td>Total:</td>
				<td class="text-right"><?=formatNumberDec($montoTotal);?></td>
          	</tr>
        </tbody>
      </table>
    </div>
  </div>
</div>