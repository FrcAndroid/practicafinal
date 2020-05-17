<?php

// Include the main TCPDF library (search for installation path).
require_once('../TCPDF/tcpdf.php');
require_once('../base_datos.php');
require_once('inicio_gestion.php');


// create new PDF document
//Todas las mayusculas son defines
//estos se encuentran definidos en
// RUTA tcpdf/config/tcpdf_config.php
// Si quieres cambiar algo ahí tienes todas las opcciones
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Datos del creador
// //que evidentemente no SOY YO
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Francis Rodríguez');
$pdf->SetTitle('Factura Empresa S.A.');
$pdf->SetSubject('Factura');
$pdf->SetKeywords('Factura, PDF');

// Que llava Cabecera por defecto
$pdf->SetHeaderData('/img/logopdf.png', PDF_HEADER_LOGO_WIDTH, 'Factura Empresa S.A.', '654420069       empresaesea.com       Avenida de la Libertad 24, 03205 Elche');

// Poner la fuentes por defecto de pie y cabecera
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Fuente por defecto de tipo monospaced
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Margenes por defecto
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Cuando por ejemplo una tabla no cabe, que pasa
// // en este caso creo una nueva página
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Como esclar las fotos
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// ---------------------------------------------------------

// Fuente por defecto, antes es en caso de fuente mono
$pdf->SetFont('dejavusans', '', 10);

// Nueva pagina
$pdf->AddPage();

$cod = $_GET['factura'];
define('USUARIO', 'GESTOR');
$conexion = conectar(USUARIO);
$consulta = "SELECT * FROM lineas_facturas WHERE COD_FACTURA = :cod";
$parametros = [":cod" => $cod];
$resultado = $conexion->prepare($consulta);
$resultado->execute($parametros);
$facturas = $resultado->fetchAll(PDO::FETCH_ASSOC);


//recogemos los datos del cliente a partir del cliente de la factura
$consulta = "SELECT * FROM clientes WHERE COD_CLIENTE = :cod";
$parametros = [":cod" => $facturas[0]['COD_CLIENTE']];
$cliente = $conexion->prepare($consulta);
$cliente->execute($parametros);
$datos = $cliente->fetch(PDO::FETCH_ASSOC);
$total = 0;
// Empecemos generando a partir de HTML
// existen otra formas pero esta es la más sencilla para nosotros.
$html = '
<p style="font-size: 20px"><b>Cliente:</b> '. $datos['RAZON_SOCIAL'] .'</p>
<p style="font-size: 20px"><b>DNI:</b> '. $datos['CIF_DNI'] .'</p>
<p style="font-size: 20px"><b>Email:</b> '. $datos['EMAIL'] .'</p>';
//TABLA DONDE MOSTRAMOS LA FACTURA

$html .= '<table style="border:1px black solid">
            <thead>
                <tr>
                <th style="border:2px black solid">Codigo</th>
                <th style="border:2px black solid">Descripción</th>
                <th style="border:2px black solid">Cantidad</th>
                <th style="border:2px black solid">Precio unitario</th>
                <th style="border:2px black solid">Descuento</th>    
                <th style="border:2px black solid">IVA</th>
                <th style="border:2px black solid">Total</th>
                </tr>
            </thead>
           <tbody>';

foreach($facturas as $key => $factura) {
    //en cada uno, accedemos a articulos para sacar el nombre del articulo
    $consulta = "SELECT * FROM articulos WHERE COD_ARTICULO = :cod";
    $parametros = [":cod" => $factura['COD_ARTICULO']];
    $articulo = $conexion->prepare($consulta);
    $articulo->execute($parametros);
    $datosArticulo = $articulo->fetch(PDO::FETCH_ASSOC);

    $valorTotal = $factura['PRECIO'] + ($factura['PRECIO']) * ($factura['IVA'] / 100);
    $factura['DESCUENTO'] > 0? $valorTotal = $valorTotal - $valorTotal * ($factura['DESCUENTO'] / 100) :
    $total = $total + $valorTotal;
    $html .= '<tr>
        <td style="border:1px black solid">' . $factura['COD_ARTICULO'] . '</td>
        <td style="border:1px black solid">' . $datosArticulo['NOMBRE'] . '</td>
        <td style="border:1px black solid">' . $factura['CANTIDAD'] . '</td>
        <td style="border:1px black solid">' . $factura['PRECIO'] / $factura['CANTIDAD'] . '</td>
        <td style="border:1px black solid">' . $factura['DESCUENTO'] . '</td>
        <td style="border:1px black solid">' . $factura['IVA'] . '</td>
        <td style="border:1px black solid">' . $valorTotal . '</td>
    </tr>';
}

$html .= '</tbody></table>';
//calculamos el total final
$consulta = "SELECT * FROM facturas WHERE COD_FACTURA = :cod";
$parametros = [":cod" => $factura['COD_FACTURA']];
$resultado = $conexion->prepare($consulta);
$resultado->execute($parametros);
$datosFactura = $resultado->fetch(PDO::FETCH_ASSOC);

$totalFinal = $total - $total * $datosFactura['DESCUENTO_FACTURA'] / 100;
$html .= '<p>Subtotal: '. $total .'</p><p>Descuento: '.$datosFactura["DESCUENTO_FACTURA"] .'%</p><p>Total:'. $totalFinal .' </p>';
$html .= '<p style="font-size:10px">Fecha y hora: '. date("Y-m-d H:i:s") .'</p>';
$html .= '<p style="font-size:10px">Concepto: '. $datosFactura['CONCEPTO'] .'</p>';


$pdf->writeHTML($html, true, false, true, false, '');

//Finalmente imprimos el PDF
ob_end_clean();
$pdf->Output('Factura.pdf', 'I');

?>