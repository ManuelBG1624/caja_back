<?php
require_once('../vendor/autoload.php');
require_once('../model/permisosVue.php');
require_once('./disenCabeceracajero.php');
require_once('./disenreportePartida.php');
$opcion = isset($_GET['opcion']) ? $_GET['opcion'] : '';
$idapertura = isset($_GET['idapertura']) ? $_GET['idapertura'] : '';
$ncaja = isset($_GET['ncaja']) ? $_GET['ncaja'] : '';
$totalExtorno = isset($_GET['totalExtorno']) ? $_GET['totalExtorno'] : '';
$total = isset($_GET['total']) ? $_GET['total'] : '';
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$operador = isset($_GET['operador']) ? $_GET['operador'] : '';
$tipoingreso=isset($_GET['tipoingreso']) ? $_GET['tipoingreso'] : '';
$fechI=isset($_GET['fechI']) ? $_GET['fechI'] : '';
$fechaF=isset($_GET['fechaF']) ? $_GET['fechaF'] : '';
$tipo=isset($_GET['tipo']) ? $_GET['tipo'] : '';
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'setAutoTopMargin' => false,
    //'setAutoBottomMargin'=>'stretch',
    //'autoMarginPadding'=>5,
    //'orientation' => 'L',
    //'margin_left' => 0,
    //'margin_right' => 0,
    'margin_top' => 85,
    //'margin_bottom' => 0
]);
if ($opcion == 'reporteIngresos') {
    $css = file_get_contents('../css/cabeceraCajero.css');
    $header = verheader($ncaja);
    $cuerpo = verCuerpo($idapertura, $totalExtorno, $total,$tipoingreso);
    $footer = verfooter($nombre, $operador);

    //$mpdf->SetHeader($header);
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($cuerpo, \Mpdf\HTMLParserMode::HTML_BODY);

    //$mpdf->SetHeader($header);
    //$mpdf->AddPage();
    $mpdf->Output("reporte.pdf", "I");
}
if ($opcion == 'reportePartida') {
    $css = file_get_contents('../css/cabeceraPartidas.css');
    $header = verCabecera($ncaja,$fechI,$fechaF);
    $cuerpo = verCuerpo2($fechI,$fechaF,$tipo,$ncaja);
    $footer = verfooter2($fechI,$fechaF,$tipo,$ncaja);

    //$mpdf->SetHeader($header);
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($cuerpo, \Mpdf\HTMLParserMode::HTML_BODY);

    //$mpdf->SetHeader($header);
    //$mpdf->AddPage();
    $mpdf->Output("reporte.pdf", "I");
}
