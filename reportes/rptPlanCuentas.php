<?php

require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$moduleName="Plan de Cuentas";

// Preparamos
$sql="SELECT p.codigo, p.nombre, p.nivel from po_plancuentas p order by p.codigo";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('codigo', $codCuenta);
$stmt->bindColumn('nombre', $nombreCuenta);
$stmt->bindColumn('nivel', $nivelCuenta);
?>

<div class="content">
	<div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header <?=$colorCard;?> card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Reporte <?=$moduleName?></h4>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th>Cuenta</th>
                          <th>Nombre</th>
                          <th>Nivel</th>
                        </tr>
                      </thead>
              
                      <tbody>
                      <?php
                          while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                      ?>                      
                      <tr>
                        <td class="text-muted"><?=$codCuenta;?></td>
                        <td class="text-muted"><?=$nombreCuenta;?></td>
                        <td class="text-muted"><?=$nivelCuenta;?></td>
                      <?php 
                      }
                      ?>
            </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>