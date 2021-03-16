<?php

require_once '../conexion.php';
$dbh = new Conexion();

$table="personal2";
$moduleName="Personal";

// Preparamos
$stmt = $dbh->prepare("SELECT a.cod_personal as codigo, a.nombre,
(select c.codigo from cargos c, personal_datosadicionales pda where c.codigo=pda.cod_cargo and pda.cod_personal=a.codigo)as cod_cargo,
(select c.nombre from cargos c, personal_datosadicionales pda where c.codigo=pda.cod_cargo and pda.cod_personal=a.codigo)as nombre_cargo
 FROM $table a order by 2");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('cod_cargo', $cod_cargo);
$stmt->bindColumn('nombre_cargo', $nombre_cargo);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
      <th>CodCargo</th>
      <th>Cargo</th>
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
      <td><?=$cod_cargo;?></td>
      <td><?=$nombre_cargo;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
