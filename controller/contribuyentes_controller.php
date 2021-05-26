<?php
require_once('../model/contribuyentes.php');
require_once('../model/permisosVue.php');
require_once('../model/cajero.php');
$objcajero = new Cajero();
$objcontribuyentes = new contribuyentes();
date_default_timezone_set('America/Lima');
$fechaActual = date('Y-m-d');
$anoa=date('Y');
$opcion = isset($_POST['opcion']) ? $_POST['opcion'] : '';
$valor = isset($_POST['valor']) ? $_POST['valor'] : '';
$caja = isset($_POST['caja']) ? $_POST['caja'] : '';
$pagina = isset($_POST['pagina']) ? $_POST['pagina'] : '';
$idperso = isset($_POST['idperso']) ? $_POST['idperso'] : '';
$idgtributo = isset($_POST['idgtributo']) ? $_POST['idgtributo'] : '';
$situacion = isset($_POST['situacion']) ? $_POST['situacion'] : '';
$anoi = isset($_POST['anoi']) ? $_POST['anoi'] : '';
$anof = isset($_POST['anof']) ? $_POST['anof'] : '';
$codprediocad = isset($_POST['codpredio']) ? $_POST['codpredio'] : '';
$idctac = isset($_POST['idctac']) ? $_POST['idctac'] : '';
$total = isset($_POST['total']) ? $_POST['total'] : '';
$idtributo = isset($_POST['idtributo']) ? $_POST['idtributo'] : '';
$idestcta = isset($_POST['idestcta']) ? $_POST['idestcta'] : '';
$operador = isset($_POST['operador']) ? $_POST['operador'] : '';
$importe = isset($_POST['importe']) ? $_POST['importe'] : '';
$idmediopago = isset($_POST['mediopago']) ? $_POST['mediopago'] : '';
$ano=isset($_POST['ano']) ? $_POST['ano'] : '';
$idrubro=isset($_POST['idrubro']) ? $_POST['idrubro'] : '';
$idtipvalor=isset($_POST['idtipvalor']) ? $_POST['idtipvalor'] : '';
$idarea=isset($_POST['idarea']) ? $_POST['idarea'] : '';
$tipo_tarjeta=isset($_POST['tipo_tarjeta']) ? $_POST['tipo_tarjeta'] : '';
$cheque=isset($_POST['cheque']) ? $_POST['cheque'] : '';
$referencia=isset($_POST['referencia']) ? $_POST['referencia'] : '';
$idcaja=0;
$idapertura=isset($_POST['idapertura']) ? $_POST['idapertura'] : '';
///////////////////////////
$mora=isset($_POST['mora']) ? $_POST['mora'] : '';
$otros=isset($_POST['otros']) ? $_POST['otros'] : '';
$ipm=isset($_POST['ipm']) ? $_POST['ipm'] : '';
$dscto=isset($_POST['dscto']) ? $_POST['dscto'] : '';
$gastos=isset($_POST['gastos']) ? $_POST['gastos'] : '';
$gastos_desc=isset($_POST['gastos_desc']) ? $_POST['gastos_desc'] : '';
$moras_desc=isset($_POST['moras_desc']) ? $_POST['moras_desc'] : '';
$ipm_desc=isset($_POST['ipm_desc']) ? $_POST['ipm_desc'] : '';
$otros_desc=isset($_POST['otros_desc']) ? $_POST['otros_desc'] : '';
$anexo=isset($_POST['anexo']) ? $_POST['anexo'] : '';
//var_dump($codpredio);
$listadopredios = array();
if ($opcion == 'buscar') {
    $objcontribuyentes->setpagina($pagina);
    //print $objcontribuyentes->getpagina();
    if ($caja == 'codigo') {
        $objcontribuyentes->setpccodperso($valor);
    }
    if ($caja == 'nombre') {
        $objcontribuyentes->setpcnomcontr(strtoupper($valor));
    }
    if ($caja == 'documento') {
        $objcontribuyentes->setpcnrodocu($valor);
    }


    print json_encode($objcontribuyentes->Listado());
}
if ($opcion == 'listadoTributo') {
    print json_encode($objcontribuyentes->listadoTributos());
}
if ($opcion == 'listadoSituacion') {
    print json_encode($objcontribuyentes->listadoSituacion());
}
if ($opcion == 'listadoPredio') {
    print json_encode($objcontribuyentes->listadoPredio($idperso));
}
if ($opcion == 'listadoDeuda') {
    $codpredio = explode("-", substr($codprediocad, 0, -1));
    for ($i = 0; $i < count($codpredio); $i++) {
        $listadopredios[$i][$i] = $objcontribuyentes->listadoDeudasTrib($idperso, $idgtributo, $anoi, $anof, $situacion, $codpredio[$i]);

        //print json_encode($listadopredios[$i]);
    }
    print json_encode($listadopredios);
}
if ($opcion == 'listadoDeuda2') {
    $anexo=substr($anexo, 0, -1);
    print json_encode($objcontribuyentes->listadoDeudasTrib2($idperso, $idgtributo, $anoi, $anof, $situacion,$anexo));
}
if($opcion=='listadoestadocuenta'){
    print json_encode($objcontribuyentes->listadoEstadoCuenta($idperso, $idgtributo, $anoi, $anof, $situacion));
}
if ($opcion == 'persona') {
    print json_encode($objcontribuyentes->Persona($idperso));
}
if ($opcion == 'procesarvoucher') {
    $resultado=0;
    $importe2 = array();
    $importe2 = explode("-", substr($importe, 0, -1));
    $idctac2 = array();
    $idctac2 = explode("-", substr($idctac, 0, -1));
    $idtributo2 = array();
    $idtributo2 = explode("-", substr($idtributo, 0, -1));
    $situacion2 = array();
    $situacion2 = explode("-", substr($situacion, 0, -1));
    $idestcta2 = explode("-", substr($idestcta, 0, -1));
    $respuesta = array();
    //////////////////////////////////////////
    $mora2=array();
    $mora2=explode("-", substr($mora, 0, -1));
    $otros2=array();
    $otros2=explode("-", substr($otros, 0, -1));
    $ipm2=array();
    $ipm2=explode("-", substr($ipm, 0, -1));
    $dscto2=array();
    $dscto2=explode("-", substr($dscto, 0, -1));
    $gastos2=array();
    $gastos2=explode("-", substr($gastos, 0, -1));
    $gastos_desc2=array();
    $gastos_desc2=explode("-", substr($gastos_desc, 0, -1));
    $moras_desc2=array();
    $moras_desc2=explode("-", substr($moras_desc, 0, -1));
    $ipm_desc2=array();
    $ipm_desc2=explode("-", substr($ipm_desc, 0, -1));
    $otros_desc2=array();
    $otros_desc2=explode("-", substr($otros_desc, 0, -1));
    $objcajero->buscarCajero($fechaActual, $operador);
    $idcaja = $objcontribuyentes->procesarPagoCabeceraCaja( $objcajero->getid(), $idperso, $total, $idmediopago, $operador,$tipo_tarjeta,$cheque);
    //$resultado=$objcontribuyentes->buscarCabeceraCaja($idperso,$fechaActual);
    for ($i = 0; $i < count($idctac2); $i++) {

        //$respuesta = $objcontribuyentes->procesarPago($idctac2[$i], $idperso, $idtributo2[$i], $situacion2[$i], $situacion2[$i], $fechaActual, $operador);
        //$objcontribuyentes->modificarEstadoCuenta($idctac2[$i],$fechaActual);
        //$respuesta2 = $objcontribuyentes->procesarPagoDetalleCaja($idcaja,$idtributo2[$i], $idctac2[$i], $importe2[$i], $situacion2[$i]);
        $respuesta2 = $objcontribuyentes->procesarPagoDetalleCaja($idapertura,$idperso,$idcaja,$idtributo2[$i], $idctac2[$i], $importe2[$i], $situacion2[$i],$mora2[$i],$otros2[$i],$ipm2[$i],$dscto2[$i],$gastos2[$i],$gastos_desc2[$i],$moras_desc2[$i],$ipm_desc2[$i],$otros_desc2[$i],$operador);
    }
    
        
    
    print json_encode($idcaja);
}
if($opcion=='listarrubro'){
    print json_encode($objcontribuyentes->listarRubro($anoa));
}
if($opcion=='insertar_rubro_detalle'){
    $idrubro2=array();
    $idrubro2=explode("-",substr($idrubro,0,-1));
    $importe2=array();
    $importe2=explode("-",substr($importe,0,-1));
    $idtipvalor2=array();
    $idtipvalor2=explode("-",substr($idtipvalor,0,-1));
    $idarea2=array();
    $idarea2=explode("-",substr($idarea,0,-1));
    $respuesta=array();
    $objcajero->buscarCajero($fechaActual, $operador);
    $idcaja = $objcontribuyentes->insertarRubroCebecera( $objcajero->getid(), $idperso, $total, $idmediopago, $operador,$tipo_tarjeta,$cheque,$referencia);
    for($i=0; $i<count($idrubro2); $i++){
        $respuesta=$objcontribuyentes->insertarRubroDetalle($idapertura,$operador,$idapertura,$idcaja,$idrubro2[$i],$importe2[$i],$idtipvalor2[$i],$idarea2[$i]);
    }
    print json_encode($idcaja);
}

   
    
  
