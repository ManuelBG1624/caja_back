<?php
date_default_timezone_set('America/Lima');
require_once('../model/cajero.php');
function verCabecera($ncaja, $fini, $ffin)
{
    $fini = date_format(date_create($fini), 'd-m-Y');
    $ffin = date_format(date_create($fini), 'd-m-Y');
    $html = '
    <div class="contenido">
        <div class="logo"><img src="../logo/logo_barranco.png"></div>
        <div class="titulo"><h3>PARTE DIARIO DE CAJA N°' . $ncaja . '</h3>
        <h6>Fecha: ' . $fini . ' al ' . $ffin . '</h6>
        </div>
        <div class="fecha">{DATE j-m-Y} {PAGENO}/{nbpg}</div>
    </div>
    <table>
        <tr>
            <th><hr>Partida</th><hr>
            <th><hr>Descripcion</th><hr>
            <th><hr>Monto</th><hr>
        </tr>
    </table>
    
    ';
    return $html;
}
function verCuerpo2($fechaI, $fechaF, $tipo, $ncaja)
{
    $objcajero = new Cajero();
    $array = array();
    $array = $objcajero->listarPartidas($fechaI, $fechaF, $tipo, $ncaja);
    $partida = "";
    $partida2 = "";
    $nombr = "";
    $importe = array();
    $importe2 = "";
    $anno = "";
    for ($f = 0; $f < count($array); $f++) {
        //echo $array[$f]['anotributo'];
        $partida .= $array[$f]['partida12'] . ",";
        $partida2 .= $array[$f]['partida2'] . ",";
        $nombr .= $array[$f]['nombre_partida2'] . ",";
        $anno .= $array[$f]['anotributo'] . ",";
        if ($f < count($array) - 1) {
            if ($array[$f]['nombre_partida2'] == $array[$f + 1]['nombre_partida2']) {
                $importe[$f] = $array[$f]['importe2'] + $array[$f + 1]['importe2'];
            } else {
                //$importe[$f]=$array[$f]['importe2'];
            }
        }
    }
    $arraypartida12 = array();
    $arraypartida2 = array();
    $arrayano = array();
    $nombres = array();
    for ($i = 1; $i <= count(array_unique(explode(",", substr($anno, 0, -1)))); $i++) {
        $arrayano = array_chunk(array_unique(explode(",", substr($anno, 0, -1))), $i);
    }

    for ($i = 1; $i <= count(array_unique(explode(",", substr($partida, 0, -1)))); $i++) {
        $arraypartida12 = array_chunk(array_unique(explode(",", substr($partida, 0, -1))), $i);
    }
    for ($i = 1; $i <= count(array_unique(explode(",", substr($partida2, 0, -1)))); $i++) {
        $arraypartida2 = array_chunk(array_unique(explode(",", substr($partida2, 0, -1))), $i);
        $nombres = array_chunk(array_unique(explode(",", substr($nombr, 0, -1))), $i);
    }
    $arrayPartida22 = array('partida12' => $arraypartida12, 'partida2' => $arraypartida2, 'nombre_partida2' => $nombres, 'importe2' => $importe);
    $html = '
        <table>';
        foreach ($array as $i) {
            $html .= '<tr>
                    <td class="part">
                    <h4>' . $i['partida12'] . '</h4>
                    <p>' . $i['partida2'] . '</p>
                    </td>
                    <td class="nomb">
                    <h4>' . $i['grupo2'] . '</h4>
                    <p>' . $i['nombre_partida2'] . '</p>
                    </td>
                    <td class="num">' . $i['importe2'] . '</td>
                </tr>';
        }
    $html .= '</table>
    ';

    return $html;
}
function verfooter2($fechaI, $fechaF, $tipo, $ncaja)
{
    $total = 0;
    $objcajero = new Cajero();
    $array = array();
    $array = $objcajero->listarPartidas($fechaI, $fechaF, $tipo, $ncaja);
    foreach ($array as $i) {
        $total = $total + $i['importe2'];
    }
    $html = '
    <table>
        <tr>
            <td class="part"></td>
            <td class="nomb">
            <h5>INGRESOS PRESUPUESTARIOS</h5>
            <p>Total del Dia: {DATE j-m-Y}</p>
            </td>
            <td class="num"><h3>' . $total . '</h3></td>
        </tr>
    </table>
    ';
    return $html;
}
