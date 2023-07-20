<?php

require_once dirname(__FILE__) . '/vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

/**DATOS */
$servername = "localhost";
$username = "root";
$password = "desarrollo";
$dbname = "awfacturademo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from venta inner join cliente on cliente.idcliente = venta.idventa where idventa = " . $_GET["idv"];
$datosVenta = $conn->query($sql);
$nombrecliente = "";
$direccion  = "";
$rfc = "";
$idventa = "";
$fechaventa = "";
if ($datosVenta->num_rows > 0) {
    // output data of each row
    while ($row = $datosVenta->fetch_assoc()) {
        $nombrecliente = $row["nombrecliente"] . " " . $row["apaternocliente"] . " " . $row["amaternocliente"];
        $direccion = $row["direccioncliente"];
        $rfc = $row["rfccliente"];
        $idventa = $row["idventa"];
        $fechaventa = $row["fechaventa"];
    }
}


$sql = "select * from detalleventa inner join producto on detalleventa.idproducto = producto.idproducto where detalleventa.idventa = " . $_GET["idv"];
$detalleVenta = $conn->query($sql);

$contenidoDetVta = "";
$subtotal = 0;
if ($detalleVenta->num_rows > 0) {
    // output data of each row
    while ($row = $detalleVenta->fetch_assoc()) {
        $subtotal += ($row["preciounitario"] * $row["cantidad"]);
        $contenidoDetVta .= '<tr>
        <td>' . $row["idproducto"] . '</td>
        <td> ' . $row["nombreproducto"] .  ' </td>
        <td>$' . $row["preciounitario"] .  '</td>
        <td>' . $row["cantidad"] . '</td>
        <td>$ ' . ($row["preciounitario"] * $row["cantidad"])  . ' </td>
    </tr>';
    }
}

$conn->close();
/**DATOS */

$contenido = '<div style="text-align:center"><h1>Factura</h1></div>
<h2>Remitente:</h2>
<p>Universidad sa de cv.
<br>
XEXE00000XEX
<br>
Calle de las lágimas s/n
<br>
76000, Querétaro, Qro.
</p>
<h2>Cliente:</h2>
<p>' . $nombrecliente . '.
<br>
' . $rfc . '
<br>
'  . $direccion . '
</p>
<hr>
<p>Factura No: ' . $idventa . '  Fecha: ' . $fechaventa . ' </p>
<hr>
<table width="100%">
    <tr>
        <th>Clave</th>
        <th>Producto</th>
        <th>Precio U.</th>
        <th>Cantidad</th>
        <th>Importe</th>
    </tr>';

$contenido .= $contenidoDetVta;

$contenido .= ' 
</table>
<div style="text-align:right">
<p><strong>Subtotal: $' . $subtotal . '
<br>I.V.A.:   $ ' . $subtotal * 0.16 . '
<br>Total:   $ ' . $subtotal * 1.16 .  ' </strong></p>
</div>
<p><strong>Folio fiscal:</strong> ' . md5($rfc) . "//" . md5($nombrecliente) . '-' . md5($direccion) . '</p>
<p>Escanéa para validar</p>
<qrcode value="Factura válida" ec="H" style="width: 60mm;"></qrcode>
';

try {
    ob_start();


    $html2pdf = new Html2Pdf('P', 'A4', 'es');
    $html2pdf->writeHTML($contenido);
    $html2pdf->output('factura.pdf');
} catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}
