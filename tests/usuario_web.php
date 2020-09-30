<?php

    $sIdentificador = "monitoreo";
	$sKey="837b8d9aa8bb73d773f5ef3d160c9b17";
	$nombreuser='juan.quenallata@ibnorca.org';
	$claveuser=md5('juanito2020');
	$datos=array("sIdentificador"=>$sIdentificador, "sKey"=>$sKey, 
		"operacion"=>"Login", "nombreUser"=>$nombreuser, "claveUser"=>$claveuser);
	$datos=json_encode($datos);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/verifica/ws-user-personal.php");
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$remote_server_output = curl_exec ($ch);
	curl_close ($ch);
	header('Content-type: application/json'); 	
    print_r($remote_server_output); 
