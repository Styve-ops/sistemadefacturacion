<?php
$id_venta_get = $_GET['id_venta'];
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');
include ('../app/controllers/ventas/cargar_venta.php');
include ('../app/controllers/clientes/cargar_cliente.php');
include ('../app/controllers/clientes/listado_de_clientes.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0"> Detalle de la venta nro <?= $nro_venta; ?></h1>
          </div><!-- /.col -->
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">

                      <div class="row">
                         <div class="col-md-12">
                                    <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fa fa-shopping-bag"></i> Venta Nro 
                                                <input type="text" value="<?php echo $nro_venta; ?>" disabled></h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                        <table  class="table table-bordered table-sm table-hover table-striped ">
                                                                <thead>
                                                                    <tr>
                                                                    <th style="background-color: #e7e7e7;text-align:center">Nro</th>
                                                                    <th style="background-color: #e7e7e7;text-align:center">Producto</th>
                                                                    <th style="background-color: #e7e7e7;text-align:center">Descripcion</th>
                                                                    <th style="background-color: #e7e7e7;text-align:center">Cantidad</th>
                                                                    <th style="background-color: #e7e7e7;text-align:center">Precio Unitario</th>
                                                                    <th style="background-color: #e7e7e7;text-align:center">Precio Subtotal</th>
                                                                   
                                                                    </tr>
                                                                </thead>
                                                                    <tbody>
                                                                           <?php
                                                                           $contador_de_carrito = 0;
                                                                           $cantidad_total = 0;
                                                                           $precio_unitario_total = 0;
                                                                           $precio_total = 0;
                                                                           
                                                                           $sql_carrito = "SELECT *, pro.nombre as nombre_producto, pro.descripcion as descripcion, pro.precio_venta as precio_venta, pro.stock as stock, pro.id_producto as id_producto FROM tb_carrito AS carr INNER JOIN tb_almacen as pro ON carr.id_producto = pro.id_producto WHERE nro_venta = '$nro_venta' ORDER BY id_carrito ASC ";
                                                                           $query_carrito = $pdo->prepare($sql_carrito);
                                                                           $query_carrito->execute() ;
                                                                           $carrito_datos = $query_carrito->fetchAll(fetch_style: PDO::FETCH_ASSOC) ;
                                                                           foreach ($carrito_datos as $carrito_dato){
                                                                            $id_carrito = $carrito_dato['id_carrito'];
                                                                            $contador_de_carrito = $contador_de_carrito +1; 
                                                                            $cantidad_total = $cantidad_total + $carrito_dato['cantidad'];
                                                                            $precio_unitario_total = $precio_unitario_total + floatval($carrito_dato['precio_venta']);
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <center><?php echo $contador_de_carrito; ?></center>
                                                                                    <input type="text" value="<?php echo $carrito_dato['id_producto']; ?>" id="id_producto<?php echo $contador_de_carrito?>" hidden>
                                                                                </td>
                                                                                <td><?php echo $carrito_dato['nombre_producto']; ?></td>
                                                                                <td><?php echo $carrito_dato['descripcion']; ?></td>
                                                                                <td>
                                                                                    <center><span id="cantidad_carrito<?php echo $contador_de_carrito; ?>"><?php echo $carrito_dato['cantidad']; ?></span></center>
                                                                                    <input type="text" value="<?php echo $carrito_dato['stock']; ?>" id="stock_de_inventario<?php echo $contador_de_carrito; ?>" hidden>
                                                                                </td>
                                                                                <td><center><?php echo $carrito_dato['precio_venta']; ?></center></td>
                                                                                <td>
                                                                                    <center>
                                                                                        <?php
                                                                                            $cantidad = floatval($carrito_dato['cantidad']);
                                                                                            $precio_venta = floatval($carrito_dato['precio_venta']);
                                                                                           echo $subtotal = $cantidad * $precio_venta;
                                                                                           $precio_total = $precio_total + $subtotal;
                                                                                        ?>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                           <?php
                                                                           }
                                                                           ?> 
                                                                            <tr>
                                                                                <th colspan="3">Total</th>
                                                                                <th><center><?php echo  $cantidad_total; ?></center></th>
                                                                                <th><center><?php echo $precio_unitario_total; ?></center></th>
                                                                                <th><center><?php echo $precio_total; ?></center></th>
                                                                            </tr>
                                                                    </tbody>
                                                        </table>
                                                </div>
                                            </div>

                                                
                                    </div>
                               </div>
                        </div>

                        <div class="row">
                         <div class="col-md-9">
                                    <div class="card card-primary">
                                            <div class="card-header">
                                                <h3 class="card-title"><i class="fa fa-user-check"></i> Datos del cliente </h3>
                                                <div class="card-tools">
                                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                             <?php 
                                             foreach($clientes_datos as $clientes_dato){
                                                $nombre_cliente = $clientes_dato['nombre_cliente'];
                                                $nit_ci_cliente = $clientes_dato['nit_ci_cliente'];
                                                $celular_cliente = $clientes_dato['celular_cliente'];
                                                $email_cliente = $clientes_dato['email_cliente'];
                                             }
                                             ?>
                                            <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <input type="text" id="id_cliente" hidden>
                                                                <label for="">Nombre del cliente</label>
                                                                <input type="text" value="<?= $nombre_cliente; ?>" class="form-control" id="nombre_cliente" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">Nit / CC</label>
                                                                <input type="text" value="<?= $nit_ci_cliente; ?>" class="form-control" id="nit_ci_cliente" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">Celular del cliente</label>
                                                                <input type="text" value="<?= $celular_cliente; ?>" class="form-control" id="celular_cliente" disabled>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="">Email</label>
                                                                <input type="text" value="<?= $email_cliente; ?>" class="form-control" id="email_cliente" disabled>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                            </div>

                                    </div>
                               </div>
                                <div class="col-md-3">
                                    <div class="card card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title"><i class="fa fa-shopping-basket"></i> Registrar venta</h3>
                                            <div class="card-tools">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                                <div class="form-group">
                                                    <label for="">Monto a cancelar</label>
                                                    <input type="text" id="total_a_cancelar" class="form-control" style="text-align: center; " 
                                                    value="<?php echo $precio_total; ?>" disabled>
                                                    
                                                </div>     
                                        </div>
                                    </div>
                                </div>
                 </div>
                        
          <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
   
  <?php include ('../layout/mensajes.php');?>
<?php include ('../layout/parte2.php');?>

<script>
  $(function () {
    $("#example1").DataTable({
      "pageLength": 5,
          language: {
              "emptyTable": "No hay información",
              "info": "Mostrando total de productos",
              "infoEmpty": "Mostrando 0 to 0 of 0 productos",
              "infoFiltered": "(Filtrado de MAX total productos)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar MENU productos",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscador:",
              "zeroRecords": "Sin resultados encontrados",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              }
             },
      "responsive": true, "lengthChange": true, "autoWidth": false,
      
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

  $(function () {
    $("#example2").DataTable({
      "pageLength": 5,
          language: {
              "emptyTable": "No hay información",
              "info": "Mostrando total de clientes",
              "infoEmpty": "Mostrando 0 to 0 of 0 clientes",
              "infoFiltered": "(Filtrado de MAX total clientes)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar MENU clientes",
              "loadingRecords": "Cargando...",
              "processing": "Procesando...",
              "search": "Buscador:",
              "zeroRecords": "Sin resultados encontrados",
              "paginate": {
                  "first": "Primero",
                  "last": "Ultimo",
                  "next": "Siguiente",
                  "previous": "Anterior"
              }
             },
      "responsive": true, "lengthChange": true, "autoWidth": false,
      
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });

</script>

<!-- modal para visualar el formulario para agregar daclientes -->
<div class="modal fade" id="modal-agregar_cliente">
            <div class="modal-dialog modal-sm">
               <div class="modal-content">
                    <div class="modal-header" style="background-color: #b6900c ;color: white" >
                        <h4 class="modal-title">Nuevo cliente </h4>
                        <div style="width: 10px;"></div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                                      </div>                                                      
                                      <div class="modal-body">
                                            <form action="../app/controllers/clientes/guardar_clientes.php" method="post">
                                                    <div class="form-group">
                                                        <label for="">Nombre del cliente</label>
                                                        <input type="text" name="nombre_cliente" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Nit/CC del cliente</label>
                                                        <input type="number" name="nit_ci_cliente" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Celular del cliente</label>
                                                        <input type="number" name="celular_cliente" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Email del cliente</label>
                                                        <input type="email" name="email_cliente" class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-warning btn-block">Guardar nuevo cliente</button>
                                                    </div>
                                            </form>
                                            
                                     </div>          
        </div>
        <!-- /.modal-content -->
     </div>
    <!-- /.modal-dialog -->
 </div>
 <!-- /.modal -->