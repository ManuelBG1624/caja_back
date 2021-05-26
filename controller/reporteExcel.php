<?php
require_once('../model/permisosVue.php');
require_once('../model/cajero.php');
$objcajero = new Cajero();
date_default_timezone_set('America/Lima');
$opcion = isset($_GET['opcion']) ? $_GET['opcion'] : '';
$idapertura = isset($_GET['idapertura']) ? $_GET['idapertura'] : '';
$dia = date("d");
$mes = date("m");
$año = date("Y");
$total=0.00;
if ($opcion == 'ImprimirExcel') {
    $data = array();
    $data = $objcajero->verdetalle($idapertura);
    header("Content-Type:application/xls");
    header("Content-Disposition: attachment; filename=reporte " . $dia . "-" . $mes . "-" . $año . ".xls");
?>
    <table border="2">
        <tr>
            <th>Idpersona</th>
            <th>Descripcion</th>
            <th>Idcta</th>
            <th>Importe</th>
        </tr>
        <?php foreach ($data as $i) { 
            $total=$total+$i['importe'];
            ?>
            <tr>
                <td><?php echo $i['nidperso'] ?></td>
                <td><?php echo $i['nombre'] ?></td>
                <td><?php echo $i['idctac'] ?></td>
                <td><?php echo $i['importe'] ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td></td>
            <td></td>
            <td>Total</td>
            <td><?php echo $total ?></td>
        </tr>
    </table>

<?php } ?>