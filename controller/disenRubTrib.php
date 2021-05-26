<?php
require_once("../model/contribuyentes.php");
require_once("../model/cajero.php");
date_default_timezone_set('America/Lima');
function verheader($idperso, $idcaja)
{
    $objcontribuyentes = new contribuyentes();
    $objcajero = new Cajero();
    $arraypersona = array();
    $arraynumre = array();
    $arraypersona = $objcontribuyentes->Persona($idperso);
    //$arraynumre = $objcontribuyentes->verCodValidRecibo($idcaja);
    $arraynumre = $objcajero->codresivoRubtribu($idcaja);
    $arrayAnexo = array();
    $arrayAnexo = $objcajero->AnexoRubtribu($idcaja);
    $anexo = "";
    foreach ($arrayAnexo as $i) {
        $anexo .= $i["nanexo2"] . "-";
    }
    $anexo = substr($anexo, 0, -1);
    $html = '
    <body>
    <div class="contenedor">
        <div class="cab cabecera1">
            <div class="logo"><img src="../logo/logo_barranco.png"></div>
            <div class="pagina">{PAGENO}/{nbpg}</div>
            ';
    foreach ($arraynumre as $i) {
        $html .= '<div class="sub-cabe">
                <h4>RECIBO DE CAJA N° 0000' . $i['num_recibo2'] . '-{DATE Y}</h4>
            </div>
            <hr>
            <br>';
    }
    foreach ($arraypersona as $i) {
        $html .= '<div class="titulo">codigo</div>
            <div class="descripcion">:' . $i["ccodperso"] . '</div>
            <div class="titulo">Contribuyente</div>
            <div class="descripcion">:' . $i["cnombres"] . ' ' . $i["capemater"] . ' ' . $i["capepater"] . '</div>
            <div class="titulo">Direccion</div>
            <div class="descripcion">:' . $i["cdesdire"] . '' . $i["cdesdist"] . '</div>
            <div class="titulo">Anexo</div>
            <div class="descripcion">:' . $anexo . '</div>';
    }
    $html .= '<table>
            <tr>
            <th><hr>Predio</th><hr>
            <th><hr>Rubro Periodo</th><hr>
            <th><hr>Insoluto</th><hr>
            <th><hr>Gasto</th><hr>
            <th><hr>Moras</th><hr>
            <th><hr>Total</th><hr>
            </tr>
            </table>
            
        </div>
        <div class="cab cabecera2">
            <div class="logo"><img src="../logo/logo_barranco.png"></div>
            <div class="pagina">{PAGENO}/{nbpg}</div>
            ';
    foreach ($arraynumre as $i) {
        $html .= '<div class="sub-cabe">
                     <h4>RECIBO DE CAJA N° 0000' . $i['num_recibo2'] . '-{DATE Y}</h4>
                 </div>
                 <hr>
                 <br>';
    }
    foreach ($arraypersona as $i) {
        $html .= '<div class="titulo">codigo</div>
                <div class="descripcion">:' . $i["ccodperso"] . '</div>
                <div class="titulo">Contribuyente</div>
                <div class="descripcion">:' . $i["cnombres"] . ' ' . $i["capemater"] . ' ' . $i["capepater"] . '</div>
                <div class="titulo">Direccion</div>
                <div class="descripcion">:' . $i["cdesdire"] . '' . $i["cdesdist"] . '</div>
                <div class="titulo">Anexo</div>
                <div class="descripcion">:' . $anexo . '</div>';
    }
    $html .= '<table>
            <tr>
            <th><hr>Predio</th><hr>
            <th><hr>Rubro Periodo</th><hr>
            <th><hr>Insoluto</th><hr>
            <th><hr>Gasto</th><hr>
            <th><hr>Moras</th><hr>
            <th><hr>Total</th><hr>
            </tr>
            </table>
        </div>
        <div class="cab cabecera3">
            <div class="logo"><img src="../logo/logo_barranco.png"></div>
            <div class="pagina">{PAGENO}/{nbpg}</div>';
    foreach ($arraynumre as $i) {
        $html .= '<div class="sub-cabe">
                     <h4>RECIBO DE CAJA N° 0000' . $i['num_recibo2'] . '-{DATE Y}</h4>
                 </div>
                 <hr>
                 <br>';
    }
    foreach ($arraypersona as $i) {
        $html .= '<div class="titulo">codigo</div>
                <div class="descripcion">:' . $i["ccodperso"] . '</div>
                <div class="titulo">Contribuyente</div>
                <div class="descripcion">:' . $i["cnombres"] . ' ' . $i["capemater"] . ' ' . $i["capepater"] . '</div>
                <div class="titulo">Direccion</div>
                <div class="descripcion">:' . $i["cdesdire"] . '' . $i["cdesdist"] . '</div>
                <div class="titulo">Anexo</div>
                <div class="descripcion">:' . $anexo . '</div>';
    }
    $html .= '<table>
            <tr>
            <th><hr>Predio</th><hr>
            <th><hr>Rubro Periodo</th><hr>
            <th><hr>Insoluto</th><hr>
            <th><hr>Gasto</th><hr>
            <th><hr>Moras</th><hr>
            <th><hr>Total</th><hr>
            </tr>
            </table>
        </div>

    </div>
</body>
    
    ';
    return $html;
}
function verCuerpo($idcaja, $tupa, $idperso)
{
    $objcajero = new Cajero();
    $arrayT = array();
    $arrayT = $objcajero->reporRubtribu($idcaja);


    if ($tupa == 'tupa') {


        $html = '
    <div class="cuerpo">
        <div class="cuer cuerpo1">
            <table>';
        foreach ($arrayT as $i) {
            $total = $i["insoluto2"] + $i["gasto2"] + $i["moras2"];
            $html .= '<tr>
                    <td class="num">' . $i["ncodpredi2"] . '</td>
                    <td class="nom">' . $i["grupotributo2"] . '/' . $i["anotributo2"] . ' 0' . $i["periodos2"] .  '</td>
                    <td class="num">' . $i["insoluto2"] . '</td>
                    <td class="num">' . $i["gasto2"] . '</td>
                    <td class="num">' . $i["moras2"] . '</td>
                    <td class="num">' . $total . '</td>
                </tr>';
        }

        $html .= '</table>
        </div>
        <div class="cuer cuerpo2">
            <table>';
        foreach ($arrayT as $i) {
            $total = $i["insoluto2"] + $i["gasto2"] + $i["moras2"];
            $html .= '<tr>
                    <td class="num">' . $i["ncodpredi2"] . '</td>
                    <td class="nom">' . $i["grupotributo2"] . '/' . $i["anotributo2"] . ' 0' . $i["periodos2"] .  '</td>
                    <td class="num">' . $i["insoluto2"] . '</td>
                    <td class="num">' . $i["gasto2"] . '</td>
                    <td class="num">' . $i["moras2"] . '</td>
                    <td class="num">' . $total . '</td>
            </tr>';
        }
        $html .= '</table>
        </div>
        <div class="cuer cuerpo3">
            <table>';
        foreach ($arrayT as $i) {
            $total = $i["insoluto2"] + $i["gasto2"] + $i["moras2"];
            $html .= '<tr>
                    <td class="num">'. $i["ncodpredi2"] .'</td>
                    <td class="nom">' . $i["grupotributo2"] . '/' . $i["anotributo2"] . ' 0' . $i["periodos2"] .  '</td>
                    <td class="num">'. $i["insoluto2"] .'</td>
                    <td class="num">'. $i["gasto2"] .'</td>
                    <td class="num">'. $i["moras2"] . '</td>
                    <td class="num">' . $total . '</td>
            </tr>';
        }
        $html .= '</table>
        </div>
    </div>
    ';
    }
    if ($tupa == 'tributo') {
        //$objcontribuyentes = new contribuyentes();
        $objcajero = new Cajero();
        $arrayTri = array();
        $arrayTri = $objcajero->reporRubtribu($idcaja);
        //$arrayTri = $objcontribuyentes->buscardetalleVoucher($idcaja, $idperso);
        $html = '
    <div class="cuerpo">
        <div class="cuer cuerpo1">
            <table>';
        foreach ($arrayTri as $i) {
            $total = $i["insoluto2"] + $i["gasto2"] + $i["moras2"];
            $html .= '<tr>
                    <td class="num">' . $i["ncodpredi2"] . '</td>
                    <td class="nom">' . $i["grupotributo2"] . '/' . $i["anotributo2"] . ' 0' . $i["periodos2"] . '</td>
                    <td class="num">' . $i["insoluto2"] . '</td>
                    <td class="num">' . $i["gasto2"] . '</td>
                    <td class="num">' . $i["moras2"] . '</td>
                    <td class="num">' . $total . '</td>
                </tr>';
        }

        $html .= '</table>
        </div>
        <div class="cuer cuerpo2">
            <table>';
        foreach ($arrayTri as $i) {
            $total = $i["insoluto2"] + $i["gasto2"] + $i["moras2"];
            $html .= '<tr>
            <td class="num">' . $i["ncodpredi2"] . '</td>
            <td class="nom">' . $i["grupotributo2"] . '/' . $i["anotributo2"] . ' 0' . $i["periodos2"] . '</td>
            <td class="num">' . $i["insoluto2"] . '</td>
            <td class="num">' . $i["gasto2"] . '</td>
            <td class="num">' . $i["moras2"] . '</td>
            <td class="num">' . $total . '</td>
            </tr>';
        }
        $html .= '</table>
        </div>
        <div class="cuer cuerpo3">
            <table>';
        foreach ($arrayTri as $i) {
            $total = $i["insoluto2"] + $i["gasto2"] + $i["moras2"];
            $html .= '<tr>
            <td class="num">' . $i["ncodpredi2"] . '</td>
            <td class="nom">' . $i["grupotributo2"] . '/' . $i["anotributo2"] . ' 0' . $i["periodos2"] . '</td>
            <td class="num">' . $i["insoluto2"] . '</td>
            <td class="num">' . $i["gasto2"] . '</td>
            <td class="num">' . $i["moras2"] . '</td>
            <td class="num">' . $total . '</td>
            </tr>';
        }
        $html .= '</table>
        </div>
    </div>
    ';
    }
    return $html;
}
function verFooter($idcaja, $idperso)
{
    $objcontribuyentes = new contribuyentes();
    $objcajero = new Cajero();
    $arraynumre = array();
    //$resultado = $objcontribuyentes->buscarCabeceraVoucher($idcaja, $idperso);
    $arraynumre = $objcontribuyentes->verCodValidRecibo($idcaja);
    $arrayTotal = array();
    $arrayTotal = $objcajero->codresivoRubtribu($idcaja);
    $arrayImporte = array();
    $arrayImporte = $objcajero->reporRubtribu($idcaja);
    $idmediopago = 0;
    $insoluto = 0;
    $gasto = 0;
    $mora = 0;
    $total = 0;
    $descmediopago = "";
    $cdgo = "";
    foreach ($arraynumre as $i) {
        $idmediopago = $i["idmediopago"];
    }
    if ($idmediopago == 1) {
        $descmediopago = "EFECTIVO";
    }
    if ($idmediopago == 2) {
        $descmediopago = "TARJETA CREDITO/DEBITO";
    }
    if ($idmediopago == 3) {
        $descmediopago = "CHEQUE";
    }
    if ($idmediopago == 4) {
        $descmediopago = "PAGO BANCOS";
    }
    if ($idmediopago == 5) {
        $descmediopago = "PAGO WEB";
    }
    foreach ($arrayTotal as $i) {
        $total = $i['total2'];
        $cdgo = $i['codigo_validacion2'];
    }
    foreach ($arrayImporte as $i) {
        $insoluto = $insoluto + $i['insoluto2'];
        $mora = $mora + $i['moras2'];
        $gasto = $gasto + $i['gasto2'];
    }
    $html = '
    <div class="footer">
        <div class="foot cuerpo1foot">
        <table class="tab-foot">
        <tr>
            <th colspan="2">' . $descmediopago . '</th>
            <th class="num"></th>
            <th class="num"></th>
            <th class="num"></th>
            <th>' . $total . '</th>
        </tr>
        </table>
        <p class="codigo">' . $cdgo . '</p>
        </div>';

    $html .= ' <div class="foot cuerpo2foot">
    <table class="tab-foot">
    <tr>
        <th colspan="2">' . $descmediopago . '</th>
        <th class="num"></th>
        <th class="num"></th>
        <th class="num"></th>
        <th>' . $total . '</th>
    </tr>
    </table>
    <p class="codigo">' . $cdgo . '</p>
    </div>';
    $html .= ' <div class="foot cuerpo3foot">
    <table class="tab-foot">
    <tr>
        <th colspan="2">' . $descmediopago . '</th>
        <th class="num"></th>
        <th class="num"></th>
        <th class="num"></th>
        <th>' . $total . '</th>
    </tr>
    </table>
    <p class="codigo">' . $cdgo . '</p>
    </div>';
    $html . '</div>
    
    ';
    return $html;
}
