<?php 
	require_once '../conexion.php';
	require_once '../functions.php';
	require_once '../styles.php';

	$dbh = new Conexion();

	$codObjetivo=$_GET["cod_objetivo"];
	$codIndicador=$_GET["cod_indicador"];

	$nombreObjetivo=nameObjetivo($codObjetivo);
	$nombreIndicador=nameIndicador($codIndicador);

?>
<div class="col-sm-12">
  <div class="card">
    <div class="card-header card-header-text <?=$colorCardDetail?>">
      <div class="card-text">
        <p class="card-category"><?=$nombreObjetivo;?> - <?=$nombreIndicador;?></p>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
			<th class="text-primary">Unidad\Area</th>
        <?php
		$stmtA = $dbh->prepare("SELECT codigo, abreviatura FROM areas where cod_estado=1 ORDER BY 2");
		$stmtA->execute();
		while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
			$codigoA=$rowA['codigo'];
			$abreviaturaA=$rowA['abreviatura'];
		?>
			<th class="text-primary"><?=$abreviaturaA?></th>
		<?php	
		}
        ?>
        </thead>
        <tbody>
            <?php
			$stmtU = $dbh->prepare("SELECT codigo, abreviatura FROM unidades_organizacionales where cod_estado=1 ORDER BY 2");
			$stmtU->execute();
			while ($rowU = $stmtU->fetch(PDO::FETCH_ASSOC)) {
				$codigoU=$rowU['codigo'];
				$abreviaturaU=$rowU['abreviatura'];
			?>                      
			<tr>
				<th class="text-primary"><?=$abreviaturaU?></th>
			<?php	
				$stmtA->execute();
				while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
					$codigoA=$rowA['codigo'];
					$abreviaturaA=$rowA['abreviatura'];

					
					$sqlVeri="SELECT count(*) as filas FROM indicadores_unidadesareas where cod_indicador='$codIndicador' and cod_unidadorganizacional='$codigoU' and cod_area='$codigoA'";
					$stmtVeri = $dbh->prepare($sqlVeri);
					//echo $sqlVeri;
					$stmtVeri->execute();
					while ($rowVeri = $stmtVeri->fetch(PDO::FETCH_ASSOC)) {
						$flagVerifica=$rowVeri['filas'];
						$iconCheck="";
						if($flagVerifica==1){
							$iconCheck="check_circle_outline";
						}else{
							$iconCheck="";
						}
					}
			?>
					<td>
						<div class="card-icon">
		                    <i class="material-icons"><?=$iconCheck;?></i>
                  		</div>
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