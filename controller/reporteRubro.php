<?php
require_once('../vendor/autoload.php');
require_once('../model/permisosVue.php');
require_once('../controller/disenRubTrib.php');
$opcion = isset($_GET['opcion']) ? $_GET['opcion'] : '';
$idperso = isset($_GET['idperso']) ? $_GET['idperso'] : '';
$idcaja = isset($_GET['idcaja']) ? $_GET['idcaja'] : '';
$css = file_get_contents('../css/cabeceraRuboTrib.css');
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf8',
    'format' => 'A4',
    'orientation' => 'L',
    'margin_left' => 0,
    'margin_right' => 0,
    'margin_top' => 82,
    'margin_bottom' => 20
]);
if ($opcion == 'voucherRubro') {
    $header = verheader($idperso,$idcaja);
    $cuerpo = verCuerpo($idcaja, 'tupa',0);
    $footer = verFooter($idcaja,$idperso);
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($cuerpo, \Mpdf\HTMLParserMode::HTML_BODY);
    //$mpdf->SetHeader($header);
    //$mpdf->AddPage();
    $mpdf->Output("reporte.pdf", "I");
}
if ($opcion == 'voucherTributo') {
    $header = verheader($idperso,$idcaja);
    $cuerpo = verCuerpo($idcaja, 'tributo',$idperso);
    $footer = verFooter($idcaja,$idperso);
    $mpdf->SetHTMLHeader($header);
    $mpdf->SetHTMLFooter($footer);
    $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
    $mpdf->WriteHTML($cuerpo, \Mpdf\HTMLParserMode::HTML_BODY);
    //$mpdf->SetHeader($header);
    //$mpdf->AddPage();
    $mpdf->Output("reporte.pdf", "I");
}
