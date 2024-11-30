<?php
//a.id_producto as id_producto, a.codigo as codigo, a.nombre as nombre, a.descripcion as descripcion, a.stock as stock,a.stock_minimo as stock_minimo, a.stock_maximo as stock_maximo, a.precio_compra as precio_compra, a.precio_venta as precio_venta,a.fecha_ingreso as fecha_ingreso, a.imagen as imagen
$sql_ventas = "SELECT *, cli.nombre_cliente as nombre_cliente 
FROM tb_ventas as ve INNER JOIN tb_clientes as cli ON cli.id_cliente = ve.id_cliente WHERE ve.id_venta = '$id_venta_get' ";
$query_ventas = $pdo->prepare($sql_ventas);
$query_ventas->execute() ;
$ventas_datos = $query_ventas->fetchAll(fetch_style: PDO::FETCH_ASSOC) ;

foreach($ventas_datos as $ventas_dato) {
    $nro_venta = $ventas_dato['nro_venta'];
    $id_cliente = $ventas_dato['id_cliente'];
}