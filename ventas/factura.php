<?php

// Include the main TCPDF library (search for installation path).
require_once('../app/TCPDF-main/tcpdf.php');
include('../app/config.php');
include('../app/controllers/ventas/literal.php');

session_start();
if(isset($_SESSION['sesion_email'])){
  //echo "si existe sesion de ".$_SESSION['sesion_email'];
  $email_sesion = $_SESSION['sesion_email'] ;
$sql = "SELECT us.id_usuario as id_usuario,us.nombres as nombres,us.email as email, rol.rol as rol 
FROM tb_usuarios as us INNER JOIN tb_roles as rol ON us.id_rol = rol.id_rol WHERE email ='$email_sesion'";
$query = $pdo->prepare($sql);
$query->execute() ;
$usuarios = $query->fetchAll(fetch_style: PDO::FETCH_ASSOC) ;

foreach($usuarios as $usuario){
    $id_usuario_sesion = $usuario['id_usuario'];
    $nombres_sesion = $usuario['nombres'];
    $rol_sesion = $usuario['rol'];
}
}else{
  echo "no existe sesion";
  header('location: ' .$URL. '/login');
  exit();
}


$id_venta_get = $_GET['id_venta'];
$nro_venta_get = $_GET['nro_venta'];

$sql_ventas = "SELECT *, cli.nombre_cliente as nombre_cliente, cli.nit_ci_cliente as nit_ci_cliente, cli.email_cliente as email_cliente, cli.celular_cliente as celular_cliente
FROM tb_ventas as ve INNER JOIN tb_clientes as cli ON cli.id_cliente = ve.id_cliente WHERE ve.id_venta = '$id_venta_get' ";
$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute() ;
$ventas_datos = $query_ventas->fetchAll(fetch_style: PDO::FETCH_ASSOC) ;

foreach($ventas_datos as $ventas_dato) {
    $fyh_creacion =  $ventas_dato['fyh_creacion'];
    $nit_ci_cliente =  $ventas_dato['nit_ci_cliente'];
    $nombre_cliente =  $ventas_dato['nombre_cliente'];
    $email_cliente =  $ventas_dato['email_cliente'];
    $celular_cliente =  $ventas_dato['celular_cliente'];
    $total_pagado =  $ventas_dato['total_pagado'];
}
//convierte precio total a literal
$monto_literal = numtoletras($total_pagado);
 

$fecha = date("d/m/y",strtotime($fyh_creacion));
   
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, array(210,275), true, 'UTF-8', false);

// set document information
$pdf->setCreator(PDF_CREATOR);
$pdf->setAuthor('SIS FACTURA');
$pdf->setTitle('SIS FACTURA');
$pdf->setSubject('SIS FACTURA');
$pdf->setKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->setMargins(15, 15, 15);

// set auto page breaks
$pdf->setAutoPageBreak(true, 5);


// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->setFont('Helvetica', '', 9);

// add a page
$pdf->AddPage();




// create some HTML content
//estamos dentro de un pdf no se puede usar boostrat
$html = '
<table border="0">
<tr>
<td style="text-align: center; width:250px" >
<b>SISTEMA DE FACTURACION STYVEN WEB</b><br>
<b>NIT 830.048.145-8</b><br>
<b>CARRERA 10 No.85-20</b><br>
<b>Tel:3043377283</b><br>
<b>Bucaramanga-Colombia</b><br>
<b>sisfacturas@gmail.com</b>
</td>
<td style="width:170px"></td>
<td style="font-size: 16px;width:270px ">
<b>FACTURA DE VENTA</b><br>
<b>No.</b>STEP- '.$id_venta_get.'
<p style="text-align: center"><b>ORIGINAL</b></p>
</td>
</tr>
</table>
<p style="text-align: center;font-size:25px"><b></b>FACTURA</p>
<br><br>
<div style="border: 1px solid #000000">
    <table border="0" cellspacing="5" style="font-size:12px">
       <tr>
           <td >
           <b>Nombre del cliente:<br></b>'. $nombre_cliente.'<br><br>
           <b>Nit/CC:</b><br> '. $nit_ci_cliente.'     
           </td>
           <td>
            <b>Email:</b><br> '. $email_cliente.' <br><br>
           <b>Telefono:</b><br> '. $celular_cliente.'
           </td>
           <td> 
           <b>Ciudad:</b><br> Bucaramanga-Colombia<br>
           <br>
           </td>
       </tr>
       <tr>
       <td ><b>Fecha de generacion:</b><br> '. $fecha.'</td>
       <td > <b>Fecha de expedicion:</b><br> '. $fecha.' </td>
       <td ><b>Fecha de vencimiento:</b><br> '. $fecha.'</td>
       </tr>
    </table>
    
