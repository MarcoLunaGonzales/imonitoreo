<?php
	//parametros de acceso al WS
	$sIdentificador = "monitoreo";
	$sKey="837b8d9aa8bb73d773f5ef3d160c9b17";
	
	/******************************************
	*   parametros Login de usuario           *
	******************************************/
	/*Administrador*/
/*		$nombreuser="luis.rojas@prueba.com";
		$claveuser="789";
		*/

/*	$nombreuser="luis.rojas@ibnorca.org";
	$claveuser=md5("rojas");	

*/	
/*	$nombreuser="luis.rojas@ibnorca.org";
	$claveuser=md5("rojas");	*/

//Usuario operativo
		$nombreuser="andrea.sandi@ibnorca.org";
		$claveuser=md5("sandi");
	//*/
	//preparar array de parametros	
	/* descomentar	*/

	$datos=array("sIdentificador"=>$sIdentificador, "sKey"=>$sKey, 
				 "operacion"=>"Login", "nombreUser"=>$nombreuser, "claveUser"=>$claveuser);
	
			 
	/******************************************
	*   parametros obtener de Menu de usuario *
	******************************************/
	// descomentar 

/*	$datos=array("sIdentificador"=>$sIdentificador, "sKey"=>$sKey, 
				 "operacion"=>"Menu", "IdUsuario"=>183);
*/
	
	$datos=json_encode($datos);
	
	//METODO CURL PARA ACCESO AL WEB SERVICE Y ENVIO DE PARAMETROS POR POST
	// abrimos la sesión cURL
	$ch = curl_init();
	// definimos la URL a la que hacemos la petición
	curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/verifica/ws-user-personal.php");
	//curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno19/verifica/ws-user-personal.php");
	// indicamos el tipo de petición: POST
	curl_setopt($ch, CURLOPT_POST, TRUE);
	// definimos cada uno de los parámetros
	curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
	// recibimos la respuesta y la guardamos en una variable
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$remote_server_output = curl_exec ($ch);
	// cerramos la sesión cURL
	curl_close ($ch);
	 
	//RECUPERACION DE RESPUESTA DEL WEB SERVICE
	header('Content-type: application/json'); 	
	print_r($remote_server_output); 			
	

?>