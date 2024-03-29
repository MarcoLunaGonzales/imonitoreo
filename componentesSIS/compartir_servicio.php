<?php
function listarComponentes($codigo_proyecto){
    require_once '../conexion.php';
    $dbh = new Conexion();
    // Preparamos
    $stmt = $dbh->prepare("SELECT codigo,nombre,abreviatura from componentessis where cod_estado=1 and cod_proyecto=$codigo_proyecto and cod_gestion in (select max(cod_gestion) from componentessis where cod_proyecto='$codigo_proyecto') limit 0,10");

    $resp = false;
    $filas = array();
    if($stmt->execute()){
        $filas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $resp = true;
    }
    else{
        echo "Error: Listar Componentes";
        $resp=false;
        exit;       
    }
    return $filas;
}
/*
 SERVICIO WEB PARA OPERACIONES Componentes  */
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Decodificando formato Json
    $datos = json_decode(file_get_contents("php://input"), true);    
    //Parametros de consulta
    $accion=NULL;
    if(isset($datos['accion']))
        $accion=$datos['accion']; //recibimos la accion
        $codigo_proyecto=$datos['codigo_proyecto'];//recibimos el codigo del proyecto
        $estado=false;
        $mensaje="";
        $total=0;
        $lista=array();
        if($accion=="ListarComponentes"){
            try{                
                $lstComponentes = listarComponentes($codigo_proyecto);//llamamos a la funcion 
                $totalComponentes=count($lstComponentes);
                $resultado=array(
                            "estado"=>true,
                            "mensaje"=>"Lista de Componentes obtenida correctamente", 
                            "lstComponentes"=>$lstComponentes, 
                            "totalComponentes"=>$totalComponentes
                            );
            }catch(Exception $e){
                $estado=true;
                $mensaje = "No se pudo obtener la lista de Componentes".$e;
                $resultado=array("estado"=>$estado, 
                            "mensaje"=>$mensaje, 
                            "lstComponentes"=>array(),
                            "totalComponentes"=>0);
            }
            
            
        }else{
            $resultado=array("estado"=>false, 
                            "mensaje"=>"Error: Operacion incorrecta!");
        }
            header('Content-type: application/json');
            echo json_encode($resultado);
}else{
    $resp=array("estado"=>false, 
                "mensaje"=>"No tiene acceso al WS");
    header('Content-type: application/json');
    echo json_encode($resp);
}

?>
