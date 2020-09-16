<?php 
//SERVICIO WEB PARA ENVIAR LOS DATOS DE PRESUPUESTO Y EJECUCION DE UNA CUENTA
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// recoveri variable
	$datos = json_decode(file_get_contents("php://input"), true);
	$estado=false;
	$mensaje="";

	$sIdeS = "monitoreo"; 
	$sKeyS="101010"; 


	require ('../conexion.php');
	require ('../functionsPOSIS.php');
	require ('../functions.php');

	$sisIdentificador=$sisKey=NULL;
	if(isset($datos['sIdentificador'])){
		$sisIdentificador = $datos['sIdentificador']; 	// Identificador de sesion del sistema			
		$sisKey = $datos['sKey']; 	// Identificador de sesion del sistema			
		$oficinaX=$datos['oficina'];
		$areaX=$datos['area'];
		$anioX=$datos['anio'];
		$mesX=$datos['mes'];
		$cuentaX=$datos['cuenta'];
		
		$acumuladoX=0;
		if(isset($datos['acumulado'])){
			$acumuladoX=$datos['acumulado'];
		}

		$fondos=obtenerFondosReport($oficinaX);
		$organismos=obtenerOrganismosReport($areaX);


		$presupuestoGastos=presupuestoEgresosMes($fondos, $anioX, $mesX, $organismos, $acumuladoX, $cuentaX);
		$ejecutadoGastos=ejecutadoEgresosMes($fondos, $anioX, $mesX, $organismos, $acumuladoX, $cuentaX);
		$resultado=array("estado"=>true, "mensaje"=>"Datos", "presupuesto"=>$presupuestoGastos ,"ejecutado"=>$ejecutadoGastos);
	}else{
		$resultado=array("estado"=>false, 
					 	"mensaje"=>"Error 1", 
					 	);
	}
}else{
	$resultado=array("estado"=>false, "mensaje"=>"Error 2");
}
header('Content-type: application/json');
	echo json_encode($resultado);
?>