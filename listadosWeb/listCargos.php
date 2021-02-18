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
$stmt = $dbh->prepare("SELECT cf.cod_cargo,c.nombre,cf.cod_funcion,cf.nombre_funcion 
FROM cargos_funciones cf
join cargos c on c.codigo=cf.cod_cargo
where c.cod_estado=1;
");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('cod_cargo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('cod_funcion', $codFuncion);
$stmt->bindColumn('nombre_funcion', $nombreFuncion);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">Código Cargo</th>
      <th>Cargo</th>
      <th>Código Función</th>
      <th>Función</th>
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
      <td><?=$codFuncion;?></td>
      <td><?=$nombreFuncion;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
