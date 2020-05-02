<?php

$globalUserX=$_SESSION['globalUser'];
//echo $globalUserX;
$globalPerfilX=$_SESSION['globalPerfil'];
$globalNameUserX=$_SESSION['globalNameUser'];
$globalNombreUnidadX=$_SESSION['globalNombreUnidad'];
$globalNombreAreaX=$_SESSION['globalNombreArea'];

if($globalPerfilX==1){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>

        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i class="material-icons">fullscreen</i>
              <p> Tablas
                <b class="caret"></b>
              </p>
            </a>

            <div class="collapse" id="pagesExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listAreas">
                    <span class="sidebar-mini"> A </span>
                    <span class="sidebar-normal"> Areas </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listCargos">
                    <span class="sidebar-mini"> C </span>
                    <span class="sidebar-normal"> Cargos </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listComites">
                    <span class="sidebar-mini"> Co </span>
                    <span class="sidebar-normal"> Comites </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestiones">
                    <span class="sidebar-mini"> G </span>
                    <span class="sidebar-normal"> Gestiones </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listHitos">
                    <span class="sidebar-mini"> H </span>
                    <span class="sidebar-normal"> Hitos Importantes </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listNormas">
                    <span class="sidebar-mini"> N </span>
                    <span class="sidebar-normal"> Normas </span>
                  </a>
                </li>
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSectores">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Sectores </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listUnidadOrg">
                    <span class="sidebar-mini"> UO </span>
                    <span class="sidebar-normal"> Unidades Organizacionales </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPersonal">
                    <span class="sidebar-mini"> P </span>
                    <span class="sidebar-normal"> Personal </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPlanCuentas">
                    <span class="sidebar-mini"> PC</span>
                    <span class="sidebar-normal"> Plan de Cuentas </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">menu</i>
              <p> Planificación Estratégica
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPerspectivas">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Perspectivas de Analisis</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivos">
                    <span class="sidebar-mini"> OE </span>
                    <span class="sidebar-normal"> Objetivos Estrategicos </span>
                  </a>
                </li>                
              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#operativo">
              <i class="material-icons">drag_indicator</i>
              <p> Planificación Operativa
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="operativo">
              <ul class="nav">
                
                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivosOp">
                    <span class="sidebar-mini"> OO </span>
                    <span class="sidebar-normal"> Objetivos Operativos</span>
                  </a>
                </li-->                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOA&area=0&unidad=0&sector=0">
                    <span class="sidebar-mini"> POAP </span>
                    <span class="sidebar-normal">POA Programacion</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAEjecucion&area=0&unidad=0">
                    <span class="sidebar-mini"> POAE </span>
                    <span class="sidebar-normal">POA Ejecucion</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAI&area=0&unidad=0">
                    <span class="sidebar-mini"> POAI </span>
                    <span class="sidebar-normal">POAI Programacion</span>
                  </a>
                </li>                

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAIEjecucion">
                    <span class="sidebar-mini"> POAIE </span>
                    <span class="sidebar-normal">POAI Ejecucion</span>
                  </a>
                </li-->  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=distribucionDNSA">
                    <span class="sidebar-mini"> CD </span>
                    <span class="sidebar-normal"> Distribucion DN&SA </span>
                  </a>
                </li> 

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#proyectosis">
              <i class="material-icons">linear_scale</i>
              <p> Proyecto SIS
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="proyectosis">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listComponentesSIS">
                    <span class="sidebar-mini"> AS </span>
                    <span class="sidebar-normal"> Actividades </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listExternalCostsSIS">
                    <span class="sidebar-mini"> EC </span>
                    <span class="sidebar-normal"> External Costs </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSolicitudFondosSIS">
                    <span class="sidebar-mini"> SF </span>
                    <span class="sidebar-normal">Solicitud de Fondos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=cargarPresupuestoSIS">
                    <span class="sidebar-mini"> CPS </span>
                    <span class="sidebar-normal">Cargar Presupuesto</span>
                  </a>
                </li>    

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpRelacionarGastos">
                    <span class="sidebar-mini"> RGAN </span>
                    <span class="sidebar-normal">Relacionar Gastos AccNum</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS2">
                    <span class="sidebar-mini"> SS </span>
                    <span class="sidebar-normal">Seguimiento</br>SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS">
                    <span class="sidebar-mini"> SDS </span>
                    <span class="sidebar-normal">Seguimiento</br>Detallado SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpDetalleGastosSIS">
                    <span class="sidebar-mini"> DGS </span>
                    <span class="sidebar-normal">Detalle Gastos SIS</span>
                  </a>
                </li>    

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpRelacionGastosAcc">
                    <span class="sidebar-mini"> DGAN </span>
                    <span class="sidebar-normal">Detalle Gastos con AccNum</span>
                  </a>
                </li>                            

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpBalanceCuentasSIS">
                    <span class="sidebar-mini"> BC </span>
                    <span class="sidebar-normal">Balance de Cuentas</span>
                  </a>
                </li>                                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=resumenGeneralSIS">
                    <span class="sidebar-mini"> RGS </span>
                    <span class="sidebar-normal">Revisión General SIS</span>
                  </a>
                </li>                                


              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportesgenerales">
              <i class="material-icons">assessment</i>
              <p> Reportes Generales
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportesgenerales">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptActividadesHitos">
                    <span class="sidebar-mini"> AH </span>
                    <span class="sidebar-normal"> Actividades por Hito </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptClientesGeneral.php" target="_blank">
                    <span class="sidebar-mini"> Cl </span>
                    <span class="sidebar-normal"> Clientes </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpCursos">
                    <span class="sidebar-mini"> Cu </span>
                    <span class="sidebar-normal"> Cursos </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpServicios">
                    <span class="sidebar-mini"> Se </span>
                    <span class="sidebar-normal"> Servicios </span>
                  </a>
                </li>  

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanAudi">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Plan de Auditorias </span>
                  </a>
                </li-->  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptPlanCuentas.php" target="_blank">
                    <span class="sidebar-mini"> PC </span>
                    <span class="sidebar-normal"> Plan de Cuentas</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoSIS">
                    <span class="sidebar-mini"> PS </span>
                    <span class="sidebar-normal"> Presupuesto SIS</span>
                  </a>
                </li>  

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespoa">
              <i class="material-icons">assessment</i>
              <p> Reportes POA
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespoa">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> RO </span>
                    <span class="sidebar-normal"> Reporte Obj. Estrategicos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOADetalle">
                    <span class="sidebar-mini"> PPOA </span>
                    <span class="sidebar-normal"> Planificacion POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOASector">
                    <span class="sidebar-mini"> PPS </span>
                    <span class="sidebar-normal"> Planificacion POA x Sector</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOA">
                    <span class="sidebar-mini"> EPOA </span>
                    <span class="sidebar-normal"> Ejecucion POA</span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOADetalle">
                    <span class="sidebar-mini"> EPD </span>
                    <span class="sidebar-normal"> Ejecucion POA Detalle</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOA">
                    <span class="sidebar-mini"> SPOA </span>
                    <span class="sidebar-normal">Seguimiento POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOAxArea">
                    <span class="sidebar-mini"> IxA </span>
                    <span class="sidebar-normal">Indicadores x Area</span>
                  </a>
                </li> 


              </ul>
            </div>
          </li>



          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespo">
              <i class="material-icons">assessment</i>
              <p> Reportes PO
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespo">
              <ul class="nav">  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOp">
                    <span class="sidebar-mini"> PO </span>
                    <span class="sidebar-normal"> Presupuesto Operativo</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOpResumen">
                    <span class="sidebar-mini"> RPO </span>
                    <span class="sidebar-normal"> Resumen </br> Presupuesto Operativo</span>
                  </a>
                </li>       

                <li class="nav-item ">
                 <a class="nav-link" href="?opcion=filtroSeguimientoPresOp">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroSegPresOpResumen">
                    <span class="sidebar-mini"> SPOR </span>
                    <span class="sidebar-normal"> Seguimiento PO Resumen </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPresOpxCuenta">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Cuenta </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPORegionArea">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Area y Regional </span>
                  </a>
                </li>       

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#utilitarios">
              <i class="material-icons">extension</i>
              <p> Utilitarios
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="utilitarios">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listEnlacesExternos">
                    <span class="sidebar-mini"> EE </span>
                    <span class="sidebar-normal"> Enlaces Externos </span>
                  </a>
                </li>
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestionTrabajo">
                    <span class="sidebar-mini"> CG </span>
                    <span class="sidebar-normal"> Cambiar Gestion de Trabajo </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listFechasRegistro">
                    <span class="sidebar-mini"> CG </span>
                    <span class="sidebar-normal"> Configurar Fechas Registro Ejecucion </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=cargarPresupuestoOp">
                    <span class="sidebar-mini"> CPO </span>
                    <span class="sidebar-normal"> Cargar Presupuesto Operativo </span>
                  </a>
                </li>   

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=cargarPOA">
                    <span class="sidebar-mini"> CPOA </span>
                    <span class="sidebar-normal"> Cargar POA </span>
                  </a>
                </li>   

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=descargarDatosConta">
                    <span class="sidebar-mini"> DC </span>
                    <span class="sidebar-normal"> Datos Contabilidad </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=descargarDatosPOA">
                    <span class="sidebar-mini"> DP </span>
                    <span class="sidebar-normal"> Datos POA </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=descargarDatosPO">
                    <span class="sidebar-mini"> DPO </span>
                    <span class="sidebar-normal">  Datos PO  </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=sincronizacionDatos">
                    <span class="sidebar-mini"> SD </span>
                    <span class="sidebar-normal"> Sincronizacion de Datos </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=versionarPOA">
                    <span class="sidebar-mini"> VP </span>
                    <span class="sidebar-normal"> Versionar POA </span>
                  </a>
                </li>   


              </ul>
            </div>
          </li>


        </ul>
      </div>
    </div>
<?php
}
?>


