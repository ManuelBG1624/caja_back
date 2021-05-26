<?php 
require_once('../model/permisosVue.php');
require_once('../model/cajero.php');
$objcajero=new Cajero();
date_default_timezone_set('America/Lima');
//date_default_timezone_set('UTC-5');
$opcion=isset($_POST['opcion']) ? $_POST['opcion'] : '';
$operador=isset($_POST['operador']) ? $_POST['operador'] : '';
$clave=isset($_POST['clave']) ? $_POST['clave'] : '';
$id=isset($_POST['id']) ? $_POST['id'] : '';
$hora=isset($_POST['hora']) ? $_POST['hora'] : '';
$nmrocaja=isset($_POST['nmrocaja']) ? $_POST['nmrocaja'] : '';
$mediopago=isset($_POST['mediopago']) ? $_POST['mediopago'] : '';
$fechari=isset($_POST['fechari']) ? $_POST['fechari'] : '';
$fechaf=isset($_POST['fechaf']) ? $_POST['fechaf'] : '';
$idapertura=isset($_POST['idapertura']) ? $_POST['idapertura'] : '';
$numrecibo=isset($_POST['numrecibo']) ? $_POST['numrecibo'] : '';
$observacion=isset($_POST['observacion']) ? $_POST['observacion'] : '';
$estado=isset($_POST['estado']) ? $_POST['estado'] : '';
$tipoingreso=isset($_POST['tipoingreso']) ? $_POST['tipoingreso'] : '';
$cantope=isset($_POST['cantope']) ? $_POST['cantope'] : '';
$cantextor=isset($_POST['cantextor']) ? $_POST['cantextor'] : '';
$cantcance=isset($_POST['cantcance']) ? $_POST['cantcance'] : '';
$totalextorno=isset($_POST['totalextorno']) ? $_POST['totalextorno'] : '';
$totalcancelado=isset($_POST['totalcancelado']) ? $_POST['totalcancelado'] : '';
$idcta=isset($_POST['idcta']) ? $_POST['idcta'] : '';
$fechaActual = date('Y-m-d');
$arrayValidarCa=array();
$arrayValidarape=array();
$arraydatos=array();


if($opcion=='validar'){
    $objcajero->setclave($clave);
    $objcajero->setoperador($operador);
    $arrayValidarCa=$objcajero->ValidarCajero();
    if(count($arrayValidarCa)>0){
        $arrayValidarape=$objcajero->validarAperturaCaja($fechaActual,$objcajero->getid());
        //echo var_dump($arrayValidarCa["nidusuario"]);
        if(count($arrayValidarape)>0){
            $arraydatos=$objcajero->DatosApertura($fechaActual);
            print json_encode($arraydatos);
        }else{
            print json_encode($arrayValidarCa);
        }
    }
    

    
}
if($opcion=='aperturarCaja'){
    $objcajero->setoperador($operador);
    $objcajero->setid($id);
    print json_encode($objcajero->AperturarCaja($fechaActual, $hora));
}
if($opcion=='listarmediopago'){
    print json_encode($objcajero->medioPago());
}
if($opcion=='listartipotarjeta'){
    print json_encode($objcajero->tipoTarjeta());
}
if($opcion=='listarcajero'){
    $objcajero->setnrocaja($nmrocaja);
    print json_encode($objcajero->listarCajero($fechari,$fechaf,$mediopago,$estado));
}
if($opcion=='listarIngresos'){
    print json_encode($objcajero->listarIngresos($idapertura,$tipoingreso));
}
if($opcion=='extornarcuenta'){
    $idcta2=array();
    $idcta2=explode("-", substr($idcta, 0, -1));
    for ($i = 0; $i < count($idcta2); $i++) {
    $objcajero->extornarCuentacte($idcta2[$i]);
    }
    print json_encode($objcajero->extornarcuenta($idapertura,$numrecibo,$observacion));
}
if($opcion=='validarUsuarioExtorno'){
    $objcajero->setclave($clave);
    $objcajero->setoperador($operador);
    print json_encode($objcajero->ValidarCajero());
}
if($opcion=='cerrar_caja'){
    $idcaja=array();
    $objcajero->cerrarCaja($idapertura,$cantope,$cantextor,$cantcance,$totalextorno,$totalcancelado);
    $objcajero->cabecera_caja_back($idapertura);
    $idcaja=$objcajero->buscaridcaja_back($idapertura);
    foreach($idcaja as $i) { 
        print json_encode($objcajero->InsertarDetalleback($i['idcaja']));
    }
}
if($opcion=='listarTupa'){
    print json_encode($objcajero->listarTupa($id));

}
if($opcion=='listarTributo'){
    print json_encode($objcajero->listarTributo($id));

}
if($opcion=='verDeatalle'){
    print json_encode($objcajero->verdetalle($idapertura));
}
if($opcion=='IngresosDia'){
    print json_encode($objcajero->IngresosDia($fechari,$fechaf));
}