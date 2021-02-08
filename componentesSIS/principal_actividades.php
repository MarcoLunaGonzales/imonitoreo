<?php

require_once 'conexion.php';

require_once 'styles.php';

$globalAdmin=$_SESSION["globalAdmin"];
$globalUser=$_SESSION["globalUser"];
$globalProyecto=$_SESSION["globalProyecto"];
$codigo_proy=$codigo_proy;
$_SESSION["globalProyecto"]=$codigo_proy;

  
  $nombre_proyecto="";
  if($codigo_proy=="" || $codigo_proy=='' || $codigo_proy=="0"){
    $nombre_proyecto=obtener_nombre_proyecto($codigo_proy);    
  }

// echo "proy: ".$globalProyecto;
// if($globalProyecto==''){
  $dbh = new Conexion();
  $stmt = $dbh->prepare(" SELECT codigo,abreviatura,nombre,cod_unidadorganizacional,
  (select o.abreviatura from unidades_organizacionales o where o.codigo=cod_unidadorganizacional) as nombre_uo 
  from proyectos_financiacionexterna where cod_estadoreferencial=1 and codigo<>0");
  //ejecutamos
  $stmt->execute();
  //bindColumn
  $stmt->bindColumn('codigo', $codigo);
  $stmt->bindColumn('nombre', $nombre);
  $stmt->bindColumn('abreviatura', $abreviatura);
  $stmt->bindColumn('cod_unidadorganizacional', $cod_unidadorganizacional);
  $stmt->bindColumn('nombre_uo', $nombre_uo);



  ?>

  <div class="content">
    <div class="container-fluid">
          <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header <?=$colorCard;?> card-header-icon">
                    <div class="card-icon">
                      <i class="material-icons"><?=$iconCard;?></i>
                    </div>                    
                  </div>
                  <div class="card-body">
                    <?php 
                      if($codigo_proy==''){?>
                        <h4 class="text-center"><b>Seleccionar Proyecto de Trabajo</b></h4>
                      <?php }else{?>
                        <h4 class="text-center"><b> Proyecto De Trabajo <?=$nombre_proyecto?></b></h4>
                      <?php }
                    ?>
                    
                    <div class="row div-center text-center">
                    <?php
                    while ($row = $stmt->fetch(PDO::FETCH_BOUND)) {?>                    
                         <div class="card text-white mx-auto" style="background-color:#ffab91; width: 18rem;">
                           <!-- <a href="#" onclick="alerts.showSwal('warning-message-and-confirmation3','index.php?opcion=principal_actividades&codigo_proy=<?=$codigo?>')" > -->

                            <a href="index.php?opcion=principal_actividades&codigo_proy=<?=$codigo?>"> 

                            <!-- ?opcion=listComponentesSIS -->
                              <div class="card-body ">
                                 <h5 class="card-title" style="color:#37474f;"><b>PROYECTO</b></h5>
                                 <p class="card-text text-small" style="color:#37474f"><?=$nombre;?><br></p>
                                 <i class="material-icons" style="color:#37474f">home_work</i>
                              </div>
                           </a>
                         </div>
                    <?php }
                    ?>
                     </div>
                  </div>
                </div>  
              </div>
          </div>  
    </div>
  </div>
