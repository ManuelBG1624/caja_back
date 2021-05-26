<?php
require_once('../model/cajero.php');
date_default_timezone_set('America/Lima');
function verheader($ncaja)
{
    $html = '
    <div class="contenido">
    <div class="logo"><img src="../logo/logo_barranco.png" ></div>
    <div class="fecha"><h6 class="fech">{DATE j-m-Y} {PAGENO}/{nbpg}</h6>
    </div>
    <div class="titulo">
        <h3>REPORTE POR VOUCHER DE LA CAJA N°' . $ncaja;
    $html .= '</h3>
        <h6>DEL DIA {DATE j-m-Y} AL {DATE j-m-Y}</h6>
    </div>
    <h6>Ingreso por: Municipalidad</h6>
    <table class="Tcabecera">
        <tr>
            <th>N°</th>
            <th>N° Oper</th>
            <th>N° recibo</th>
            <th>Codigo</th>
            <th>Apellidos y Nombres</th>
            <th>Importe</th>
            <th>Estado</th>
            <th>Tipo Rubro</th>
            <th>Medio pago</th>
        </tr>
    </table>
</div>
    ';

    return $html;
}
function verCuerpo($idapertura, $totalExtorno, $total, $tipoingreso)
{
    $objcajero = new Cajero();
    $arraypersona = array();
    $n = 1;

    $arraypersona = $objcajero->listarIngresos($idapertura,$tipoingreso);


    $html = '
    
<div class="contenido-cuerpo">
<table class="Tcuerpo">';
    foreach ($arraypersona as $i) {
        $html .= '<tr>
            <td >' . $n++ . '</td>
            <td class="orden">' . $i["num_operacion"] . ' </td>
            <td class="orden">' . $i["num_recibo"] . '</td>
            <td class="orden">' . $i["ccodperso"] . '</td>
            <td class="nombre">' . $i["nombre_completo"] . '</td>
            <td class="orden1">' . $i["total"] . '</td>
            <td class="orden1">' . $i["estado_recibo"] . '</td>
            <td >' . $i["tipo_rubro"] . '</td>
            <td class="orden2">' . $i["nombre_medio_pago"] . '</td>
        </tr>';
    }
    $html .= '</table>
    <hr>
    <h6 class="recibos">IMPORTE RECIBOS CANCELADOS: ' . $total . '</h6>
    <h6 class="recibos">IMPORTE RECIBOS EXTORNADOS: ' . $totalExtorno . '</h6>
</div>
    ';
    return $html;
}
function verfooter($nombre, $operador)
{
    $html = '
    <table class="Tfooter">
    <tr>
        <td width="33%">Nombre del Cajero: ' . $nombre . '</td>
        <td width="33%">Codigo Cajero: ' . $operador . '</td>
        <td width="33%">Fecha de cierre: {DATE j-m-Y}</td>
    </tr>
</table>
    ';
    return $html;
}