<?php
if($globalPerfilX==2){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>



        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i class="material-icons">fullscreen</i>
              <p> Tablas
                <b class="caret"></b>
              </p>
            </a>

            <div class="collapse" id="pagesExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listAreas">
                    <span class="sidebar-mini"> A </span>
                    <span class="sidebar-normal"> Areas </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestiones">
                    <span class="sidebar-mini"> G </span>
                    <span class="sidebar-normal"> Gestiones </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listHitos">
                    <span class="sidebar-mini"> H </span>
                    <span class="sidebar-normal"> Hitos Importantes </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listNormas">
                    <span class="sidebar-mini"> N </span>
                    <span class="sidebar-normal"> Normas </span>
                  </a>
                </li>
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSectores">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Sectores </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listUnidadOrg">
                    <span class="sidebar-mini"> O </span>
                    <span class="sidebar-normal"> Oficinas </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">menu</i>
              <p> Planificación Estratégica
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPerspectivas">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Perspectivas de Analisis</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivos">
                    <span class="sidebar-mini"> OE </span>
                    <span class="sidebar-normal"> Objetivos Estrategicos </span>
                  </a>
                </li>                
              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#operativo">
              <i class="material-icons">drag_indicator</i>
              <p> Planificación Operativa
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="operativo">
              <ul class="nav">                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOA&area=0&unidad=0&sector=0">
                    <span class="sidebar-mini"> POAP </span>
                    <span class="sidebar-normal">POA Programacion</span>
                  </a>
                </li>                
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAEjecucion&area=0&unidad=0">
                    <span class="sidebar-mini"> POAE </span>
                    <span class="sidebar-normal">POA Ejecucion</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAI&area=0&unidad=0">
                    <span class="sidebar-mini"> POAI </span>
                    <span class="sidebar-normal">POAI Programacion</span>
                  </a>
                </li>                

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAIEjecucion">
                    <span class="sidebar-mini"> POAIE </span>
                    <span class="sidebar-normal">POAI Ejecucion</span>
                  </a>
                </li--> 

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#proyectosis">
              <i class="material-icons">linear_scale</i>
              <p> Proyecto SIS
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="proyectosis">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listComponentesSIS">
                    <span class="sidebar-mini"> AS </span>
                    <span class="sidebar-normal"> Actividades </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSolicitudFondosSIS">
                    <span class="sidebar-mini"> SF </span>
                    <span class="sidebar-normal">Solicitud de Fondos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS2">
                    <span class="sidebar-mini"> SS </span>
                    <span class="sidebar-normal">Seguimiento</br>SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS">
                    <span class="sidebar-mini"> SDS </span>
                    <span class="sidebar-normal">Seguimiento</br>Detallado SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpDetalleGastosSIS">
                    <span class="sidebar-mini"> DGS </span>
                    <span class="sidebar-normal">Detalle Gastos SIS</span>
                  </a>
                </li>                                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpBalanceCuentasSIS">
                    <span class="sidebar-mini"> BC </span>
                    <span class="sidebar-normal">Balance de Cuentas</span>
                  </a>
                </li>                                

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportesgenerales">
              <i class="material-icons">assessment</i>
              <p> Reportes Generales
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportesgenerales">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptActividadesHitos">
                    <span class="sidebar-mini"> AH </span>
                    <span class="sidebar-normal"> Actividades por Hito </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptClientesGeneral.php" target="_blank">
                    <span class="sidebar-mini"> Cl </span>
                    <span class="sidebar-normal"> Clientes </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpCursos">
                    <span class="sidebar-mini"> Cu </span>
                    <span class="sidebar-normal"> Cursos </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpServicios">
                    <span class="sidebar-mini"> Se </span>
                    <span class="sidebar-normal"> Servicios </span>
                  </a>
                </li>  

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanAudi">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Plan de Auditorias </span>
                  </a>
                </li-->  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptPlanCuentas.php" target="_blank">
                    <span class="sidebar-mini"> PC </span>
                    <span class="sidebar-normal"> Plan de Cuentas</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoSIS">
                    <span class="sidebar-mini"> PS </span>
                    <span class="sidebar-normal"> Presupuesto SIS</span>
                  </a>
                </li>  

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespoa">
              <i class="material-icons">assessment</i>
              <p> Reportes POA
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespoa">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> RO </span>
                    <span class="sidebar-normal"> Reporte Obj. Estrategicos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOADetalle">
                    <span class="sidebar-mini"> PPOA </span>
                    <span class="sidebar-normal"> Planificacion POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOASector">
                    <span class="sidebar-mini"> PPS </span>
                    <span class="sidebar-normal"> Planificacion POA x Sector</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOA">
                    <span class="sidebar-mini"> EPOA </span>
                    <span class="sidebar-normal"> Ejecucion POA</span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOADetalle">
                    <span class="sidebar-mini"> EPD </span>
                    <span class="sidebar-normal"> Ejecucion POA Detalle</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOA">
                    <span class="sidebar-mini"> SPOA </span>
                    <span class="sidebar-normal">Seguimiento POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOAxArea">
                    <span class="sidebar-mini"> IxA </span>
                    <span class="sidebar-normal">Indicadores x Area</span>
                  </a>
                </li> 


              </ul>
            </div>
          </li>



          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespo">
              <i class="material-icons">assessment</i>
              <p> Reportes PO
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespo">
              <ul class="nav">  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOp">
                    <span class="sidebar-mini"> PO </span>
                    <span class="sidebar-normal"> Presupuesto Operativo</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOpResumen">
                    <span class="sidebar-mini"> RPO </span>
                    <span class="sidebar-normal"> Resumen </br> Presupuesto Operativo</span>
                  </a>
                </li>       

                <li class="nav-item ">
                 <a class="nav-link" href="?opcion=filtroSeguimientoPresOp">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroSegPresOpResumen">
                    <span class="sidebar-mini"> SPOR </span>
                    <span class="sidebar-normal"> Seguimiento PO Resumen </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPresOpxCuenta">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Cuenta </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPORegionArea">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Area y Regional </span>
                  </a>
                </li>       

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#utilitarios">
              <i class="material-icons">extension</i>
              <p> Utilitarios
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="utilitarios">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listEnlacesExternos">
                    <span class="sidebar-mini"> EE </span>
                    <span class="sidebar-normal"> Enlaces Externos </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestionTrabajo">
                    <span class="sidebar-mini"> CG </span>
                    <span class="sidebar-normal"> Cambiar Gestion de Trabajo </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>


        </ul>
      </div>
    </div>
<?php
}
?>



