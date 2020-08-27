<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

session_start();
$globalAdmin=$_SESSION["globalAdmin"];
$globalUser=$_SESSION["globalUser"];
$globalGestion=$_SESSION["globalGestion"];
$globalUnidad=$_SESSION["globalUnidad"];
$globalArea=$_SESSION["globalArea"];
$codigo=$_GET['codigo'];
$codActividad=$_GET['codActividad'];
$codigoIndicador=$_GET['cod_indicador'];
$codUnidad=$_GET['cod_unidad'];
$codArea=$_GET['cod_area'];
$index=$codigo;
/*$codUnidadHijosX=buscarHijosUO($codUnidad);
$nombreTablaClasificador=obtieneTablaClasificador($codigoIndicador,$codUnidad,$codArea);*/
?>
<div id="div<?=$index;?>">
	<table border="0">
	<tr>
		<td width="20%" align="center">

	    	<input type="hidden" name="codigoPadre<?=$index;?>" id="codigoPadre<?=$index;?>" value="<?=$codActividad;?>">
	    	<input type="hidden" name="codigoPOAI<?=$index;?>" id="codigoPOAI<?=$index;?>" value="0">

	        <select class="form-control" name="personal<?=$index;?>" id="personal<?=$index;?>" data-style="<?=$comboColor;?>" onChange="ajaxFuncionesCargos(this,<?=$index;?>);" data-live-search="true" required>
	    	<?php
		  	$sql="SELECT p.codigo, p.nombre, (select c.nombre from cargos c where c.codigo=pd.cod_cargo)as cargo from personal2 p, personal_datosadicionales pd, personal_unidadesorganizacionales pu where p.codigo=pd.cod_personal and p.codigo=pu.cod_personal and pu.cod_unidad='$codUnidad' and pd.cod_cargo in (select i.cod_cargo from indicadores_areascargos i where i.cod_indicador='$codigoIndicador' and i.cod_area='$codArea') order by 2";
		  	
		  	echo $sql;
		  	
		  	?>
		  		<option value="">Seleccionar Persona</option>
		  	<?php
		  	$stmt = $dbh->prepare($sql);
			$stmt->execute();
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$codigoX=$row['codigo'];
				$nombreX=$row['nombre'];
				$nombreCargoX=$row['cargo'];
			?>
				<option value="<?=$codigoX;?>" data-subtext="<?=$nombreCargoX;?>" ><?=$nombreX;?></option>	
			<?php	
			}
		  	?>
			</select>
		</td>
		<td width="65%" align="center">
			<div class="form-group" id="divFuncion<?=$index;?>">
			</div>
		</td>
		<td width="10%" align="center">
			<div class="form-group">
				<input type="number" class="form-control" name="meta<?=$index;?>" id="meta<?=$index;?>" value="0" required>
			</div>
		</td>
		<td width="5%" align="center">
			<div class="col-sm-1">
				<a href="#" class="btn btn-just-icon btn-danger btn-link" onclick="minusActividadPOAIAsignacion('<?=$index;?>');">
                              <i class="material-icons">remove_circle</i>
                </a>
        	</div>
		</td>
	</tr>
	</table>
</div><!--div del detalle por funcion-->
