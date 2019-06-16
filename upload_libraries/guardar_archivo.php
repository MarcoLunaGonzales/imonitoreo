<?php 

$hostname_conecta="localhost";
$username_conecta="root";
$password_conecta="";
$database_conecta="ibnorcaexterno";
// 
//require_once('../Connections/conecta.php');
 
$conn = mysqli_connect($hostname_conecta, $username_conecta, $password_conecta, $database_conecta, 3307);
mysqli_select_db($conn,'dbdocumentos') or die("cannot select DB");
 $idDirectorio= $_REQUEST["idD"];
 $idRegistro= $_REQUEST["idR"];
 $idusr= $_REQUEST["idusr"];
 $idtipo = $_REQUEST["Tipodoc"];
 $descripcion = $_REQUEST["descripcion"];
 $codigo = $_REQUEST["codigo"];
 $obs = $_REQUEST["observacion"];
 $retorno = $_REQUEST["r"];
 $archivo = $_FILES["archivito"]["tmp_name"]; 
 $tamanio = $_FILES["archivito"]["size"];
 $tipo    = $_FILES["archivito"]["type"];
 $nombre  = $_FILES["archivito"]["name"];
 $visor = $_REQUEST["v"];
 $fecha =date("Y-m-d H:i");
// echo $archivo;
// echo $tamanio;
// echo $tipo;
// echo $nombre;
//$retorno=$retorno."?idD=".$_REQUEST["idD"]."&idR=".$_REQUEST["idR"]."&o=".$_REQUEST["o"];
if ($visor) {ini_set('upload_max_filesize','2M');ini_set('post_max_size','2M'); } 

