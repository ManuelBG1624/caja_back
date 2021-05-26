<?php
require_once('../database/conexion.php');
class contribuyentes
{
    private $pccodperso, $pcnomcontr, $pcnrodocu, $pcontrib, $pagina;

    function getpccodperso()
    {
        return $this->pccodperso;
    }
    function setpccodperso($pccodperso)
    {
        $this->pccodperso = $pccodperso;
    }
    function getpcnomcontr()
    {
        return $this->pcnomcontr;
    }
    function setpcnomcontr($pcnomcontr)
    {
        $this->pcnomcontr = $pcnomcontr;
    }
    function getpcnrodocu()
    {
        return $this->pcnrodocu;
    }
    function setpcnrodocu($pcnrodocu)
    {
        $this->pcnrodocu = $pcnrodocu;
    }
    function getpcontrib()
    {
        return $this->pcontrib;
    }
    function setpcontrib($pcontrib)
    {
        $this->pcontrib = $pcontrib;
    }
    function getpagina()
    {
        return $this->pagina;
    }
    function setpagina($pagina)
    {
        $this->pagina = $pagina;
    }
    function Listado()
    {
        $conexion = conectarBD();
        $sql = "select * from rentas.fn_list_page_personas('" . $this->getpccodperso() . "', '" . $this->getpcnomcontr() . "', '" . $this->getpcnrodocu() . "', '" . $this->getpcontrib() . "', '" . $this->getpagina() . "', 10)";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listadoTributos()
    {
        $conexion = conectarBD();
        $sql = "select * from rentas.grupo_tributos order by idgrutributo asc";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listadoSituacion()
    {
        $conexion = conectarBD();
        $sql = "select * from rentas.situacion_cuenta where cmarca='C' order by idsitcta asc";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listadoPredio($idperso)
    {
        $conexion = conectarBD();
        $sql = "select * from RENTAS.fn_lista_predios_contribuyente('" . $idperso . "')";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listadoDeudasTrib($idperso, $idgtributo, $anoi, $anof, $situacion, $predio)
    {
        $conexion = conectarBD();
        $sql = "select * FROM rentas.fn_lista_deuda_tributaria_contribuyente(" . $idperso . ", " . $idgtributo . ", '" . $anoi . "', '" . $anof . "', '" . $situacion . "', '" . $predio . "')";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listadoDeudasTrib2($idperso, $idgtributo, $anoi, $anof, $situacion,$anexo)
    {
        $conexion = conectarBD();
        $sql = "select * FROM caja.fn_list_cuenta_corriente('" . $idperso . "', '" . $anoi . "', '" . $anof . "', '" . $idgtributo . "', '" . $situacion . "', '".$anexo."')";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listadoEstadoCuenta($idperso, $idgtributo, $anoi, $anof, $situacion)
    {
        $conexion = conectarBD();
        $sql = "select * FROM caja.fn_list_estado_cuenta_corriente('" . $idperso . "', '" . $anoi . "', '" . $anof . "', '" . $idgtributo . "', '" . $situacion . "', 0)";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function Persona($idperso)
    {
        $conexion = conectarBD();
        $sql = "select maepersona.ccodperso,maepersona.cnrodocu, maepersona.capepater,maepersona.capemater,maepersona.cnombres, maepersona.nidperso, maedistrito.cdesdist,maedireccion.cdesdire  
        from rentas.maepersona, rentas.maedireccion,rentas.maedistrito where maepersona.ncoddire=maedireccion.ncoddire and maedireccion.ncodubig=maedistrito.ncodubig
        and maepersona.nidperso='" . $idperso . "'";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function procesarPago($idctac, $idperso, $idtributo, $situacion, $idestcta, $fechaActual, $operador)
    {
        $conexion = conectarBD();
        $sql = "insert into rentas.maepagos(idctac,nidperso,idtributo,idsitcta,idestcta,dtfecpago,noperador)values(" . $idctac . ",'" . $idperso . "','" . $idtributo . "','" . $situacion . "','" . $idestcta . "','" . $fechaActual . "','" . $operador . "')";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        if ($respuesta > 0) {
            $array[0] = 1;
        }
        $array[0] = 0;

        return $array;
    }
    function procesarPagoDetalleCaja($idapertura,$idperso,$idcaja, $idtributo, $idctac, $importe, $situacion,$mora2,$otros2,$ipm2,$dscto2,$gastos2,$gastos_desc2,$moras_desc2,$ipm_desc2,$otros_desc2,$operador)
    {
        $conexion = conectarBD();
        //$sql = "insert into caja.detalle_caja (idcaja,idrubro,idtributo,idctac,importe,idsitcta)values('" . $idcaja . "',0,'" . $idtributo . "','" . $idctac . "','" . $importe . "','" . $situacion . "')";
        $sql="select caja.sp_inserta_actualiza_detalle_caja(".$idperso.",".$idapertura.", ".$idcaja.", 0, ".$idtributo.", ".$idctac.", ".$importe.", ".$gastos2.", ".$mora2.", ".$ipm2.", ".$otros2.", ".$dscto2.", ".$gastos_desc2.", ".$moras_desc2.", ".$ipm_desc2.", ".$otros_desc2.", ".$situacion.", 0, 0, 0, false, 0, ".$operador.", 0, 0)";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        if ($respuesta > 0) {
            $array[0] = 1;
        }
        $array[0] = 0;

        return $array;
    }
    function procesarPagoCabeceraCaja($idapertura, $nidperso, $total, $idmediopago, $idoperador, $idtipotarjeta, $cheque)
    {
        $conexion = conectarBD();
        $idcabecera = 0;
        $sql = "select * from caja.sp_inserta_actualiza_cabecera_caja(" . $idapertura . ", " . $nidperso . ", " . $total . " , 1, " . $idmediopago . ", 1, " . $idtipotarjeta . ", 1, 1,'" . $cheque . "', '', " . $idoperador . ", 1, 1)";
        //$sql="insert into caja.cabecera_caja(idapertura,nidperso,total,idmediopago,idoperador,fecha_ingreso,estado_recibo,tipo_rubro)values('".$idapertura."','".$nidperso."','".$total."','".$idmediopago."','".$idoperador."','".$fecha_ingreso."','C','01')";
        $respuesta = pg_query($conexion, $sql);

        while ($row = pg_fetch_assoc($respuesta)) {
            $idcabecera = $row['sp_inserta_actualiza_cabecera_caja'];
        }
        return $idcabecera;
    }
    function buscarCabeceraCaja($idperso, $fecha_ingreso)
    {
        $conexion = conectarBD();
        $sql = "select idcaja from caja.cabecera_caja where nidperso='" . $idperso . "' and fecha_ingreso='" . $fecha_ingreso . "'";
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        while ($row = pg_fetch_assoc($respuesta)) {
            $resultado = $row['idcaja'];
        }
        return $resultado;
    }
    function listarRubro($ano)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.rubros where anio='" . $ano . "'";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function insertarRubroCebecera($idjcajero, $idperso, $total, $idmediopago, $operador, $tipo_tarjeta, $cheque, $referencia)
    {
        $conexion = conectarBD();
        $idcabecera = 0;
        $sql = "select caja.sp_inserta_actualiza_cabecera_caja(" . $idjcajero . ", " . $idperso . ", " . $total . ", 1, " . $idmediopago . ", 1, " . $tipo_tarjeta . ", 2, 1, '" . $cheque . "', '" . $referencia . "', " . $operador . ", 1, 1)";
        $respuesta = pg_query($conexion, $sql);
        while ($row = pg_fetch_assoc($respuesta)) {
            $idcabecera = $row['sp_inserta_actualiza_cabecera_caja'];
        }
        return $idcabecera;
    }
    function insertarRubroDetalle($idperso,$operador,$idapertura, $caja, $idrubro, $importe, $idtipvalor, $idarea)
    {
        $conexion = conectarBD();
        //$sql = "insert into caja.detalle_caja(idcaja,idtributo,idrubro,importe,idarea,idtipvalor)values(" . $caja . ",'0','" . $idrubro . "'," . $importe . "," . $idarea . "," . $idtipvalor . ")";
        $sql="select caja.sp_inserta_actualiza_detalle_caja(".$idperso.", ".$idapertura.", ".$caja.", ".$idrubro.", 0, 0, ".$importe.", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".$idarea.", ".$idtipvalor.", 0, 'false', 0, ".$operador.", 0, 0)";
        //$sql="select caja.sp_inserta_actualiza_detalle_caja(".$idapertura.", ".$caja.", ".$idrubro.", 0, 0, ".$importe.", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, ".$idarea.", ".$idtipvalor.", 0, 'false', 0)";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        if ($respuesta > 0) {
            $array[0] = 1;
        } else {
            $array[0] = 0;
        }
        return $array;
    }
    function buscardetalleVoucher($idcaja, $idperso)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.detalle_caja, rentas.maectacte,rentas.grupo_tributos, caja.cabecera_caja where maectacte.nidperso='" . $idperso . "' and detalle_caja.idctac=maectacte.idctac and maectacte.idgrutributo=grupo_tributos.idgrutributo ";
        $sql .= "and cabecera_caja.idcaja=detalle_caja.idcaja and cabecera_caja.idcaja='" . $idcaja . "'";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function buscardetalleVoucherRubros($idacaja)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.detalle_caja,caja.cabecera_caja where cabecera_caja.idcaja=detalle_caja.idcaja and cabecera_caja.idcaja=".$idacaja;
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }

    function buscarCabeceraVoucher($idcaja, $idperso)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.cabecera_caja where nidperso='" . $idperso . "' and idcaja='" . $idcaja . "'";
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        while ($row = pg_fetch_assoc($respuesta)) {
            $resultado = $row['total'];
        }
        return $resultado;
    }
    function modificarEstadoCuenta($idctac, $fecha)
    {
        $conexion = conectarBD();
        $sql = "update rentas.maectacte set idestcta=2, fecmodif='" . $fecha . "' where idctac=" . $idctac;
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        if ($respuesta) {
            $resultado = 1;
        }
        return $resultado;
    }
    function verCodValidRecibo($idcaja){
        $conexion = conectarBD();
        $sql="select * from caja.cabecera_caja where idcaja=".$idcaja;
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
}
