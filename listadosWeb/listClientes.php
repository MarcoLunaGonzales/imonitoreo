<?php

require_once '../conexion.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$table="clientes";
$moduleName="Clientes";

$gestionNueva="1205";

// Preparamos
$stmt = $dbh->prepare("SELECT a.codigo, a.nombre, (select u.nombre from unidades_organizacionales u where u.codigo=a.cod_unidad) as abreviatura FROM $table a where a.cod_estado=1 order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
      <th>Regional</th>
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
      <td><?=$abreviatura;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
