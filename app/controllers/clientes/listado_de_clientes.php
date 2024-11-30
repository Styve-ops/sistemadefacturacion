<?php
$sql_clientes = "SELECT * FROM tb_clientes";
$query_clientes = $pdo->prepare($sql_clientes);
$query_clientes->execute() ;
$clientes_datos = $query_clientes->fetchAll(fetch_style: PDO::FETCH_ASSOC) ;