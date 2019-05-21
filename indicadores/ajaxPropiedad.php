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
        <h6 class="card-category">Objetivo: <?=$nombreObjetivo;?></h6>
        <h6 class="card-category">Indicador: <?=$nombreIndicador;?></h6>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
			<th class="text-primary">Unidad\Area</th>
        <?php
		$stmtA = $dbh->prepare("SELECT a.codigo, a.abreviatura FROM areas a, areas_poa ap where a.cod_estado=1 and a.codigo=ap.cod_area ORDER BY 2");
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
			$stmtU = $dbh->prepare("SELECT u.codigo, u.abreviatura FROM unidades_organizacionales u, unidadesorganizacionales_poa up where u.cod_estado=1 and u.codigo=up.cod_unidadorganizacional ORDER BY 2");
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