<?php
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';
$dbh = new Conexion();

session_start();

$id_gestion=$_GET['id_gestion'];
$table="gestiones_extendidas";
$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();
$codMesDefault=mesDefaultReport();
// Preparamos
$sql="SELECT anio_inicio,mes_inicio,anio_final,mes_final from $table where id_gestion=$id_gestion";
$stmt = $dbh->prepare($sql);
//echo $sql;
// Ejecutamos
$stmt->execute();
$anio_inicio=0;$anio_final=0;$mes_inicio=0;$mes_final=0;
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$anio_inicio=$row['anio_inicio'];
	$mes_inicio=$row['mes_inicio'];
	$anio_final=$row['anio_final'];
	$mes_final=$row['mes_final'];
}
?>
<select class="selectpicker" title="Seleccione una opcion" name="mes" id="mes" data-style="<?=$comboColor;?>" required>
     <option disabled selected value=""></option>
        <?php
            $stmt = $dbh->prepare("SELECT codigo, nombre FROM meses order by 1");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $codigoX=$row['codigo'];
                $nombreX=$row['nombre'];
              ?>
          <option value="<?=$codigoX;?>####NONE" <?=($codigoX==$codMesDefault)?"selected":"";?> ><?=$nombreX;?></option>
          <?php 
          }
        ?>
        <?php
        if($anio_final!=0){
            $stmt = $dbh->prepare("SELECT codigo, nombre FROM meses where codigo<=$mes_final order by 1");
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $codigoX=$row['codigo'];
                $nombreX=$row['nombre'];
              ?>
          <option value="<?=$codigoX;?>####<?=obtenerCodigoGestionNombre($anio_final)?>" ><?=$nombreX;?> - <?=$anio_final?></option>
          <?php 
          }   	
        }
        ?>
</select>

