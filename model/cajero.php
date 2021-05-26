<?php
require_once('../database/conexion.php');
class Cajero
{
    private $operador, $clave, $id, $nrocaja;

    function getnrocaja()
    {
        return $this->nrocaja;
    }
    function setnrocaja($nrocaja)
    {
        $this->nrocaja = $nrocaja;
    }
    function getoperador()
    {
        return $this->operador;
    }
    function setoperador($operador)
    {
        $this->operador = $operador;
    }

    function getclave()
    {
        return $this->clave;
    }
    function setclave($clave)
    {
        $this->clave = $clave;
    }
    function getid()
    {
        return $this->id;
    }
    function setid($id)
    {
        $this->id = $id;
    }

    function ValidarCajero()
    {
        $conexion = conectarBD();
        $sql = "select * from seguridad.usuario where cclave='" . $this->getclave() . "' and coperador='" . $this->getoperador() . "'";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
            $this->setid($row['nidusuario']);
        }
        return $array;
    }
    function validarAperturaCaja($fecha, $idcajero)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.apertura_cierre_caja where fecha_apertura='" . $fecha . "' and idcajero='" . $idcajero . "' and estado_caja='A'";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function DatosApertura($fecha)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.apertura_cierre_caja, seguridad.usuario where cclave='" . $this->getclave() . "' and coperador='" . $this->getoperador() . "'  and fecha_apertura='" . $fecha . "' and usuario.nidusuario=apertura_cierre_caja.idcajero and estado_caja='A'";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }

    function AperturarCaja($fecha, $hora)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.sp_inserta_apertura_caja('" . $this->getid() . "', '" . $this->getoperador() . "', '" . $fecha . "', '" . $hora . "')";
        //$sql = "insert into caja.apertura_cierre_caja(fecha_apertura, idcajero, hora_apertura, idoperador,estado_caja,fecha_ingreso)values ('" . $fecha . "', '" . $this->getid() . "', '" . $hora . "', '" . $this->getoperador() . "','A','" . $fecha . "'); ";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[0] = $row;
        }
        $array[1] = $fecha;
        return $array;
    }
    function medioPago()
    {
        $conexion = conectarBD();
        $sql = "select * from caja.medio_pago";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function tipoTarjeta()
    {
        $conexion = conectarBD();
        $sql = "select * from caja.tipo_tarjeta";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function buscarCajero($fechaActual, $operador)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.apertura_cierre_caja where idoperador='" . $operador . "' and  fecha_apertura='" . $fechaActual . "'";
        $respuesta = pg_query($conexion, $sql);


        while ($row = pg_fetch_assoc($respuesta)) {

            $this->setid($row['idapertura']);
        }
    }
    function listarCajero($fechari, $fecharf, $mediopago, $estado)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.fn_list_ingresos_cajeros('" . $this->getnrocaja() . "','" . $mediopago . "','" . $estado . "','" . $fechari . "','" . $fecharf . "')";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listarIngresos($id, $tipoingreso)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.fn_list_ingresos_cajero_dia(" . $id . ",'" . $tipoingreso . "')";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }

    function extornarcuenta($idapertura, $numrecibo, $observacion)
    {
        $conexion = conectarBD();
        $sql = "update caja.cabecera_caja SET estado_recibo='E', observacion='" . $observacion . "'  where  idapertura='" . $idapertura . "' and num_recibo='" . $numrecibo . "'";
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        if ($respuesta) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }
    function extornarCuentacte($idcta)
    {
        $conexion = conectarBD();
        $sql = "update rentas.maectacte set idestcta=1 where idctac=" . $idcta;
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        if ($respuesta) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }
    function cerrarCaja($idapertura, $cantope, $cantextor, $cantcance, $totalextorno, $totalcancelado)
    {
        $conexion = conectarBD();
        $sql = "update caja.apertura_cierre_caja set estado_caja='C', cantidad_operaciones='" . $cantope . "',cantidad_cancelados='" . $cantcance . "', cantidad_extornados='" . $cantextor . "', total_cancelados='" . $totalcancelado . "', total_extornados='" . $totalextorno . "'   where idapertura=" . $idapertura;
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        if ($respuesta) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }
    function cabecera_caja_back($idapertura)
    {
        $conexion = conectarBD();
        $sql = "insert INTO caja.cabecera_caja_bak SELECT * FROM caja.cabecera_caja WHERE idapertura=" . $idapertura;
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        if ($respuesta) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }
    function buscaridcaja_back($idapertura)
    {
        $conexion = conectarBD();
        $sql = "select idcaja from caja.cabecera_caja_bak where idapertura=" . $idapertura;
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function InsertarDetalleback($idcaja)
    {
        $conexion = conectarBD();
        $sql = "insert INTO caja.detalle_caja_bak SELECT iddcaja,idcaja,idrubro,idtributo,idctac,importe,idsitcta,idarea,idtipvalor,idvalor,anulado FROM caja.detalle_caja WHERE idcaja=" . $idcaja;
        $respuesta = pg_query($conexion, $sql);
        $resultado = 0;
        if ($respuesta) {
            $resultado = 1;
        } else {
            $resultado = 0;
        }
        return $resultado;
    }
    function listarTupa($id)
    {
        $conexion = conectarBD();
        $sql = "select cabecera_caja.nidperso,detalle_caja.idrubro,rubros.nombre_rubro as nombre,detalle_caja.idctac,detalle_caja.importe,cabecera_caja.total from caja.detalle_caja, caja.cabecera_caja, caja.rubros where cabecera_caja.idcaja=detalle_caja.idcaja and detalle_caja.idrubro=rubros.idrubro and cabecera_caja.idcaja=" . $id;
        //$sql = "select cabecera_caja.nidperso,detalle_caja.idrubro,(grupo_tributos.cdestribu || ' / ' || tributos.cdestribu  ) as nombre,detalle_caja.idctac,detalle_caja.importe,cabecera_caja.total from caja.detalle_caja, caja.cabecera_caja, rentas.tributos,rentas.grupo_tributos where cabecera_caja.idcaja=detalle_caja.idcaja and tributos.idtributo=detalle_caja.idtributo and tributos.ngrutribu=grupo_tributos.idgrutributo and cabecera_caja.idcaja=" . $id;
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listarTributo($id)
    {
        $conexion = conectarBD();
        $sql = "select cabecera_caja.nidperso,detalle_caja.idrubro,(grupo_tributos.cdestribu || ' / ' || tributos.cdestribu  ) as nombre,detalle_caja.idctac,detalle_caja.importe,cabecera_caja.total from caja.detalle_caja, caja.cabecera_caja, rentas.tributos,rentas.grupo_tributos where cabecera_caja.idcaja=detalle_caja.idcaja and tributos.idtributo=detalle_caja.idtributo and tributos.ngrutribu=grupo_tributos.idgrutributo and cabecera_caja.idcaja=" . $id;
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function listarPartidas($fechaI, $fechaF, $tipo, $ncaja)
    {
        $conexion = conectarBD();
        $sql = "select * from caja.fn_reporte_ingreso_partidas('" . $fechaI . "','" . $fechaF . "'," . $tipo . "," . $ncaja . ")";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function verdetalle($idapertura)
    {
        $conexion = conectarBD();
        $sql = "select cabecera_caja_bak.nidperso,detalle_caja_bak.idrubro,(grupo_tributos.cdestribu || ' / ' || tributos.cdestribu  ) as nombre,detalle_caja_bak.idctac,detalle_caja_bak.importe,cabecera_caja_bak.total ";
        $sql .= "from caja.detalle_caja_bak, caja.cabecera_caja_bak, rentas.tributos,rentas.grupo_tributos where cabecera_caja_bak.idcaja=detalle_caja_bak.idcaja and tributos.idtributo=detalle_caja_bak.idtributo ";
        $sql .= "and tributos.ngrutribu=grupo_tributos.idgrutributo and cabecera_caja_bak.idapertura=" . $idapertura;
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function IngresosDia($fechaI, $fechaF)
    {   
        $conexion = conectarBD();
        $sql = "select fecha_apertura,sum(total_cancelados) as totalcancelados,sum(total_extornados)as totalextorn,sum(cantidad_cancelados) as cantidadCance ,sum(cantidad_extornados) as cantidadExtorn ";
        $sql .= "from caja.apertura_cierre_caja where fecha_apertura between '" . $fechaI . "' and '" . $fechaF . "' group by fecha_apertura";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function reporRubtribu($idcaja){
        $conexion = conectarBD();
        $sql="select * from caja.sp_recibo_caja_01(".$idcaja.")";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function codresivoRubtribu($idcaja){
        $conexion = conectarBD();
        $sql="select * from caja.sp_recibo_caja_01(".$idcaja.") limit 1";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
    function AnexoRubtribu($idcaja){
        $conexion = conectarBD();
        $sql="select Distinct nanexo2 from caja.sp_recibo_caja_01(".$idcaja.")  order by nanexo2 asc";
        $respuesta = pg_query($conexion, $sql);
        $array = array();
        while ($row = pg_fetch_assoc($respuesta)) {
            $array[] = $row;
        }
        return $array;
    }
}