<?php
if($globalPerfilX==3){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>



        <ul class="nav">

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">menu</i>
              <p> Planificación Estratégica
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPerspectivas">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Perspectivas de Analisis</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivos">
                    <span class="sidebar-mini"> OE </span>
                    <span class="sidebar-normal"> Objetivos Estrategicos </span>
                  </a>
                </li>                
              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#operativo">
              <i class="material-icons">drag_indicator</i>
              <p> Planificación Operativa
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="operativo">
              <ul class="nav">                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOA&area=0&unidad=0&sector=0">
                    <span class="sidebar-mini"> POAP </span>
                    <span class="sidebar-normal">POA Programacion</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAEjecucion&area=0&unidad=0">
                    <span class="sidebar-mini"> POAE </span>
                    <span class="sidebar-normal">POA Ejecucion</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAI&area=0&unidad=0">
                    <span class="sidebar-mini"> POAI </span>
                    <span class="sidebar-normal">POAI Programacion</span>
                  </a>
                </li>  

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAIEjecucion">
                    <span class="sidebar-mini"> POAIE </span>
                    <span class="sidebar-normal">POAI Ejecucion</span>
                  </a>
                </li-->               

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportesgenerales">
              <i class="material-icons">assessment</i>
              <p> Reportes Generales
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportesgenerales">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptActividadesHitos">
                    <span class="sidebar-mini"> AH </span>
                    <span class="sidebar-normal"> Actividades por Hito </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptClientesGeneral.php" target="_blank">
                    <span class="sidebar-mini"> Cl </span>
                    <span class="sidebar-normal"> Clientes </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpCursos">
                    <span class="sidebar-mini"> Cu </span>
                    <span class="sidebar-normal"> Cursos </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpServicios">
                    <span class="sidebar-mini"> Se </span>
                    <span class="sidebar-normal"> Servicios </span>
                  </a>
                </li>  

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanAudi">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Plan de Auditorias </span>
                  </a>
                </li-->  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptPlanCuentas.php" target="_blank">
                    <span class="sidebar-mini"> PC </span>
                    <span class="sidebar-normal"> Plan de Cuentas</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoSIS">
                    <span class="sidebar-mini"> PS </span>
                    <span class="sidebar-normal"> Presupuesto SIS</span>
                  </a>
                </li>  

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespoa">
              <i class="material-icons">assessment</i>
              <p> Reportes POA
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespoa">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> RO </span>
                    <span class="sidebar-normal"> Reporte Obj. Estrategicos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOADetalle">
                    <span class="sidebar-mini"> PPOA </span>
                    <span class="sidebar-normal"> Planificacion POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOASector">
                    <span class="sidebar-mini"> PPS </span>
                    <span class="sidebar-normal"> Planificacion POA x Sector</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOA">
                    <span class="sidebar-mini"> EPOA </span>
                    <span class="sidebar-normal"> Ejecucion POA</span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOADetalle">
                    <span class="sidebar-mini"> EPD </span>
                    <span class="sidebar-normal"> Ejecucion POA Detalle</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOA">
                    <span class="sidebar-mini"> SPOA </span>
                    <span class="sidebar-normal">Seguimiento POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOAxArea">
                    <span class="sidebar-mini"> IxA </span>
                    <span class="sidebar-normal">Indicadores x Area</span>
                  </a>
                </li> 


              </ul>
            </div>
          </li>



          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespo">
              <i class="material-icons">assessment</i>
              <p> Reportes PO
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespo">
              <ul class="nav">  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOp">
                    <span class="sidebar-mini"> PO </span>
                    <span class="sidebar-normal"> Presupuesto Operativo</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOpResumen">
                    <span class="sidebar-mini"> RPO </span>
                    <span class="sidebar-normal"> Resumen </br> Presupuesto Operativo</span>
                  </a>
                </li>       

                <li class="nav-item ">
                 <a class="nav-link" href="?opcion=filtroSeguimientoPresOp">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroSegPresOpResumen">
                    <span class="sidebar-mini"> SPOR </span>
                    <span class="sidebar-normal"> Seguimiento PO Resumen </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPresOpxCuenta">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Cuenta </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPORegionArea">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Area y Regional </span>
                  </a>
                </li>       

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#utilitarios">
              <i class="material-icons">extension</i>
              <p> Utilitarios
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="utilitarios">
              <ul class="nav">
  
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listEnlacesExternos">
                    <span class="sidebar-mini"> EE </span>
                    <span class="sidebar-normal"> Enlaces Externos </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestionTrabajo">
                    <span class="sidebar-mini"> CG </span>
                    <span class="sidebar-normal"> Cambiar Gestion de Trabajo </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
    </div>
<?php
}
?>