</div>
<br><br>
<table border="1" cellpadding="5" style="font-size:12px">
    <tr style="text-align: center;background-color:#d6d6d6">
        <th style="width: 40px"><b>Nro</b></th>
        <th style="width: 140px"><b>Producto</b></th>
        <th style="width: 225px"><b>Descripcion</b></th>
        <th style="width: 63px"><b>Cantidad</b></th>
        <th style="width: 100px"><b>Precio unitario</b></th>
        <th style="width: 70px"><b>Subtotal</b></th> 
    </tr>
    ';
    $contador_de_carrito = 0;
    $cantidad_total = 0;
    $precio_unitario_total = 0;
    $precio_total = 0;

    $sql_carrito = "SELECT *, pro.nombre as nombre_producto, pro.descripcion as descripcion, pro.precio_venta as precio_venta, pro.stock as stock, pro.id_producto as id_producto 
    FROM tb_carrito AS carr INNER JOIN tb_almacen as pro ON carr.id_producto = pro.id_producto 
    WHERE nro_venta = '$nro_venta_get' ORDER BY id_carrito ASC ";
    $query_carrito = $pdo->prepare($sql_carrito);
    $query_carrito->execute() ;
    $carrito_datos = $query_carrito->fetchAll(fetch_style: PDO::FETCH_ASSOC) ;
    foreach ($carrito_datos as $carrito_dato){
     $id_carrito = $carrito_dato['id_carrito'];
     $contador_de_carrito = $contador_de_carrito +1; 
     $cantidad_total = $cantidad_total + $carrito_dato['cantidad'];
     $precio_unitario_total = $precio_unitario_total + floatval($carrito_dato['precio_venta']);
     $subtotal = $carrito_dato['cantidad'] * $carrito_dato['precio_venta'];
     $precio_total = $precio_total + $subtotal;
     
     $html .='
     <tr>
       <td style="text-align: center"><b>'.$contador_de_carrito.'</b></td>
       <td ><b>'.$carrito_dato['nombre_producto'].'</b></td>
       <td ><b>'.$carrito_dato['descripcion'].'</b></td>
       <td style="text-align: center"><b>'.$carrito_dato['cantidad'].'</b></td>
       <td style="text-align: center"><b>'.$carrito_dato['precio_venta'].'</b></td>
       <td style="text-align: center"><b>'. $subtotal .'</b></td>
    </tr>
     ';
    }

    $html .='
    <tr style="background-color:#d6d6d6">
       <td colspan="3" style="text-align: right"><b>Total</b></td>
       <td style="text-align: center"><b>'.$cantidad_total.'</b></td>
       <td style="text-align: center"><b>COP. '.$precio_unitario_total.'</b></td>
       <td style="text-align: center"><b>COP. '.$precio_total.'</b></td>
    </tr>
</table>

<p style="text-align: right">
         <b>Monto Total: </b>COP. '.$precio_total.'
        </p>
        <p>
            <b>Son: </b>'.$monto_literal.'
        </p>
        <br>
         -------------------------------------------------------------------------------- <br>
         <b>USUARIO:</b>'.$nombres_sesion.' <br><br><br><br><br><br><br><br>
         
        <p style="text-align: center">
        </p>
        <p style="text-align: center">"A esta factura de venta aplican las normas relativas a la letra de cambio (articulo 5 ley 1231 de 2008).Con esta el comprador declara haber recibido real y materialmente las mercancias o 
                                          prestacion de servicios descritos en este titulo-Valor Númeo Autorizacion 18760000001 aprobando en 20190101 prefijo SETP desde el numero 99000000 al 995000000 Vigencia: 134 
                                                                                         Meses
                                          No responsables de IVA-Actividad Economica 4632 Comercio al por mayor de bebidas y tabaco Tarifa
                                                          Responsables del impuesto sobre las ventas-IVA
                                                 CUFE:7E7CD6395T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9T9"
        </p>
        <p style="text-align: center"><b>GRACIAS POR SU PREFERENCIA</b></p>
        
        </div>
    </p>
';


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');



$style = array(
    'border' => 0,
    'vpadding' => '3',
    'hpadding' => '3',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255)
    'module_width' => 1, // width of a single module in points
    'module_height' => 1 // height of a single module in points
);

$QR = 'Factura realizada por el sistema de facturacion, al cliente '.$nombre_cliente.' con nit/cc: '.$nit_ci_cliente.' 
en la fecha: '.$fecha.' con el monto total: '.$precio_total.'';
$pdf->write2DBarcode($QR,'QRCODE,L',  170,240,40,40, $style);




//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+