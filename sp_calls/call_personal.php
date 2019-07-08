<?php 
/*REGISTRO DE CLIENTES*/
//LLAVES DE ACCESO AL WS
$sIde = "monitoreo"; 
$sKey="837b8d9aa8bb73d773f5ef3d160c9b17";

		/*listar usuarios */
		$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
						  "accion"=>"ListarPersonal"
						  );
		

		$datos=json_encode($parametros);
		// abrimos la sesión cURL
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/lista/ws-lst-personal.php"); // on line
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);
		
		// imprimir en formato JSON
		header('Content-type: application/json'); 	
		print_r($remote_server_output); 			

?>