if (strlen($nombre)>200)
 {echo "<script language='javascript' type='text/javascript'>
	           					alert('El nombre del archivo es muy largo no se puede guardar. Reduzcalo!!'); location.href= '$retorno';
	          			  </script>";}
 
 if (!is_file($archivo))
 {echo "<script language='javascript' type='text/javascript'>
	           					alert('No se pudo subir el archivo, posiblemente pese mas de 2MB, no se pude guardar.'); location.href= '$retorno';
	          			  </script>";}
 //$respuesta = new stdClass();
 $csql="Select tabla, campo, condicion from dbdocumentos.directorioTablas where idDirectorio=$idDirectorio";
 //echo $csql;
 $dat=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
 if ($r=mysqli_fetch_array($dat))
     {
	 if ($tamanio>0)
	 {
	    $idrdoc=0;
		$tabla=$r["tabla"]; $campo=$r["campo"]; $cond=$r["condicion"];	
//echo 'listo para guardar  1--'.$archivo.' --'.$tamanio.' --'.$tipo.' --'.$nombre;

	        $fp = fopen($archivo, "rb");
    	    $contenido = fread($fp, $tamanio);
        	$contenido = addslashes($contenido);
        	fclose($fp); 
			if ($tamanio<500)
		    {  // el archivo se guarda en la tabla de documentos
        	     $qry = "INSERT INTO dbdocumentos.documentos (idDocumento,idtipo,Descripcion,NombreCodigo,NombreArchivo,Tipo,Tamanio,FechaRegistro,idUsuarioRegistro,Observaciones,contenido) VALUES (0,$idtipo,'$descripcion','$codigo','$nombre','$tipo',$tamanio,'$fecha',$idusr,'$obs','$contenido')";
 //echo $qry;
 		          mysqli_query($conn,$qry) or die('Consulta no válida: ' . mysqli_error($conn));
			}	  
			else
				{  // el archivo es de mas 500k se guardara en una carpeta
				   if (!is_dir('/ibn_archivos'))
				   { echo ' no existe directorio';
				      $a=mkdir('/ibn_archivos');
				   }
				   $ruta='/ibn_archivos/'.$idtipo;
				   if (!is_dir($ruta))
				   { echo ' no existe directorio';
				      $a=mkdir($ruta);
				   }
				   // recupera el iddde documentos para poner al nombre del archivo
				   $csql="select max(idDocumento)+1 as Iddoc from dbdocumentos.documentos";
				   $rsd=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
				   $r=mysqli_fetch_array($rsd);
				   
		           $narchivo = $ruta.'/'.$r['Iddoc'].$idRegistro.$nombre;
			       if (move_uploaded_file ( $archivo , $narchivo )) 
			       { // movio el archivo a su destino
			           $qry = "INSERT INTO dbdocumentos.documentos (idDocumento,idtipo,Descripcion,NombreCodigo,NombreArchivo,Tipo,Tamanio,FechaRegistro,idUsuarioRegistro,Observaciones,path) VALUES  (0,$idtipo,'$descripcion','$codigo','$nombre','$tipo',$tamanio,'$fecha',$idusr,'$obs','$narchivo')";
						//echo $qry."<br>";
						mysqli_query($conn,$qry) or die('Consulta no válida: ' . mysqli_error($conn));
			       }
			       else
			       {  // error al mover el archivo
				      echo "<script language='javascript' type='text/javascript'>
	           					alert('No se ha guardado el archivo intente neuvamente.'); location.href= '$retorno';
	          			  </script>";
			       }
				}   
       		if(mysqli_affected_rows($conn) > 0)
	   		{
        		$qry = "select max(idDocumento) as Iddoc from dbdocumentos.documentos where idtipo=$idtipo and descripcion='$descripcion' and NombreCodigo='$codigo' and nombreArchivo='$nombre' and Tipo='$tipo' and Tamanio=$tamanio and FechaRegistro='$fecha' and idUsuarioregistro=$idusr";
		//echo $qry;
				$dat=mysqli_query($conn,$qry) or die('Consulta no válida: ' . mysqli_error($conn));
        		if ($r=mysqli_fetch_array($dat))
         		{
		   			$idrdoc=$r["Iddoc"];
		            //if ($_SESSION['MM_Bdatos']==1) {  $database_conecta = "ibnorca";}
					//if ($_SESSION['MM_Bdatos']==2) {  $database_conecta = "ibnorca_act"; $tabla=str_replace('ibnorca.','ibnorca_act.',$tabla);}
                    /*if ($_SESSION['MM_Bdatos']==3)
                      {
	                    $hostname_conecta = "192.168.10.18";
                         $database_conecta = "ibnorca";
					  }
					*/
					//MARCO LUNA
					$database_conecta="ibnorca6";
					$conecta = mysqli_connect($hostname_conecta, $username_conecta, $password_conecta,$database_conecta,3307) or trigger_error(mysql_error(),E_USER_ERROR);
		  			$csql="update $tabla set $campo=$idrdoc where $cond".$idRegistro;		   
					//echo $csql;	
		   			mysqli_query($conecta,$csql) or die('Consulta no válida: ' . mysqli_error($conecta));
		   			echo "<script language='javascript' type='text/javascript'>
	           					alert('Se ha guardado el archivo en la base de datos.($database_conecta)'); location.href= '$retorno';window.close();
	          			  </script>";
		 		}
	   		}
	   		else 
			{//echo 'no guardo';
	        	 echo "<script language='javascript' type='text/javascript'>
	         			alert('1 NO se ha podido guardar el archivo en la base de datos. Intente nuevamente'); location.href= '$retorno';window.close();
   	       				</script>";
         	}
	}	 
	else  
	  {
	  echo "<script language='javascript' type='text/javascript'>
	         alert('3 NO se Guardo el archivo esta vacio intente nuevamente'); location.href= '$retorno';
   	       </script>";
      }
  }	
   else {//echo "no EXISTE $idDirectorio en directorio de tablas";
   
   echo "<script language='javascript' type='text/javascript'>
	alert('2 NO se ha podido guardar el archivo en la base de datos.'); location.href= '$retorno';
</script>";
   }

?>