<?php

require_once '../conexion.php';
$dbh = new Conexion();

$table="personal2";
$moduleName="Personal";

// Preparamos
$stmt = $dbh->prepare("SELECT a.cod_personal as codigo, a.nombre FROM $table a order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
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
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
