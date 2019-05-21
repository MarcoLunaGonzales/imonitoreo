<?php

$server="192.168.10.19";
$database="ibnorca2018";
$user="consultadb";
$password="consultaibno1$";
$conexión = odbc_connect("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);
if (!$conexión) { 
  exit( "Error al conectar: " . $conexión);
}else{
  $sql = "SELECT codigo, sucursal from factura";
  echo $sql;
  $rs = odbc_exec( $conexión, $sql );
  if ( !$rs ) { 
  exit( "Error en la consulta SQL" ); 
  }
  while(odbc_fetch_row($rs)){ 
    echo "entro";
    $resultado=odbc_result($rs,"codigo");
    echo $resultado; 
  }
}

odbc_close($conexión);

?>