<?php

include ('../../config.php');


$id_producto = $_POST['id_producto'] ;
$sentencia = $pdo->prepare("DELETE FROM tb_almacen WHERE id_producto = :id_producto");
 $sentencia->bindParam('id_producto' , $id_producto);
 
 if($sentencia->execute()){
    session_start();
   $_SESSION['mensaje'] = "Se elimino al producto de la manera correcta";
   $_SESSION['icono'] = "success";
   header('location: ' .$URL.'almacen/');
   exit();

 }else{
    session_start();
   $_SESSION['mensaje'] = "Error no se pudo eliminar al producto de la manera correcta";
   $_SESSION['icono'] = "error";
   header('location: ' .$URL.'almacen/delete.php?id='.$id_producto);
   exit();
 }