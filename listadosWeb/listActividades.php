<?php

require_once '../conexion.php';
$dbh = new Conexion();

$table="actividades_poa";
$moduleName="Actividades POA";

// Preparamos
$stmt = $dbh->prepare("SELECT distinct(a.codigo)as codigo, a.orden, a.nombre,
          (SELECT i.nombre from indicadores i where i.codigo=a.cod_indicador)as indicador, a.cod_indicador, 
          (select g.nombre from gestiones g where g.codigo=a.cod_gestion)as gestion
           from $table a where  a.cod_estado=1 and a.cod_actividadpadre=0 
having gestion > '2019'
order by gestion, indicador, a.nombre");
// Ejecutamos
$stmt->execute();
// bindColumn
$stmt->bindColumn('codigo', $codigo);
$stmt->bindColumn('nombre', $nombre);
$stmt->bindColumn('indicador', $indicador);
$stmt->bindColumn('gestion', $gestion);

?>

<table class="table table-striped">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Nombre</th>
      <th>Indicador</th>
      <th>Gestión</th>
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
      <td><?=$indicador;?></td>
      <td><?=$gestion;?></td>
    </tr>
<?php
$index++;
}
?>
  </tbody>
</table>
