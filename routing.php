<?php 
	
	if(isset($_GET['opcion'])){
		//UNIDADES ORGANIZACIONALES
		if ($_GET['opcion']=='listUnidadOrg') {
			require_once('unidadesOrganizacionales/list.php');
		}
		if ($_GET['opcion']=='registerUnidadOrg') {
			require_once('unidadesOrganizacionales/register.php');
		}
		if ($_GET['opcion']=='editUnidadOrg') {
			$codigo=$_GET['codigo'];
			require_once('unidadesOrganizacionales/edit.php');
		}
		if ($_GET['opcion']=='deleteUnidadOrg') {
			$codigo=$_GET['codigo'];
			require_once('unidadesOrganizacionales/saveDelete.php');
		}		
		if ($_GET['opcion']=='registerOfPOA') {
			require_once('unidadesOrganizacionales/registerOfPOA.php');
		}
		if ($_GET['opcion']=='registerOfArea') {
			$codigo=$_GET['codigo'];
			require_once('unidadesOrganizacionales/registerOfArea.php');
		}		
		if ($_GET['opcion']=='registerOfHijo') {
			$codigo=$_GET['codigo'];
			require_once('unidadesOrganizacionales/registerOfHijo.php');
		}		
		
		
		//AREAS
		if ($_GET['opcion']=='listAreas') {
			require_once('areas/list.php');
		}
		if ($_GET['opcion']=='registerArea') {
			require_once('areas/register.php');
		}
		if ($_GET['opcion']=='editArea') {
			$codigo=$_GET['codigo'];
			require_once('areas/edit.php');
		}
		if ($_GET['opcion']=='deleteArea') {
			$codigo=$_GET['codigo'];
			require_once('areas/saveDelete.php');
		}	
		if ($_GET['opcion']=='registerAreaPOA') {
			require_once('areas/registerAreaPOA.php');
		}
		if ($_GET['opcion']=='registerOfCargo') {
			$codigo=$_GET['codigo'];
			require_once('areas/registerOfCargo.php');
		}

		//COMITES
		if ($_GET['opcion']=='listComites') {
			require_once('comites/list.php');
		}

		//GESTIONES
		if ($_GET['opcion']=='listGestiones') {
			require_once('gestiones/list.php');
		}
		if ($_GET['opcion']=='configurarGestion') {
			$codigo=$_GET['codigo'];
			require_once('gestiones/config.php');
		}

		//GESTIONES EXTENDIDAS
		if ($_GET['opcion']=='listGestionesExtendidas') {
			require_once('gestiones_extendidas/list.php');
		}
        if ($_GET['opcion']=='registerGestionExtendida') {
			require_once('gestiones_extendidas/register.php');
		}
		if ($_GET['opcion']=='configurarGestionExtendida') {
			$id_gestion=$_GET['id_gestion'];
			require_once('gestiones_extendidas/config.php');
		}
		//PERSONAL
		if ($_GET['opcion']=='listPersonal') {
			require_once('personal/list.php');
		}
		if ($_GET['opcion']=='listPersonalInactivo') {
			require_once('personal/listInactivo.php');
		}
		if ($_GET['opcion']=='editPersonal') {
			$codigo=$_GET['codigo'];
			require_once('personal/edit.php');
		}
		if ($_GET['opcion']=='deletePersonal') {
			$codigo=$_GET['codigo'];
			require_once('personal/saveDelete.php');
		}			
		if ($_GET['opcion']=='addAreas') {
			$codigo=$_GET['codigo'];
			require_once('personal/registerOfArea.php');
		}		
		if ($_GET['opcion']=='addUnidades') {
			$codigo=$_GET['codigo'];
			require_once('personal/registerOfUnidad.php');
		}				
		if ($_GET['opcion']=='activarPersonal') {
			$codigo=$_GET['codigo'];
			require_once('personal/saveActivar.php');
		}	

		//PLAN DE CUENTAS
		if ($_GET['opcion']=='listPlanCuentas') {
			require_once('plan_de_cuentas/list2.php');
		}
		if ($_GET['opcion']=='addCostosDirectos') {
			require_once('plan_de_cuentas/registerOfCostodirecto.php');
		}				


		//NORMAS
		if ($_GET['opcion']=='listNormas') {
			require_once('normas/list.php');
		}
		if ($_GET['opcion']=='registerNormaPriorizada') {
			require_once('normas/registerNormaPriorizada.php');
		}

		//SECTORES
		if ($_GET['opcion']=='listSectores') {
			require_once('sectores/list.php');
		}
		if ($_GET['opcion']=='registerSector') {
			require_once('sectores/register.php');
		}
		if ($_GET['opcion']=='editSector') {
			$codigo=$_GET['codigo'];
			require_once('sectores/edit.php');
		}
		if ($_GET['opcion']=='deleteSector') {
			$codigo=$_GET['codigo'];
			require_once('sectores/saveDelete.php');
		}
		if ($_GET['opcion']=='listSectoresNormalizacion') {
			require_once('sectoresnormalizacion/list.php');
		}
		

		//HITOS
		if ($_GET['opcion']=='listHitos') {
			require_once('hitos/list.php');
		}
		if ($_GET['opcion']=='registerHito') {
			require_once('hitos/register.php');
		}
		if ($_GET['opcion']=='editHito') {
			$codigo=$_GET['codigo'];
			require_once('hitos/edit.php');
		}
		if ($_GET['opcion']=='deleteHito') {
			$codigo=$_GET['codigo'];
			require_once('hitos/saveDelete.php');
		}	

		//CARGOS
		if ($_GET['opcion']=='listCargos') {
			require_once('cargos/list.php');
		}
		if ($_GET['opcion']=='listCargosInactivos') {
			require_once('cargos/listInactivos.php');
		}
		if ($_GET['opcion']=='registerCargo') {
			require_once('cargos/register.php');
		}
		if ($_GET['opcion']=='editCargo') {
			$codigo=$_GET['codigo'];
			require_once('cargos/edit.php');
		}
		if ($_GET['opcion']=='deleteCargo') {
			$codigo=$_GET['codigo'];
			require_once('cargos/saveDelete.php');
		}
		if ($_GET['opcion']=='restartCargo') {
			$codigo=$_GET['codigo'];
			require_once('cargos/saveRestart.php');
		}

		if ($_GET['opcion']=='listFunciones') {
			$codigo=$_GET['codigo'];
			require_once('cargos/listFunciones.php');
		}
		if ($_GET['opcion']=='registerFuncionCargo') {
			$codigo=$_GET['codigo'];
			require_once('cargos/registerFuncionCargo.php');
		}		
		if ($_GET['opcion']=='editFuncionCargo') {
			$codigo=$_GET['codigo'];
			require_once('cargos/editFuncionCargo.php');
		}		
		if ($_GET['opcion']=='deleteFuncionCargo') {
			$codigo=$_GET['codigo'];
			require_once('cargos/saveDeleteFuncionCargo.php');
		}		


		//ESTADOS PON
		if ($_GET['opcion']=='listEstadosPON') {
			require_once('estados_pon/list.php');
		}
		if ($_GET['opcion']=='registerEstadoPON') {
			require_once('estados_pon/register.php');
		}
		if ($_GET['opcion']=='editEstadoPON') {
			$codigo=$_GET['codigo'];
			require_once('estados_pon/edit.php');
		}
		if ($_GET['opcion']=='deleteEstadoPON') {
			$codigo=$_GET['codigo'];
			require_once('estados_pon/saveDelete.php');
		}	


		//MODOS DE GENERACION PON
		if ($_GET['opcion']=='listModosGeneracionPON') {
			require_once('modos_generacion_pon/list.php');
		}
		if ($_GET['opcion']=='registerModoGeneracionPON') {
			require_once('modos_generacion_pon/register.php');
		}
		if ($_GET['opcion']=='editModoGeneracionPON') {
			$codigo=$_GET['codigo'];
			require_once('modos_generacion_pon/edit.php');
		}
		if ($_GET['opcion']=='deleteModoGeneracionPON') {
			$codigo=$_GET['codigo'];
			require_once('modos_generacion_pon/saveDelete.php');
		}	

		//PERSPECTIVAS
		if ($_GET['opcion']=='listPerspectivas') {
			require_once('perspectivas/list.php');
		}
		if ($_GET['opcion']=='registerPerspectiva') {
			require_once('perspectivas/register.php');
		}
		if ($_GET['opcion']=='editPerspectiva') {
			$codigo=$_GET['codigo'];
			require_once('perspectivas/edit.php');
		}
		if ($_GET['opcion']=='deletePerspectiva') {
			$codigo=$_GET['codigo'];
			require_once('perspectivas/saveDelete.php');
		}	

		
		//TIPOS DE SEGUIMIENTO
		if ($_GET['opcion']=='listTiposSeg') {
			require_once('tipos_seguimiento/list.php');
		}
		if ($_GET['opcion']=='registerTiposSeg') {
			require_once('tipos_seguimiento/register.php');
		}
		if ($_GET['opcion']=='editTiposSeg') {
			$codigo=$_GET['codigo'];
			require_once('tipos_seguimiento/edit.php');
		}
		if ($_GET['opcion']=='deleteTiposSeg') {
			$codigo=$_GET['codigo'];
			require_once('tipos_seguimiento/saveDelete.php');
		}

		//UTILITARIOS
		if ($_GET['opcion']=='listGestionTrabajo') {
			require_once('utilitarios/listGestionTrabajo.php');
		}
		if ($_GET['opcion']=='listFechasRegistro') {
			require_once('utilitarios/listFechasRegistro.php');
		}
		if ($_GET['opcion']=='editFechaRegistro') {
			$anio=$_GET['anio'];
			$mes=$_GET['mes'];
			require_once('utilitarios/editFechasRegistro.php');
		}
		if ($_GET['opcion']=='descargarDatosConta') {
			require_once('utilitarios/descargarDatosConta.php');
		}
		if ($_GET['opcion']=='descargarDatosPOA') {
			require_once('utilitarios/descargarDatosPOA.php');
		}
		if ($_GET['opcion']=='descargarDatosPO') {
			require_once('utilitarios/descargarDatosPO.php');
		}
		if ($_GET['opcion']=='sincronizacionDatos') {
			require_once('utilitarios/sincronizacionDatos.php');
		}
		if ($_GET['opcion']=='versionarPOA') {
			require_once('versiones_poa/list.php');
		}
		if ($_GET['opcion']=='deleteVersionPOA') {
			$codigo=$_GET['codigo'];
			require_once('versiones_poa/saveDelete.php');
		}
		if ($_GET['opcion']=='registerVersionPOA') {
			require_once('versiones_poa/register.php');
		}
		if ($_GET['opcion']=='generarVersionPOA') {
			$codigo=$_GET['codigo'];
			require_once('versiones_poa/saveGenerarPOA.php');
		}
		if ($_GET['opcion']=='cargarPOA') {
			require_once('utilitarios/cargarPOA.php');
		}

		if ($_GET['opcion']=='cargarPOAI') {
			require_once('utilitarios/cargarPOAI.php');
		}

		//ENLACES EXTERNOS
		if ($_GET['opcion']=='listEnlacesExternos') {
			require_once('enlaces_externos/list.php');
		}
		if ($_GET['opcion']=='registerEnlaceExterno') {
			require_once('enlaces_externos/register.php');
		}
		if ($_GET['opcion']=='deleteEnlaceExterno') {
			$codigo=$_GET['codigo'];
			require_once('enlaces_externos/saveDelete.php');
		}




		//PRESUPUESTO OPERATIVO
		if ($_GET['opcion']=='cargarPresupuestoOp') {
			require_once('presupuesto_operativo/cargarPresupuestoOp.php');
		}
		if ($_GET['opcion']=='filtroSeguimientoPresOp') {
			require_once('presupuesto_operativo/rptOpSeguimiento.php');
		}
		if ($_GET['opcion']=='filtroSegPresOpResumen') {
			require_once('presupuesto_operativo/rptOpSeguimientoResumen.php');
		}
		if ($_GET['opcion']=='filtroRevisionPresOpxCuenta') {
			require_once('presupuesto_operativo/rptOpSeguimientoxCuenta.php');
		}
		if ($_GET['opcion']=='filtroRevisionPORegionArea') {
			require_once('presupuesto_operativo/rptOpSeguimientoxAreaRegion.php');
		}
		if ($_GET['opcion']=='configuracionDistribucion') {
			require_once('presupuesto_operativo/configurarDistribucionDNSA.php');
		}
		if ($_GET['opcion']=='distribucionDNSA') {
			require_once('presupuesto_operativo/distribucionDNSA.php');
		}

		


		//OBJETIVOS
		if ($_GET['opcion']=='listObjetivos') {
			require_once('objetivos/list.php');
		}
		if ($_GET['opcion']=='registerObjetivo') {
			require_once('objetivos/register.php');
		}
		if ($_GET['opcion']=='editObjetivo') {
			$codigo=$_GET['codigo'];
			require_once('objetivos/edit.php');
		}
		if ($_GET['opcion']=='deleteObjetivo') {
			$codigo=$_GET['codigo'];
			require_once('objetivos/saveDelete.php');
		}

		//INDICADORES
		if ($_GET['opcion']=='listIndicadores') {
			$codigo=$_GET['codigo'];
			require_once('indicadores/list.php');
		}
		if ($_GET['opcion']=='registerIndicador') {
			$codigo=$_GET['codigo'];
			require_once('indicadores/register.php');
		}
		if ($_GET['opcion']=='editIndicador') {
			$codigo=$_GET['codigo'];
			$codigo_objetivo=$_GET['codigo_objetivo'];
			require_once('indicadores/edit.php');
		}
		if ($_GET['opcion']=='deleteIndicador') {
			$codigo=$_GET['codigo'];
			$codigo_objetivo=$_GET['codigo_objetivo'];
			require_once('indicadores/saveDelete.php');
		}
		if ($_GET['opcion']=='registerIndMetas') {
			$codigo=$_GET['codigo'];
			$codigo_objetivo=$_GET['codigo_objetivo'];
			require_once('indicadores/registerMetas.php');
		}

		//OBJETIVOS OPERATIVOS
		if ($_GET['opcion']=='listObjetivosOp') {
			require_once('objetivos_operativos/list.php');
		}
		if ($_GET['opcion']=='registerObjetivoOp') {
			require_once('objetivos_operativos/register.php');
		}
		if ($_GET['opcion']=='editObjetivoOp') {
			$codigo=$_GET['codigo'];
			require_once('objetivos_operativos/edit.php');
		}
		if ($_GET['opcion']=='deleteObjetivoOp') {
			$codigo=$_GET['codigo'];
			require_once('objetivos_operativos/saveDelete.php');
		}

		//INDICADORES OPERATIVOS
		if ($_GET['opcion']=='listIndicadoresOp') {
			$codigo=$_GET['codigo'];
			require_once('indicadores_operativos/list.php');
		}
		if ($_GET['opcion']=='registerIndicadorOp') {
			$codigo=$_GET['codigo'];
			require_once('indicadores_operativos/register.php');
		}
		if ($_GET['opcion']=='editIndicadorOp') {
			$codigo=$_GET['codigo'];
			require_once('indicadores_operativos/edit.php');
		}
		if ($_GET['opcion']=='deleteIndicadorOp') {
			$codigo=$_GET['codigo'];
			require_once('indicadores_operativos/saveDelete.php');
		}

		//POA  - PON
		if ($_GET['opcion']=='listPOA') {
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			$sector=$_GET['sector'];
			require_once('poa/list.php');
		}
		if ($_GET['opcion']=='listPOAEjecucion') {
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			require_once('poa/listEjecucion.php');
		}
		if ($_GET['opcion']=='listActividadesPOA') {
			$codigo=$_GET['codigo'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			require_once('poa/listActividades.php');

		}
		if ($_GET['opcion']=='listActividadesPOAEjecucion') {
			$codigo=$_GET['codigo'];
			$codigoPON=$_GET['codigoPON'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];

			if($codigo==$codigoPON){
				require_once('poa/listActividadesEjecucionPON.php');
			}else{
				require_once('poa/listActividadesEjecucion.php');
			}
		}
		if ($_GET['opcion']=='registerPOAActInd') {
			$codigo=$_GET['codigo'];
			require_once('poa/register.php');
		}
		if ($_GET['opcion']=='registerPOAGroup') {
			$codigo=$_GET['codigo'];
			$areaUnidad=$_GET['areaUnidad'];
			require_once('poa/registerGroup.php');
		}
		if ($_GET['opcion']=='editPOAAct') {
			$codigoActividad=$_GET['codigo'];
			$codigoIndicador=$_GET['codigo_indicador'];
			$areaUnidad=$_GET['areaUnidad'];
			require_once('poa/edit.php');
		}
		if ($_GET['opcion']=='editPOAClasificadort') {
			$codigoActividad=$_GET['codigo'];
			$codigoIndicador=$_GET['codigo_indicador'];
			$areaUnidad=$_GET['areaUnidad'];
			require_once('poa/editClasificador.php');
		}
		if ($_GET['opcion']=='registerPOAPONGroup') {
			$codigo=$_GET['codigo'];
			$areaUnidad=$_GET['areaUnidad'];
			require_once('poa/registerGroupPON.php');
		}
		if ($_GET['opcion']=='registerPOAPlan') {
			$codigo=$_GET['codigo'];
			require_once('poa/registerPlan.php');
		}
		if ($_GET['opcion']=='registerPOAPONPlan') {
			$codigo=$_GET['codigo'];
			require_once('poa/registerPlanPON.php');
		}
		if ($_GET['opcion']=='registerPOAEjecucion') {
			$codigo=$_GET['codigo'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			require_once('poa/registerEjecucion.php');
		}
		if ($_GET['opcion']=='registerPONEjecucion') {
			$codigo=$_GET['codigo'];
			require_once('poa/registerEjecucionPON.php');
		}
		if ($_GET['opcion']=='deletePOAAct') {
			$codigo=$_GET['codigo'];
			$codigo_indicador=$_GET['codigo_indicador'];
			require_once('poa/saveDelete.php');
		}
		if ($_GET['opcion']=='saveDeleteActxIndicador') {
			$codigo_indicador=$_GET['codigo'];
			$codigo_area=$_GET['area'];
			$codigo_unidad=$_GET['unidad'];
			$codigo_sector=$_GET['sector'];
			require_once('poa/saveDeleteActxIndicador.php');
		}
		if ($_GET['opcion']=='asignarPOA') {
			$codigo=$_GET['codigo'];
			$areaUnidad=$_GET['areaUnidad'];
			require_once('poa/asignarPOA.php');
		}
		if ($_GET['opcion']=='seguimientoPOA') {
			require_once('poa/rptOpSeguimientoPOA.php');
		}
		if ($_GET['opcion']=='seguimientoPOAxArea') {
			require_once('poa/rptOpSeguimientoPOAxArea.php');
		}


		//POAI
		if ($_GET['opcion']=='asignarPOAI') {
			$codigo=$_GET['codigo'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			$sector=$_GET['sector'];
			require_once('poai/asignarPersonalPOAI.php');
		}
		if ($_GET['opcion']=='listPOAI') {
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			$sector=0;
			require_once('poai/listPOAI.php');
		}
		if ($_GET['opcion']=='listActividadesPOAI') {
			$codigo=$_GET['codigo'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			require_once('poai/listActividadesPOAI.php');
		}
		if ($_GET['opcion']=='listActividadesPOAIDetalle') {
			$codigo=$_GET['codigo'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			$actividad=$_GET['actividad'];
			$vista=$_GET['vista'];
			require_once('poai/listActividadesPOAIDetalle.php');
		}
		if ($_GET['opcion']=='registerPOAI') {
			$codigo=$_GET['codigo'];
			$area=$_GET['area'];
			$unidad=$_GET['unidad'];
			$actividad=$_GET['actividad'];
			$vista=$_GET['vista'];
			require_once('poai/registerPOAI.php');
		}
		if ($_GET['opcion']=='registerPOAIPlan') {
			$codigo=$_GET['codigo'];
			require_once('poai/registerPOAIPlan.php');
		}
		if ($_GET['opcion']=='listPOAIEjecucion') {
			require_once('poai/listPOAIEjecucion.php');
		}
		if ($_GET['opcion']=='listActividadesPOAIEjecucion') {
			$codigo=$_GET['codigo'];
			require_once('poai/listActividadesPOAIEjecucion.php');
		}
		if ($_GET['opcion']=='registerPOAIEjecucion') {
			$codigo=$_GET['codigo'];
			require_once('poai/registerPOAIEjecucion.php');
		}


		//REPORTES
		if ($_GET['opcion']=='rptObjConf') {
			require_once('reportes/rptObjConf.php');
		}
		if ($_GET['opcion']=='rptOpEjecucionPOA') {
			require_once('reportes/rptOpEjecucionPOA.php');
		}
		if ($_GET['opcion']=='rptOpEjecucionPOADetalle') {
			require_once('reportes/rptOpEjecucionPOADet.php');
		}
		if ($_GET['opcion']=='rptOpEjecucionPOAIDetalle') {
			require_once('reportes/rptOpEjecucionPOAIDet.php');
		}
		if ($_GET['opcion']=='rptOpPlanificacionPOADetalle') {
			require_once('reportes/rptOpPlanificacionPOADet.php');
		}
		if ($_GET['opcion']=='rptOpPlanificacionPOASector') {
			require_once('reportes/rptOpPlanificacionPOASector.php');
		}
		if ($_GET['opcion']=='rptOpPresupuestoOp') {
			require_once('reportes/rptOpPresupuesto.php');
		}
		if ($_GET['opcion']=='rptOpPresupuestoOpResumen') {
			require_once('reportes/rptOpPresupuestoResumen.php');
		}
		if ($_GET['opcion']=='rptOpPresupuestoSIS') {
			require_once('reportes/rptOpPresupuestoSIS.php');
		}
		if ($_GET['opcion']=='rptOpCursos') {
			require_once('reportes/rptOpCursos.php');
		}
		if ($_GET['opcion']=='rptOpServicios') {
			require_once('reportes/rptOpServicios.php');
		}
		if ($_GET['opcion']=='rptOpPlanAudi') {
			require_once('reportes/rptOpPlanAudi.php');
		}
		if ($_GET['opcion']=='rptActividadesHitos') {
			require_once('reportes/rptOpActividadesHitos.php');
		}
		if ($_GET['opcion']=='rptUserConnected') {
			require_once('reportes/rptUserConnected.php');
		}

		
		//COMPONENTES SIS

		if ($_GET['opcion']=='principal_actividades') {
			$codigo_proy=$_GET['codigo_proy'];
			require_once('componentesSIS/principal_actividades.php');
		}
		if ($_GET['opcion']=='listComponentesSIS') {
			require_once('componentesSIS/list.php');
		}
		if ($_GET['opcion']=='registerComponenteSIS') {
			
			require_once('componentesSIS/register.php');
		}
		if ($_GET['opcion']=='editComponenteSIS') {
			$codigo=$_GET['codigo'];
			require_once('componentesSIS/edit.php');
		}
		if ($_GET['opcion']=='deleteComponenteSIS') {
			$codigo=$_GET['codigo'];
			require_once('componentesSIS/saveDelete.php');
		}

		if ($_GET['opcion']=='listExternalCostsSIS') {
			require_once('externalCostsSIS/list.php');
		}
		if ($_GET['opcion']=='registerExternalCostsSIS') {
			require_once('externalCostsSIS/register.php');
		}
		if ($_GET['opcion']=='editExternalCostsSIS') {
			$codigo=$_GET['codigo'];
			require_once('externalCostsSIS/edit.php');
		}
		if ($_GET['opcion']=='deleteExternalCostsSIS') {
			$codigo=$_GET['codigo'];
			require_once('externalCostsSIS/saveDelete.php');
		}

		//SOLICITUD FONDOS SIS
		if ($_GET['opcion']=='listSolicitudFondosSIS') {
			require_once('solicitudFondosSIS/list.php');
		}
		if ($_GET['opcion']=='registerSolicitudFondoSIS') {
			require_once('solicitudFondosSIS/register.php');
		}
		if ($_GET['opcion']=='editSolicitudSIS') {
			$codigo=$_GET['codigo'];
			require_once('solicitudFondosSIS/edit.php');
		}
		if ($_GET['opcion']=='deleteSolicitudSIS') {
			$codigo=$_GET['codigo'];
			require_once('solicitudFondosSIS/saveDelete.php');
		}
		if ($_GET['opcion']=='cargarPresupuestoSIS') {
			require_once('solicitudFondosSIS/cargarPresupuesto.php');
		}
		if ($_GET['opcion']=='seguimientoAnualSIS') {
			require_once('solicitudFondosSIS/seguimientoAnualSIS.php');
		}	
		if ($_GET['opcion']=='seguimientoAnualSIS2') {
			require_once('solicitudFondosSIS/seguimientoAnualSIS2.php');
		}	
		if ($_GET['opcion']=='rptOpDetalleGastosSIS') {
			require_once('solicitudFondosSIS/rptOpDetalleGastosSIS.php');
		}
		if ($_GET['opcion']=='rptOpRelacionarGastos') {
			require_once('solicitudFondosSIS/rptOpRelacionarGastos.php');
		}	
		if ($_GET['opcion']=='rptOpRelacionGastosAcc') {
			require_once('solicitudFondosSIS/rptOpRelacionGastosAcc.php');
		}	
		if ($_GET['opcion']=='rptOpBalanceCuentasSIS') {
			require_once('solicitudFondosSIS/rptOpBalanceCuentasSIS.php');
		}	
		if ($_GET['opcion']=='resumenGeneralSIS') {
			require_once('solicitudFondosSIS/resumenSIS.php');
		}	
		

		
	}else{
		require_once('graficos/charts.php');
	}

 ?>