<?php
if($globalPerfilX==4){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>

        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#proyectosis">
              <i class="material-icons">linear_scale</i>
              <p> Proyecto SIS
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="proyectosis">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listComponentesSIS">
                    <span class="sidebar-mini"> AS </span>
                    <span class="sidebar-normal"> Actividades </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSolicitudFondosSIS">
                    <span class="sidebar-mini"> SF </span>
                    <span class="sidebar-normal">Solicitud de Fondos</span>
                  </a>
                </li>                
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS2">
                    <span class="sidebar-mini"> SS </span>
                    <span class="sidebar-normal">Seguimiento</br>SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS">
                    <span class="sidebar-mini"> SDS </span>
                    <span class="sidebar-normal">Seguimiento</br>Detallado SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpDetalleGastosSIS">
                    <span class="sidebar-mini"> DGS </span>
                    <span class="sidebar-normal">Detalle Gastos SIS</span>
                  </a>
                </li>                                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpRelacionGastosAcc">
                    <span class="sidebar-mini"> DGAN </span>
                    <span class="sidebar-normal">Detalle Gastos con AccNum</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpBalanceCuentasSIS">
                    <span class="sidebar-mini"> BC </span>
                    <span class="sidebar-normal">Balance de Cuentas</span>
                  </a>
                </li>                                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=resumenGeneralSIS">
                    <span class="sidebar-mini"> RGS </span>
                    <span class="sidebar-normal">Revisión General SIS</span>
                  </a>
                </li>                                

              </ul>
            </div>
          </li>

     <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespoa">
              <i class="material-icons">assessment</i>
              <p> Reportes POA
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespoa">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> RO </span>
                    <span class="sidebar-normal"> Reporte Obj. Estrategicos</span>
                  </a>
                </li>                

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#utilitarios">
              <i class="material-icons">extension</i>
              <p> Utilitarios
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="utilitarios">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestionTrabajo">
                    <span class="sidebar-mini"> CG </span>
                    <span class="sidebar-normal"> Cambiar Gestion de Trabajo </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

          

        </ul>
      </div>
    </div>
<?php
}

