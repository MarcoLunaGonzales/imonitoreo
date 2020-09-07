<?php

set_time_limit(0);
require_once '../layouts/bodylogin2.php';
require_once '../conexion.php';
require_once '../functions.php';
require_once '../styles.php';

$dbh = new Conexion();


?>


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header <?=$colorCard;?> card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">Sincronizacion de Datos Contabilidad</h4>
          </div>
          <div class="card-body">
                  
<?php

echo "<h6>Hora Inicio Proceso: " . date("Y-m-d H:i:s")."</h6>";


  $dsn = "conta"; 
  $usuario = "consultadb";
  $clave="consultaibno1$";
  $conexión=odbc_connect($dsn, $usuario, $clave);

$arrayGestiones = array(2018,2019,2020);
$longArray = count($arrayGestiones);

if (!$conexión) { 
  exit( "Error al conectar: " . $conexión);
}else{


    $sqlDelete = "DELETE from po_mayores where anio='2020'";
    $stmtDelete = $dbh->prepare($sqlDelete);
    $flagSuccess=$stmtDelete->execute();
     
    //maximo codigo tabla po_mayores
    $flagSuccess=TRUE;
    $sqlInserta="";

    $sqlMaxCod = 'SELECT IFNULL(max(indice),0)maximo from po_mayores';
    $stmtMaxCod = $dbh->prepare($sqlMaxCod);
    $stmtMaxCod->execute();
    while ($rowMaxCod = $stmtMaxCod->fetch(PDO::FETCH_ASSOC)) {
      $indiceMax=$rowMaxCod['maximo'];
    }

    $txtBDGestion="";

     $txtBDGestion="ibnorca2020";


    // query modificado IBNORCA - INGE (se agrego el nombre de base de datos a la tabla del from ibnorca2019.dbo.vw_MayorContable
    $sql = "SELECT v.fondo, v.ano, v.mes, CONVERT(char(10), v.fecha,126)as fecha, v.cta_n1, v.cta_n2, v.cta_n3, v.cta_n4, v.cuenta, v.partida, v.MontoBs, v.organismo, v.ML_Partida, v.glosa, v.GlosaDeta, v.clase, v.numero from $txtBDGestion.dbo.vw_MayorContable v";
    // end modificado

    $rs = odbc_exec( $conexión, $sql );
    if ( !$rs ) { 
      echo $sql."<br>";
      exit( "Error en la consulta SQL" ); 
    }
    $indiceCodigo=$indiceMax+1;

    $insert_str="";

    while(odbc_fetch_row($rs)){ 

      $fondo=odbc_result($rs,"fondo");
      $anio=odbc_result($rs,"ano");
      $mes=odbc_result($rs,"mes");
      $fecha=odbc_result($rs,"fecha");
      $cta1=odbc_result($rs,"cta_n1");
      $cta2=odbc_result($rs,"cta_n2");
      $cta3=odbc_result($rs,"cta_n3");
      $cta4=odbc_result($rs,"cta_n4");
      $cuenta=odbc_result($rs,"cuenta");
      $partida=odbc_result($rs,"partida");
      $monto=odbc_result($rs,"MontoBs");
      $organismo=odbc_result($rs,"organismo");
      $mlPartida=odbc_result($rs,"ML_Partida");
      $glosa=odbc_result($rs,"glosa");
      $glosa=clean_string($glosa);

      $glosa=string_sanitize($glosa);
      
      $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
      $reemplazar=array("", "", "", "");
      $glosa=str_ireplace($buscar,$reemplazar,$glosa);
      
      $glosa=addslashes($glosa);
      
      $glosaDetalle=odbc_result($rs,"GlosaDeta");
      $glosaDetalle=clean_string($glosaDetalle);
      $glosaDetalle=str_ireplace($buscar,$reemplazar,$glosaDetalle);
      $glosaDetalle=addslashes($glosaDetalle);

      $glosaDetalle=string_sanitize($glosaDetalle);

      $clase=odbc_result($rs,"clase");
      $numero=odbc_result($rs,"numero");

      
      //echo $fondo." ".$glosa."<br>";

      $insert_str .= "('$indiceCodigo','$fondo','$anio','$mes','$fecha','$cta1','$cta2','$cta3','$cta4','$cuenta','$partida','$monto','$organismo','$mlPartida','$glosa','$glosaDetalle','$clase','$numero'),"; 

      if($indiceCodigo%200==0){
        $insert_str = substr_replace($insert_str, '', -1, 1);
        $sqlInserta="INSERT INTO po_mayores (indice, fondo, anio, mes, fecha, cta_n1, cta_n2, cta_n3, cta_n4, cuenta, partida, monto, organismo, ml_partida, glosa, glosa_detalle, clase, numero) 
          values ".$insert_str.";";
        $stmtInsert=$dbh->prepare($sqlInserta);
        $flagSuccess=$stmtInsert->execute();
        $insert_str="";
      } 
      $indiceCodigo++;

      if($flagSuccess==FALSE){
        echo "*****************ERROR*****************";
        //echo $sqlInserta."<br>";
        break;
      }
      if($indiceCodigo%200==0){
        echo "INSERTANDO.... Tuplas -> $indiceCodigo <br>";
      }

    }
    $insert_str = substr_replace($insert_str, '', -1, 1);
    $sqlInserta="INSERT INTO po_mayores (indice, fondo, anio, mes, fecha, cta_n1, cta_n2, cta_n3, cta_n4, cuenta, partida, monto, organismo, ml_partida, glosa, glosa_detalle, clase, numero) 
          values ".$insert_str.";";
    //echo $sqlInserta;
    $stmtInsert=$dbh->prepare($sqlInserta);
    $stmtInsert->execute();


}//FIN RECORRIDO GESTION
odbc_close($conexión);


echo "<h6>Hora Fin Proceso Mayores: " . date("Y-m-d H:i:s")."</h6>";

?>

          </div>
        </div>
      </div>
    </div>  
  </div>
</div>