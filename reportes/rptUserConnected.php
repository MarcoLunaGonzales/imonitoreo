<?php

//require_once '../layouts/bodylogin2.php';
require_once 'conexion.php';
require_once 'functions.php';
require_once 'styles.php';

$dbh = new Conexion();

$sqlX="SET NAMES 'utf8'";
$stmtX = $dbh->prepare($sqlX);
$stmtX->execute();

$moduleName="Ultimos Accesos al Sistema";

// Preparamos
$sql="SELECT u.cod_personal, (select concat(p.nombre) from personal2 p where p.codigo=u.cod_personal)as nombrepersona, 
max(DATE_FORMAT(u.fecha,'%d/%m/%Y %H:%i:%s'))as fecha from usuarios_conectados u  GROUP BY u.cod_personal ORDER BY u.id desc limit 0,30";
$stmt = $dbh->prepare($sql);
$stmt->execute();

// bindColumn
$stmt->bindColumn('cod_personal', $codPersonal);
$stmt->bindColumn('nombrepersona', $nombrePersonal);
$stmt->bindColumn('fecha', $fechaAcceso);
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
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Fecha Conexion</th>
                        </tr>
                      </thead>
              
                      <tbody>
                      <?php
                        $indice=1;
                        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)) {
                      ?>                      
                      <tr>
                        <td class="text-muted"><?=$indice;?></td>
                        <td class="text-muted"><?=$nombrePersonal;?></td>
                        <td class="text-muted"><?=$fechaAcceso;?></td>
                      <?php 
                        $indice++;
                      }
                      ?>
                      </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>