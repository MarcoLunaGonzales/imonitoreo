<?php 
/*ACCESO A WEB SERVICE SECTORES Y COMITES*/
//LLAVES DE ACCESO AL WS
$sIde = "monitoreo"; // De acuerdo al sistema
$sKey = "837b8d9aa8bb73d773f5ef3d160c9b17"; // llave de acuerdo al sistema

/*PARAMETROS PARA LA OBTENCION DE DISTINTAS LISTAS DE SECTORES Y COMITES*/
// cambiar esta linea por las demas opciones
//$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "tipoLista"=>"SectorComites"); 	//Lista Todos los sectores y sus comites respectivos
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "tipoLista"=>"Sectores"); 	//Lista Todos los sectores
//$idSector=7; 	//ID del sector
//$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "tipoLista"=>"SectorComites","sector"=>$idSector); //Lista los comites de un sector X 
///$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "tipoLista"=>"Comites"); //Lista Todos los comites

		$parametros=json_encode($parametros);
		// abrimos la sesión cURL
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/catalogo/ws-sector-comite.php");
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);
		
		// imprimir en formato JSON
		header('Content-type: application/json'); 	
		print_r($remote_server_output); 			

?>