//PERFIL DNAF
if($globalPerfilX==5){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>



        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i class="material-icons">fullscreen</i>
              <p> Tablas
                <b class="caret"></b>
              </p>
            </a>

            <div class="collapse" id="pagesExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listAreas">
                    <span class="sidebar-mini"> A </span>
                    <span class="sidebar-normal"> Areas </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listCargos">
                    <span class="sidebar-mini"> C </span>
                    <span class="sidebar-normal"> Cargos </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listComites">
                    <span class="sidebar-mini"> Co </span>
                    <span class="sidebar-normal"> Comites </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listEstadosPON">
                    <span class="sidebar-mini"> EP </span>
                    <span class="sidebar-normal"> Estados PON </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listModosGeneracionPON">
                    <span class="sidebar-mini"> MGP </span>
                    <span class="sidebar-normal"> Modos de Generacion PON </span>
                  </a>
                </li>


                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestiones">
                    <span class="sidebar-mini"> G </span>
                    <span class="sidebar-normal"> Gestiones </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listHitos">
                    <span class="sidebar-mini"> H </span>
                    <span class="sidebar-normal"> Hitos Importantes </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listNormas">
                    <span class="sidebar-mini"> N </span>
                    <span class="sidebar-normal"> Normas </span>
                  </a>
                </li>
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSectores">
                    <span class="sidebar-mini"> S </span>
                    <span class="sidebar-normal"> Sectores </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listUnidadOrg">
                    <span class="sidebar-mini"> O </span>
                    <span class="sidebar-normal"> Oficinas </span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPersonal">
                    <span class="sidebar-mini"> P </span>
                    <span class="sidebar-normal"> Personal </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">menu</i>
              <p> Planificación Estratégica
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPerspectivas">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Perspectivas de Analisis</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivos">
                    <span class="sidebar-mini"> OE </span>
                    <span class="sidebar-normal"> Objetivos Estrategicos </span>
                  </a>
                </li>                
              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#operativo">
              <i class="material-icons">drag_indicator</i>
              <p> Planificación Operativa
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="operativo">
              <ul class="nav">
                
                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivosOp">
                    <span class="sidebar-mini"> OO </span>
                    <span class="sidebar-normal"> Objetivos Operativos</span>
                  </a>
                </li-->                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOA&area=0&unidad=0&sector=0">
                    <span class="sidebar-mini"> POAP </span>
                    <span class="sidebar-normal">POA Programacion</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAEjecucion&area=0&unidad=0">
                    <span class="sidebar-mini"> POAE </span>
                    <span class="sidebar-normal">POA Ejecucion</span>
                  </a>
                </li> 

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#proyectosis">
              <i class="material-icons">linear_scale</i>
              <p> Proyecto SIS
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="proyectosis">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listComponentesSIS">
                    <span class="sidebar-mini"> AS </span>
                    <span class="sidebar-normal"> Actividades </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listExternalCostsSIS">
                    <span class="sidebar-mini"> EC </span>
                    <span class="sidebar-normal"> External Costs </span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listSolicitudFondosSIS">
                    <span class="sidebar-mini"> SF </span>
                    <span class="sidebar-normal">Solicitud de Fondos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS2">
                    <span class="sidebar-mini"> SS </span>
                    <span class="sidebar-normal">Seguimiento</br>SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS">
                    <span class="sidebar-mini"> SDS </span>
                    <span class="sidebar-normal">Seguimiento</br>Detallado SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpDetalleGastosSIS">
                    <span class="sidebar-mini"> DGS </span>
                    <span class="sidebar-normal">Detalle Gastos SIS</span>
                  </a>
                </li>    

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpRelacionGastosAcc">
                    <span class="sidebar-mini"> DGAN </span>
                    <span class="sidebar-normal">Detalle Gastos con AccNum</span>
                  </a>
                </li>                            

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpBalanceCuentasSIS">
                    <span class="sidebar-mini"> BC </span>
                    <span class="sidebar-normal">Balance de Cuentas</span>
                  </a>
                </li>                                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=resumenGeneralSIS">
                    <span class="sidebar-mini"> RGS </span>
                    <span class="sidebar-normal">Revisión General SIS</span>
                  </a>
                </li>                                


              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportesgenerales">
              <i class="material-icons">assessment</i>
              <p> Reportes Generales
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportesgenerales">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptActividadesHitos">
                    <span class="sidebar-mini"> AH </span>
                    <span class="sidebar-normal"> Actividades por Hito </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptClientesGeneral.php" target="_blank">
                    <span class="sidebar-mini"> Cl </span>
                    <span class="sidebar-normal"> Clientes </span>
                  </a>
                </li>  
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpCursos">
                    <span class="sidebar-mini"> Cu </span>
                    <span class="sidebar-normal"> Cursos </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpServicios">
                    <span class="sidebar-mini"> Se </span>
                    <span class="sidebar-normal"> Servicios </span>
                  </a>
                </li>  

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanAudi">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Plan de Auditorias </span>
                  </a>
                </li-->  

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptPlanCuentas.php" target="_blank">
                    <span class="sidebar-mini"> PC </span>
                    <span class="sidebar-normal"> Plan de Cuentas</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoSIS">
                    <span class="sidebar-mini"> PS </span>
                    <span class="sidebar-normal"> Presupuesto SIS</span>
                  </a>
                </li>  

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespoa">
              <i class="material-icons">assessment</i>
              <p> Reportes POA
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespoa">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> RO </span>
                    <span class="sidebar-normal"> Reporte Obj. Estrategicos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOADetalle">
                    <span class="sidebar-mini"> PPOA </span>
                    <span class="sidebar-normal"> Planificacion POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOASector">
                    <span class="sidebar-mini"> PPS </span>
                    <span class="sidebar-normal"> Planificacion POA x Sector</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOA">
                    <span class="sidebar-mini"> EPOA </span>
                    <span class="sidebar-normal"> Ejecucion POA</span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOADetalle">
                    <span class="sidebar-mini"> EPD </span>
                    <span class="sidebar-normal"> Ejecucion POA Detalle</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOA">
                    <span class="sidebar-mini"> SPOA </span>
                    <span class="sidebar-normal">Seguimiento POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOAxArea">
                    <span class="sidebar-mini"> IxA </span>
                    <span class="sidebar-normal">Indicadores x Area</span>
                  </a>
                </li> 


              </ul>
            </div>
          </li>



          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportespo">
              <i class="material-icons">assessment</i>
              <p> Reportes PO
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportespo">
              <ul class="nav">  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOp">
                    <span class="sidebar-mini"> PO </span>
                    <span class="sidebar-normal"> Presupuesto Operativo</span>
                  </a>
                </li>

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOpResumen">
                    <span class="sidebar-mini"> RPO </span>
                    <span class="sidebar-normal"> Resumen </br> Presupuesto Operativo</span>
                  </a>
                </li>       

                <li class="nav-item ">
                 <a class="nav-link" href="?opcion=filtroSeguimientoPresOp">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroSegPresOpResumen">
                    <span class="sidebar-mini"> SPOR </span>
                    <span class="sidebar-normal"> Seguimiento PO Resumen </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPresOpxCuenta">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Cuenta </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPORegionArea">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Area y Regional </span>
                  </a>
                </li>       

              </ul>
            </div>
          </li>



        </ul>
      </div>
    </div>
<?php
}
?>


