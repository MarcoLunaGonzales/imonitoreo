<?php
require_once '../conexion.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$table="indicadores";
$moduleName="Indicadores";

$gestionNueva="3584";

// Preparamos
$stmt = $dbh->prepare("SELECT a.codigo, a.nombre, a.cod_objetivo as abreviatura, a.descripcion_calculo FROM $table a where a.cod_estado=1 and a.cod_gestion='$gestionNueva' order by 1");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('descripcion_calculo', $descripcionCalculo);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
      <th>Descricion Calculo</th>
      <th>CodObjetivo</th>
    </tr>
  </thead>
  <tbody>
<?php
  $index=1;
	while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {
?>
    <tr>
      <td align="center"><?=$codigo;?></td>
      <td><?=$nombre;?></td>
      <td><?=$descripcionCalculo;?></td>
      <td><?=$abreviatura;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
