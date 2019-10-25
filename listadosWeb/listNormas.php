<?php

require_once '../conexion.php';
$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();


$table="normas";
$moduleName="Normas";

// Preparamos
$stmt = $dbh->prepare("SELECT a.codigo, a.nombre, a.abreviatura, a.cod_sector, (select s.nombre from sectores s where s.codigo=a.cod_sector)as sector  FROM $table a where a.cod_estado=1 order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('cod_sector', $cod_sector);
$stmt->bindColumn('sector', $sector);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
      <th>Abreviatura</th>
      <th>CodSector</th>
      <th>Sector</th>
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
      <td><?=$cod_sector;?></td>
      <td><?=$sector;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
