<?php 

 require_once('../Connections/conecta.php');
 
$conn = mysqli_connect($hostname_conecta, $username_conecta, $password_conecta);
mysqli_select_db($conn,'dbdocumentos') or die("cannot select DB");
 $idDirectorio= $_REQUEST["idD"]; // id del directorio de tablas
 $idDocumento= $_REQUEST["idR"]; // id del documento en la tabla documentos
$retorno = str_replace(array("|","$"),array("?","&"), $_REQUEST["r"]);  // donde retornar
 $registro = $_REQUEST["idRe"]; // idllave de la tabla principal
//echo $registro;
if ($idDocumento>0)
{
$csql="select path from dbDocumentos.documentos where idDocumento=$idDocumento";
//echo $csql;
$dat=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
$r=mysqli_fetch_array($dat);
$archivo=$r['path'];
$bien=true;
if ($archivo<>'')
 { if (!unlink($archivo))
    {  // error no existe el archivo
       $msg= 'No existe el archivo '.$archivo;
	   $bien=false;
    }
 }	

if ($bien)
{
  $csql="delete from dbDocumentos.documentos where idDocumento=$idDocumento";
  //echo $csql;
  $re=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
  if ($re)	
  {
     $csql="select tabla,campo,condicion from dbdocumentos.directoriotablas where idDirectorio=$idDirectorio";
	 // echo $csql;
	  $dat=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
	  $r=mysqli_fetch_array($dat);
	  $tabla=$r['tabla'];
	  $campo=$r['campo'];
	  $condicion=$r['condicion'];
	  //echo $condicion;
            if ($_SESSION['MM_Bdatos']==1) {  $database_conecta = "ibnorca";}
			if ($_SESSION['MM_Bdatos']==2) {  $database_conecta = "ibnorca_act"; $tabla=str_replace('ibnorca.','ibnorca_act.',$tabla);}
            if ($_SESSION['MM_Bdatos']==3) {  $hostname_conecta = "192.168.10.18";$database_conecta = "ibnorca";  }

	  $csql="update $tabla set $campo=0 where $condicion $registro";
	  //echo $csql;
	  $re=$dat=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
	  if (mysqli_affected_rows($conn)==1)
	  {$msg='Se ha eliminado el Archivo';
	  } else
	  { $msg='Existe un error al emiminar el Archivo';
	  }
  }
 }
} 
else
{$msg='Documento no ha sido cargado';} 
echo "<script language='javascript' type='text/javascript'>
	           					alert('$msg'); location.href= '$retorno';
	  </script>";

?>