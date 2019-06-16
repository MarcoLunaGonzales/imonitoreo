<?php
if (!isset($_SESSION) ) {
  session_start(); }; set_time_limit(5000);?>
  <html>
  <head>
    <title></title>
    <link rel="stylesheet" href="../lib/plugins_modal/bootstrap/dist/css/bootstrap.min.css">
    <script src="../lib/plugins_modal/sweetalert2/sweetalert2.all.js"></script>
    <style>
    body{
      padding-left: 10px;
      padding-right: 20px;
    }
    .cab{
      width: 40%;
      background-color: #3f5765;
      color: #fff;
      padding: 5px;
    }
    th{
      text-align: center;
    }
    .input-per{
      width: 100%;
    }
  </style>
  <LINK rel=stylesheet href="" type=text/css>
  <script language="JavaScript">
    var message="";
    function clickIE() {if (document.all) {(message);return false;}}
    function clickNS(e) {if 
      (document.layers||(document.getElementById&&!document.all)) {
        if (e.which==1||e.which==2||e.which==3) {(message);return false;}}}
        if (document.layers) 
          {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
        else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
        document.oncontextmenu=new Function("return false")

        function disableselect(e){
          return false
        }
        function reEnable(){
          return true
        }
        document.onselectstart=new Function ("return false")
        if (window.sidebar){
// document.onmousedown=disableselect
// document.onclick=reEnable
}
</script>
<?php

//function sube_archivo ($idusr) {

//MARCO LUNA
//$idusr=$_SESSION['idUsuario'];
$idusr=2;

// Recupera parametros de donde almcenar
if(isset($_GET["aplica"])){//METODO PARA APLICAR CONTROLES EN INGRESO DE DATOS SOLO PARA CERTIFICADOS
  $aplica=$_GET["aplica"];
}else{
  $aplica="";
}
if(isset($_GET["ctrArea"])){//METODO PARA APLICAR CONTROLES EN INGRESO DE DATOS SEGUN AREA
  $ctr_area=$_GET["ctrArea"];
}else{
  $ctr_area="";
}
// Recupera area del usuario que ingresa
if(isset($_GET["idT"])){
  $idTipo=$_GET["idT"];
}else{
  $idTipo="";
}
//echo $ctr_area;

$idDirectorio= $_GET["idD"];
$idRegistro = $_GET["idR"];
if (isset($_GET["r"])) {$retorno = str_replace(array("|","$"),array("?","&"), $_GET["r"]);} else {$retorno ='formulario_subir.php';}
if (isset($_GET["v"])) {$visor = true; if ((ini_set('upload_max_filesize','10M')) and (ini_set('post_max_size','10M'))) { echo 'visor'; }} else {$visor =false;}
if (isset($_GET['o'])) {$objeto= $_GET['o'];} else {$objeto=0;}

//MARCO LUNA MODIFICACIONES ARCHIVO
$hostname_conecta="localhost";
$username_conecta="root";
$password_conecta="";
$database_conecta="ibnorcaexterno";
//require_once('../Connections/conecta.php');

//$retorno=$retorno."?idD=".$idDirectorio."&idR=".$idRegistro."&o=".$objeto;
//echo $retorno;
$conn = mysqli_connect($hostname_conecta, $username_conecta, $password_conecta,$database_conecta,3307);
mysqli_select_db($conn,$database_conecta) or die("cannot select DB");
mysqli_set_charset($conn,'utf8');
$rs=mysqli_query($conn,"Select tabla,TipoArchivo,condicion,campo from dbdocumentos.directoriotablas where iddirectorio=$idDirectorio") or die('Consulta no válida: ' . mysqli_error($conn));
if ($rs->num_rows == 0) { echo "<script language='javascript' type='text/javascript'>	alert('No se pudo determinar la tabla en el directorio'); location.href= '$retorno';</script>";}
$dt=$rs->fetch_assoc();
$tabla=$dt['tabla'];
$condi=$dt['condicion'];
$campo=$dt['campo'];

?>
</head>

<body background="">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" background="">
    <tr>
      <!-- <td width="20%" align="center" valign="middle" class="noborder"><strong>Carga de Archivos  </strong></td> -->
      <td width="80%" rowspan="2" align="center" valign="middle" class="noborder"> </td>
    </tr>
    <tr>
    </tr>
  </table>
  <br>
  <?php
// verifica que no exista archivo subido
//MARCO LUNA
  //if ($_SESSION['MM_Bdatos']==2){  
  if(4==2){
  $database_conecta = "ibnorcaexterno"; 
  $tabla=str_replace('ibnorca.','ibnorca_act.',$tabla);}
  $csql="select ifnull($campo,0) as iddocumento from $tabla where  $condi $idRegistro";
//echo $csql;
  $dat=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
  $r=mysqli_fetch_array($dat);
//echo 'docu '.$r['iddocumento'];
  if ($r['iddocumento']>0) 
   { echo "<script language='javascript' type='text/javascript'> alert('Ya existe un archivo en la base de datos, no se pude subir otro para este documento'); window.close();location.href= '$retorno';</script>";
}
else
{
	//obtiene el tipo de archivo a recuperar
	$tipoarchivo='';
	//$csql="Select TipoArchivo from dbdocumentos.directorioTablas where idDirectorio=$idDirectorio";
	//$dat=mysqli_query($conn,$csql) or die('Consulta no válida: ' . mysqli_error($conn));
	//if ($r=mysqli_fetch_array($dat)) {
	$tipoarchivo=$dt["TipoArchivo"];
	//}
	// obtiene tipos de docuemtnos
	$csql="select idclasificador, concat(abrev,' - ',Descripcion) as descr  from clasificador where idpadre=161 order by 2";
	
	//echo $csql;
	
	$dat=mysqli_query($conn,$csql) or die(mysqli_error()) ;
	$cc=mysqli_num_rows($dat);
	//echo 'cant....'.$database_conecta.'..'.$cc;
 ?>  
 <div class="row">
  <div class="col-md-5">
    <form name="users" enctype="multipart/form-data" method="post" action="guardar_archivo.php">
      <input type="hidden"  name="idusr" value="<?php echo $idusr;?>" id="idusr"> </input>
      <input type="hidden"  name="idD" value="<?php echo $idDirectorio;?>"id="idD">  </input>
      <input type="hidden"  name="idR" value="<?php echo $idRegistro;?>"id="idR" > </input>
      <input type="hidden"  name="r" value="<?php echo $retorno;?>"id="r" > </input>
      <input type="hidden"  name="v" value="<?php echo $visor;?>"id="v" > </input>
      <input type="hidden"  name="o" value="<?php echo $objeto;?>"id="v" > </input>
      <table style="font-size: 11px;" class="table table-bordered table-condensed">
        <thead>
          <tr>
            <th style="background-color: #efefef;" colspan="2">
             Carga de Archivos 
           </th>
         </tr>
       </thead>
       <tbody>
        <tr>
          <td class="cab">Tipo Archivo:</td>
          <td>
            <select class="input-per" name="Tipodoc">
              <?php
              if($aplica=="certificado"){
                if($ctr_area==0){
                  echo '<option value="172">REG - Registro</option>';                  
                }else{
                  echo '<option value="660">LogoEmp - LogoEmpresa</option>';                  
                }
              }else{
                if($aplica=="reglamento"){
                  while($d=mysqli_fetch_array($dat)) { 
                   $idtipo=$d[0];
                   $DescTipo=$d[1];
                   if($idtipo==1585){
                    echo '<option value='.$idtipo.' selected>'.$DescTipo.'</option>';                    
                   }else{
                    echo '<option value='.$idtipo.'>'.$DescTipo.'</option>';                    
                   }
                 }
                }else{
                  while($d=mysqli_fetch_array($dat)) { 
                   $idtipo=$d[0];
                   $DescTipo=$d[1];
                   echo '<option value='.$idtipo.'>'.$DescTipo.'</option>';
                 }
                }                
             }            
             ?>
           </select>
         </td>  
       </tr>
       <tr>
        <td class="cab">Descripci&oacute;n</td>
        <td>
          <?php  
          if($aplica=="certificado"){
            if($ctr_area==0){
                  echo '<input class="input-per" name="descripcion" value="CERTIFICADO" readonly required/></input>';                
                }else{
                  echo '<input class="input-per" name="descripcion" value="LOGO EMPRESA CERTIFICADA" readonly required/></input>';                
                }            
          }else{
            echo '<input class="input-per" name="descripcion" required/> </input>';
          }
          ?>
        </td>        
      </tr>
      <tr>
        <td class="cab">Nombre/C&oacute;digo archivo</td>
        <td>
          <?php  
          if($aplica=="certificado"){
            $consulta="SELECT s.Codigo FROM servicios s INNER JOIN certificadosservicios cs ON cs.IdServicio=s.IdServicio AND cs.IdCertificadoServicios=".$idRegistro;
            $arrayCodigo=mysqli_query($conn,$consulta);
            $datosCodigo=mysqli_fetch_array($arrayCodigo);
            $codServicio=$datosCodigo['Codigo'];
            echo '<input class="input-per" value="'.$codServicio.'" name="codigo" id="codigo" readonly />';
          }else{
            echo '<input class="input-per" name="codigo" id="codigo" />';
          }
          ?>
        </td>        
      </tr>
      <tr>
        <td class="cab">Observaci&oacute;n</td>
        <td>
          <textarea class="input-per" name="observacion" id="observacion"></textarea>
        </td>        
      </tr>
      <tr>
        <td class="cab">Archivo (Peso Maximo 2M)</td>
        <td>
        	<?php  
        	 if($aplica=="certificado"){
            	if($ctr_area==0){
                  echo '<input type="file" name="archivito" accept="'.$tipoarchivo.'" onchange="return validarNombre(this)">';              
                }else{
                  echo '<input type="file" id="file_i" name="archivito" accept="image/png" ca onchange="return fileValidation()">'; 
                  echo '<div id="imagePreview"></div>';
                }            
	          }else{
	            echo '<input type="file" name="archivito" accept="'.$tipoarchivo.'" onchange="return validarNombre(this)">';
	          }
	          ?>        
        </td>        
      </tr>
      <tr>
        <td colspan="2"><label>Nota: <i>Evite que el nombre del archivo que subira al sistema contenga caracteres especiales como (&ntilde;) (&acute;) (") para no tener problemas al realizar operaciones con el archivo.</i></label></td>
      </tr>
    </tbody>
  </table>
  <div style="text-align: right; padding-right: 15px;" class="row">
    <a href="<?php echo $retorno; ?>"><button type="button" class="btn btn-default btn-sm" >Cancelar</button></a>
    <input class="btn btn-danger btn-sm" type="submit" class='cabecera' value="Guardar">
  </div>
</form>
</div>   
<div class="col-md-7"></div>
</div>

<script src="../lib/plugins_modal/jquery/dist/jquery.min.js"></script>
<script src="../lib/plugins_modal/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php

}

?>

<script>
var _URL = window.URL || window.webkitURL;
function fileValidation(){
    var fileInput = document.getElementById('file_i');
    var filePath = fileInput.value;
    //var allowedExtensions = /(.jpg|.jpeg|.png|.gif)$/i;
    var allowedExtensions = /(.png)$/i;
    if(!allowedExtensions.exec(filePath)){
        swal({
          type: "warning",
          text: "Lo siento, solo puede subir imagenes que soporten transparecia en formato PNG"
        })
        fileInput.value = '';
        document.getElementById('imagePreview').innerHTML = '<img src=""/>';
        return false;
    }else{
      if(validarNombre(fileInput)==0){
        //Image preview
          img = new Image();
          img.src = _URL.createObjectURL(fileInput.files[0]);
          img.onload = function () {
            if(this.width<1200 && this.height<600){
              if (fileInput.files && fileInput.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').innerHTML = '<img src="'+e.target.result+'"/>';
                };
                reader.readAsDataURL(fileInput.files[0]);            
              } 
            }else{
              swal({
                type: "warning",
                text: "Lo siento, no puede subir imagenes con dimenciones mayores a 1200 pixeles de ancho ni mayores a 600 pixeles de alto"
              })
              fileInput.value = '';
              document.getElementById('imagePreview').innerHTML = '<img src=""/>';
              return false;
            }
          };
      }else{
        document.getElementById('imagePreview').innerHTML = '';
      }  
    }
}
function validarNombre(fileInput){
  /*----------  Verificamos caracteres  ----------*/     
        var nombre=(fileInput.files[0].name).split('.')[0];
        //alert(nombre);
        var filtro='abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890_- ()';
        var control=0;

        for (var i=0; i<nombre.length; i++){
          if (filtro.indexOf(nombre.charAt(i)) == -1){
              control=1;
              break;
          }         
        }
        if(control==1 || nombre.length>50){
          control=1;
          swal({
            type: "warning",
            text: "Lo siento, el nombre del archivo no puede tener caracteres especiales ni sobrepasar los 50 caracteres"
          })
          fileInput.value = '';
        }
        return control;
}
</script>