<?php
if($globalPerfilX==6){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>



        <ul class="nav">

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">menu</i>
              <p> Planificación Estratégica
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPerspectivas">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Perspectivas de Analisis</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listObjetivos">
                    <span class="sidebar-mini"> OE </span>
                    <span class="sidebar-normal"> Objetivos Estrategicos </span>
                  </a>
                </li>                
              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#operativo">
              <i class="material-icons">drag_indicator</i>
              <p> Planificación Operativa
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="operativo">
              <ul class="nav">                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOA&area=0&unidad=0&sector=0">
                    <span class="sidebar-mini"> POAP </span>
                    <span class="sidebar-normal">POA Programacion</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listPOAEjecucion&area=0&unidad=0">
                    <span class="sidebar-mini"> POAE </span>
                    <span class="sidebar-normal">POA Ejecucion</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOA">
                    <span class="sidebar-mini"> SPOA </span>
                    <span class="sidebar-normal">Seguimiento POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOAxArea">
                    <span class="sidebar-mini"> IxA </span>
                    <span class="sidebar-normal">Indicadores x Area</span>
                  </a>
                </li> 


                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroSeguimientoPresOp">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroSegPresOpResumen">
                    <span class="sidebar-mini"> SPOR </span>
                    <span class="sidebar-normal"> Seguimiento PO Resumen </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPresOpxCuenta">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Cuenta </span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPORegionArea">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Area y Regional </span>
                  </a>
                </li>

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#proyectosis">
              <i class="material-icons">linear_scale</i>
              <p> Proyecto SIS
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="proyectosis">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS2">
                    <span class="sidebar-mini"> SS </span>
                    <span class="sidebar-normal">Seguimiento</br>SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS">
                    <span class="sidebar-mini"> SDS </span>
                    <span class="sidebar-normal">Seguimiento</br>Detallado SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpDetalleGastosSIS">
                    <span class="sidebar-mini"> DGS </span>
                    <span class="sidebar-normal">Detalle Gastos SIS</span>
                  </a>
                </li>    

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpRelacionGastosAcc">
                    <span class="sidebar-mini"> DGAN </span>
                    <span class="sidebar-normal">Detalle Gastos con AccNum</span>
                  </a>
                </li>                            

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpBalanceCuentasSIS">
                    <span class="sidebar-mini"> BC </span>
                    <span class="sidebar-normal">Balance de Cuentas</span>
                  </a>
                </li>                                

              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportes">
              <i class="material-icons">assessment</i>
              <p> Reportes
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportes">
              <ul class="nav">
                
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpActividadesHitos">
                    <span class="sidebar-mini"> AH </span>
                    <span class="sidebar-normal"> Actividades por Hito </span>
                  </a>
                </li>  


                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpCursos">
                    <span class="sidebar-mini"> Cu </span>
                    <span class="sidebar-normal"> Cursos </span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpServicios">
                    <span class="sidebar-mini"> Se </span>
                    <span class="sidebar-normal"> Servicios </span>
                  </a>
                </li>  

                <!--li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanAudi">
                    <span class="sidebar-mini"> PA </span>
                    <span class="sidebar-normal"> Plan de Auditorias </span>
                  </a>
                </li-->

                <li class="nav-item ">
                  <a class="nav-link" href="reportes/rptObjConf.php" target="_blank">
                    <span class="sidebar-mini"> RO </span>
                    <span class="sidebar-normal"> Reporte Obj. Estrategicos</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPlanificacionPOADetalle">
                    <span class="sidebar-mini"> PPOA </span>
                    <span class="sidebar-normal"> Planificacion POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOA">
                    <span class="sidebar-mini"> EPOA </span>
                    <span class="sidebar-normal"> Ejecucion POA</span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpEjecucionPOADetalle">
                    <span class="sidebar-mini"> EPD </span>
                    <span class="sidebar-normal"> Ejecucion POA Detalle</span>
                  </a>
                </li>  

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpPresupuestoOp">
                    <span class="sidebar-mini"> PO </span>
                    <span class="sidebar-normal"> Presupuesto Operativo</span>
                  </a>
                </li>

              </ul>
            </div>
          </li>


          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#utilitarios">
              <i class="material-icons">extension</i>
              <p> Utilitarios
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="utilitarios">
              <ul class="nav">
  
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listEnlacesExternos">
                    <span class="sidebar-mini"> EE </span>
                    <span class="sidebar-normal"> Enlaces Externos </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=listGestionTrabajo">
                    <span class="sidebar-mini"> CG </span>
                    <span class="sidebar-normal"> Cambiar Gestion de Trabajo </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>

        </ul>
      </div>
    </div>
<?php
}
?>


