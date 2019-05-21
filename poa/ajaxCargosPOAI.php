<?php 
	require_once '../conexion.php';
	require_once '../functions.php';
	require_once '../styles.php';

	$dbh = new Conexion();

	$codIndicador=$_GET["codigo_indicador"];

	$nombreIndicador=nameIndicador($codIndicador);

?>

<input type="hidden" name="cod_indicador" value="<?=$codIndicador?>">

<div class="col-sm-12">
  <div class="card">
    <div class="card-header card-header-text <?=$colorCardDetail?>">
      <div class="card-text">
        <!--h6 class="card-category">Objetivo: <?=$nombreObjetivo;?></h6-->
        <h6 class="card-category">Indicador: <?=$nombreIndicador;?></h6>
      </div>
    </div>
    <div class="card-body table-responsive">
      <table class="table table-hover">
        <thead>
			<th class="text-primary">Area</th>
			<th class="text-primary">Cargo</th>
			<th class="text-primary">-</th>
        </thead>
        <tbody>
            <?php
            $sqlAC="SELECT ac.cod_area, (select a.abreviatura from areas a where a.codigo=ac.cod_area)as area, ac.cod_cargo, (select c.nombre from cargos c where c.codigo=ac.cod_cargo)as cargo from indicadores_unidadesareas i, areas_cargos ac where i.cod_indicador='$codIndicador' and i.cod_area=ac.cod_area group by ac.cod_area, ac.cod_cargo order by 2,4";
			$stmtAC = $dbh->prepare($sqlAC);
			$stmtAC->execute();
			while ($rowAC = $stmtAC->fetch(PDO::FETCH_ASSOC)) {
				$codigoArea=$rowAC['cod_area'];
				$nombreArea=$rowAC['area'];
				$codigoCargo=$rowAC['cod_cargo'];
				$nombreCargo=$rowAC['cargo'];

				$sqlVeriCheck="SELECT count(*)contador from indicadores_areascargos iac where iac.cod_indicador='$codIndicador' and iac.cod_area='$codigoArea' and iac.cod_cargo='$codigoCargo'";
				$stmtVeriCheck = $dbh->prepare($sqlVeriCheck);
				$stmtVeriCheck->execute();
				while ($rowRevisa = $stmtVeriCheck->fetch(PDO::FETCH_ASSOC)) {
					$contadorVerifica=$rowRevisa['contador'];
				}
			?>                      
			<tr>
				<td class="text-left"><?=$nombreArea;?></td>
				<td class="text-left"><?=$nombreCargo;?></td>
				<td>
					<div class="form-check">
	                    <label class="form-check-label">
	                      <input class="form-check-input" type="checkbox" name="propiedad_cargo[]" value="<?=$codigoArea?>|<?=$codigoCargo?>" value="" <?=($contadorVerifica>0)?"checked":"";?> >
	                      <span class="form-check-sign">
	                        <span class="check"></span>
	                      </span>
	                    </label>
	                 </div>
				</td>
			<?php
			}
            ?>
          	</tr>
        </tbody>
      </table>
    </div>
  </div>
</div>