<?php

$server="localhost";
$database="CAR2_KARMA";
$user="sa";
$password="minka@2018";
$conexión = odbc_connect("Driver={SQL Server Native Client 10.0};Server=$server;Database=$database;", $user, $password);
if (!$conexión) { 
  exit( "Error al conectar: " . $conexión);
}else{
  $sql = "SELECT * FROM AREAS_EMPRESA";
  echo $sql;
  $rs = odbc_exec( $conexión, $sql );
  if ( !$rs ) { 
  exit( "Error en la consulta SQL" ); 
  }
  while(odbc_fetch_row($rs)){ 
    echo "entro";
    $resultado=odbc_result($rs,"NOMBRE_AREA_EMPRESA");
    echo $resultado; 
  }
}

odbc_close($conexión);

?>