<?php
if($globalPerfilX==7){
?>
<div class="sidebar" data-color="azure" data-background-color="black" data-image="assets/img/sidebar-1.jpg">
      <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          <img src="assets/img/logoibnorca.fw.png" width="30" />
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
          SIMC IBNORCA
        </a>
      </div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
            <img src="assets/img/faces/persona1.png" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
                <?=$globalNameUserX;?>
                <!--b class="caret"></b-->
              </span>
            </a>
          </div>
        </div>



        <ul class="nav">

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reportes">
              <i class="material-icons">assessment</i>
              <p> Reportes
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reportes">
              <ul class="nav"> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOA">
                    <span class="sidebar-mini"> SPOA </span>
                    <span class="sidebar-normal">Seguimiento POA</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoPOAxArea">
                    <span class="sidebar-mini"> IxA </span>
                    <span class="sidebar-normal">Indicadores x Area</span>
                  </a>
                </li> 

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=filtroRevisionPORegionArea">
                    <span class="sidebar-mini"> SPO </span>
                    <span class="sidebar-normal"> Seguimiento PO por Area y Regional </span>
                  </a>
                </li>


              </ul>
            </div>
          </li>

          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#proyectosis">
              <i class="material-icons">linear_scale</i>
              <p> Proyecto SIS
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="proyectosis">
              <ul class="nav">

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS2">
                    <span class="sidebar-mini"> SS </span>
                    <span class="sidebar-normal">Seguimiento</br>SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=seguimientoAnualSIS">
                    <span class="sidebar-mini"> SDS </span>
                    <span class="sidebar-normal">Seguimiento</br>Detallado SIS</span>
                  </a>
                </li>                

                <li class="nav-item ">
                  <a class="nav-link" href="?opcion=rptOpDetalleGastosSIS">
                    <span class="sidebar-mini"> DGS </span>
                    <span class="sidebar-normal">Detalle Gastos SIS</span>
                  </a>
                </li>    

              </ul>
            </div>
          </li>


        </ul>
      </div>
    </div>
<?php
}
?>



