<?php

require_once '../conexion.php';
$dbh = new Conexion();


$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$table="hitos";
$moduleName="Hitos";

// Preparamos
$stmt = $dbh->prepare("SELECT a.codigo, a.nombre, a.abreviatura, a.cod_area, 
  (select nombre from areas where codigo=a.cod_area)as area 
  FROM $table a where a.cod_estado=1 order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('abreviatura', $abreviatura);
$stmt->bindColumn('cod_area', $codArea);
$stmt->bindColumn('area', $nombreArea);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
      <th>Abreviatura</th>
      <th>codArea</th>
      <th>Area</th>
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
      <td><?=$codArea;?></td>
      <td><?=$nombreArea;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
