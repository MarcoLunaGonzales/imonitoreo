<?php
 /* Script descargar_archivo.php */

 require_once('../Connections/conecta.php');
$conn = mysqli_connect($hostname_conecta, $username_conecta, $password_conecta);
mysqli_select_db($conn,'dbdocumentos') or die("cannot select DB");
 $idRegistro= $_REQUEST["idR"];
 if ($idRegistro > 0) {
     $qry = "SELECT tipo, contenido,path,nombrearchivo FROM documentos WHERE iddocumento=$idRegistro";
     //echo $qry;
	 $res = mysqli_query($conn,$qry) or die('Consulta no válida: ' . mysqli_error($conn));
	 $rs=mysqli_fetch_array($res);
     $tipo = $rs['tipo'];
     $contenido = $rs["contenido"];
     $nombre=str_replace(' ','_',$rs["nombrearchivo"]);
	 $lugar=$rs["path"];
	 
	 if (is_file($lugar))
       {
         header('Content-Type: application/force-download');
         header('Content-Disposition: attachment; filename='.$nombre);
         header('Content-Transfer-Encoding: binary');
         header('Content-Length: '.filesize($lugar));

        readfile($lugar);
      }
      else
	  {
       	 header('Content-Disposition: attachment; filename='.$nombre);
         header("Content-type: $tipo");
          print $contenido; 
       }  
	   mysqli_query($conn,"insert into descargas (idDocumento,idUsuario,fecha) values ($idRegistro,".$_SESSION['idUsuario'].",now())");
	}   
   else
   {echo "<script language='javascript' type='text/javascript'>
	alert('El archivo que intenta descargas no esta en la base de datos');
	</script>";}
?>