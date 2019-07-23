<?php

require_once 'conexion.php';
require_once 'styles.php';
require_once 'functions.php';

$dbh = new Conexion();

?>

<div class="content">
  <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
              <form id="form1" class="form-horizontal" action="" method="post">
              <div class="card">
                <div class="card-header card-header-rose card-header-icon">
                  <div class="card-icon">
                    <i class="material-icons">assignment</i>
                  </div>
                  <h4 class="card-title">Sincronizar Datos</h4>
                </div>
                
                <div class="card-body">

                  <div class="row">
                    <label class="col-sm-6 col-form-label">Datos Generales (Clientes, Servicios, Personal, etc.)</label>
                    <div class="col-sm-6">
                    <div class="form-group">
                      <a href="sp_calls/ejecutarSincroDatosGenerales.php" class="<?=$button;?>" target="_blank">Sincronizar</a>
                    </div>
                    </div>
                  </div>

                  <div class="row">
                    <label class="col-sm-6 col-form-label">Datos Contabilidad</label>
                    <div class="col-sm-6">
                    <div class="form-group">
                      <a href="sp_calls/ejecutarSincroConta.php" class="<?=$button;?>" target="_blank">Sincronizar</a>
                    </div>
                    </div>
                  </div>

                </div>

              </div>

               </form>
            </div>
          </div>  
        </div>
    </div>
