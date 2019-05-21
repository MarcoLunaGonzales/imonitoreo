<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$codIndicador=$codigo;
$codObjetivo=$codigo_objetivo;

$nombreObjetivo=nameObjetivo($codObjetivo);
$nombreIndicador=nameIndicador($codIndicador);
$nombreMeta=nameMeta($codIndicador);

$globalNombreGestion=$_SESSION["globalNombreGestion"];

$dbh = new Conexion();

$table="indicadores_metas";
$moduleName="Registro de Metas";

?>

<div class="content">
	<div class="container-fluid">

		<form method="post" action="indicadores/saveMetas.php">
		
		<input type="hidden" name="cod_objetivo" value="<?=$codObjetivo;?>">
		<input type="hidden" name="cod_indicador" value="<?=$codIndicador;?>">
		
		
		<div class="col-sm-12">
		  <div class="card">
		    <div class="card-header card-header-text <?=$colorCardDetail?>">
		      <div class="card-text">
		        <p class="card-category"><?=$moduleName;?></p>
		        <h6>Objetivo: <?=$nombreObjetivo;?></h6>
		        <h6>Indicador: <?=$nombreIndicador;?></h6>
		        <h6>Metas en: <?=$nombreMeta;?></h6>
		      </div>
		    </div>
		    <div class="card-body table-responsive">
		      <table class="table table-hover">
		        <thead>
					<th>Unidad\Area</th>
		        <?php
				$stmtA = $dbh->prepare("SELECT a.codigo, a.abreviatura FROM areas a, areas_poa ap where a.cod_estado=1 and a.codigo=ap.cod_area ORDER BY 2");
				$stmtA->execute();
				while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
					$codigoA=$rowA['codigo'];
					$abreviaturaA=$rowA['abreviatura'];
				?>
					<th class="text-center"><?=$abreviaturaA?></th>
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
						<td><?=$abreviaturaU?></td>
					<?php	
						$stmtA->execute();
						while ($rowA = $stmtA->fetch(PDO::FETCH_ASSOC)) {
							$codigoA=$rowA['codigo'];
							$abreviaturaA=$rowA['abreviatura'];

							$stmtVeri = $dbh->prepare("SELECT count(*) as filas FROM indicadores_unidadesareas where cod_indicador='$codIndicador' and cod_unidadorganizacional='$codigoU' and cod_area='$codigoA'");
							$stmtVeri->execute();
							while ($rowVeri = $stmtVeri->fetch(PDO::FETCH_ASSOC)) {
								$flagVerifica=$rowVeri['filas'];
								
								if($flagVerifica==1){

									$stmtVeri2 = $dbh->prepare("SELECT i.cod_operador, i.meta FROM indicadores_metas i where i.cod_indicador='$codIndicador' and i.cod_unidadorganizacional='$codigoU' and i.cod_area='$codigoA'");
									$stmtVeri2->execute();
									$codOperadorX=0;
									while ($rowVeri2 = $stmtVeri2->fetch(PDO::FETCH_ASSOC)) {
										$codOperadorX=$rowVeri2['cod_operador'];
										$valorMetaX=$rowVeri2['meta'];
									}

									$stmtOpe = $dbh->prepare("SELECT codigo, nombre, abreviatura  FROM operadores ORDER BY 1");
									$stmtOpe->execute();
					?>
						<td>
							<select class="selectpicker" name="combo|<?=$codigoU?>|<?=$codigoA?>" id="operador" data-width="150px" data-style="<?=$comboColor;?>" required>
							  	<option disabled selected value="">Seleccionar Operador</option-->
					<?php
									while ($rowOpe = $stmtOpe->fetch(PDO::FETCH_ASSOC)) {
										$codigoO=$rowOpe['codigo'];
										$nombreO=$rowOpe['nombre'];
										$abreviaturaO=$rowOpe['abreviatura'];
					?>
								<option value="<?=$codigoO;?>" data-subtext="<?=$nombreO;?>" <?=($codigoO==$codOperadorX)?"selected":""?> ><?=$abreviaturaO;?></option>
					<?php
									}
					?>
							</select>
							<div class="col-xs-2">
							<input class="form-control input-sm" type="number" name="text|<?=$codigoU?>|<?=$codigoA?>" id="nombre" value="<?=$valorMetaX?>"/>
							</div>
						</td>
					<?php
								}else{
					?>			
						<td>&nbsp;</td>
					<?php				
								}
							}
						}
					}
		            ?>
		          	</tr>
		        </tbody>
		      </table>
		    </div>
		  </div>
		</div>
	
		<div class="card-footer ml-auto mr-auto">
          <button type="submit" class="<?=$button?>">Guardar</button>
          <a href="index.php?opcion=listIndicadores&codigo=<?=$codObjetivo;?>" class="btn btn-danger">Cancelar</a>          
        </div>
        </form>
        
	</div>
</div>