

<?php
function listarComponentes(){
    require_once '../conexion.php';

    $dbh = new Conexion();
    // Preparamos
    $stmt = $dbh->prepare("SELECT codigo,nombre,abreviatura from componentessis where cod_estado=1;");
    // Ejecutamos
    // $stmt->execute();
    // // bindColumn
    // $stmt->bindColumn('codigo', $codigo);
    // $stmt->bindColumn('nombre', $nombre);
    // $stmt->bindColumn('abreviatura', $abreviatura);
    // $stmt->bindColumn('nivel', $nivel);
    // $stmt->bindColumn('cod_padre', $cod_padre);
    // $stmt->bindColumn('partida', $partida);
    // $stmt->bindColumn('personal', $personal);
    // $stmt->bindColumn('gestion', $gestion);
    // $objComponentes=new stdClass();
    $resp = false;
    $filas = array();
    if($stmt->execute()){
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resp = true;
    }
    else{
        echo "Error: Listar Estados o Departamentos";
        $resp=false;
        exit;       
    }
    return $filas;

}


/*
 SERVICIO WEB PARA OPERACIONES DE LISTA DE PERSONAL  */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Decodificando formato Json
    $datos = json_decode(file_get_contents("php://input"), true);
    //print_r($datos);
    // require ('../clases/Sistema.php'); 
    // $sis=new Sistema();
    // //***Recuperar parametros de login*******/
    // $sisIdentificador = $datos['sIdentificador'];   // Identificador de sesion del sistema
    // $sisKey = $datos['sKey'];           // clave para la sesion
    // $verifSis=$sis->keySistema($sisIdentificador, $sisKey);
    
    //Parametros de consulta
    $accion=NULL;
    if(isset($datos['accion']))
        $accion=$datos['accion']; 
    
    // if($verifSis['estado']== true){
    //     include ('../clases/Clasificador.php');
    //     include ('../clases/Cliente.php');
    //     $cla = new Clasificador();
        
        
        $estado=false;
        $mensaje="";
        $total=0;
        $lista=array();
        


    // //echo 'aqui';
            
        if($accion=="ListarPersonal"){
                                
            try{
                //$lstPersonal = $personal->listarClientexAtributoWS($tipo, $atributo); // por atributo
                $lstPersonal = listarComponentes();
                $totalPersonal=count($lstPersonal);
                $resultado=array(
                            "estado"=>true,
                            "mensaje"=>"Lista de Personal obtenida correctamente", 
                            "lstPersonal"=>$lstPersonal, 
                            "totalPersonal"=>$totalPersonal
                            
                            );
            }catch(Exception $e){
                $estado=true;
                $mensaje = "No se pudo obtener la lista de personal".$e;
                $resultado=array("estado"=>$estado, 
                            "mensaje"=>$mensaje, 
                            "lstPersonal"=>array(),
                            "totalPersonal"=>0);
            }
            
            
        }else{
            $resultado=array("estado"=>false, 
                            "mensaje"=>"Error: Operacion incorrecta!");
        }
            header('Content-type: application/json');
            echo json_encode($resultado);
    // }else{
    //         $resp=array("estado"=>false, 
    //                     "mensaje"=>"Error en las credenciales");
    //         header('Content-type: application/json');
    //         echo json_encode($resp);
    // }
}else{
    $resp=array("estado"=>false, 
                "mensaje"=>"No tiene acceso al WS");
    header('Content-type: application/json');
    echo json_encode($resp);
}

?>
