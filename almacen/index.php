<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/almacen/listado_de_productos.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de productos</h1>
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
                <h3 class="card-title">Productos registrados</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                
              </div>
              
              <div class="card-body" style="display: block;">
                    <div class="table table-responsive">
                    <table id="example1" class="table table-bordered table-striped table-sm">
                  <thead>
                  <tr>

                            <th><center>Nro</center></th>
                            <th><center>Código</center></th>
                            <th><center>Categoria</center></th>
                            <th><center>Imagen</center></th>
                            <th><center>Nombre</center></th>
                            <th><center>Descripcion</center></th>
                            <th><center>Stock</center></th>
                            
                            <th><center>Precio compra</center></th>
                            <th><center>Precio venta</center></th>
                            <th><center>Fecha compra</center></th>
                            <th><center>Usuario</center></th>
                            <th><center>Acciones</center></th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php
                            $contador =0 ;
                                foreach($productos_datos as $productos_dato) { 
                                  $id_producto = $productos_dato['id_producto']; ?>
                               
                                    <tr>
                                        <td><?php echo $contador = $contador + 1; ?></td>
                                        <td><?php echo $productos_dato['codigo']; ?></td>
                                        <td><?php echo $productos_dato['categoria']; ?></td>
                                        <td>
                                            <img src="<?php echo $URL."almacen/img_productos/".$productos_dato['imagen']; ?>" width="50px" alt="asdf">
                                        </td>
                                        <td><?php echo $productos_dato['nombre']; ?></td>
                                        <td><?php echo $productos_dato['descripcion']; ?></td>
                                        <td><?php echo $productos_dato['stock']; ?></td>
                                        
                                        <td><?php echo $productos_dato['precio_compra']; ?></td>
                                        <td><?php echo $productos_dato['precio_venta']; ?></td>
                                        <td><?php echo $productos_dato['fecha_ingreso']; ?></td>
                                        <td><?php echo $productos_dato['email']; ?></td>
                                        <td>
                                        <div class="btn-group">
                                            <a href="show.php?id=<?php echo $id_producto; ?>" type="button" class="btn btn-info btn-sm"><i class="fa fa-eye"></i>Ver</a>
                                            <a href="update.php?id=<?php echo $id_producto; ?>" type="button" class="btn btn-success btn-sm"><i class="fa fa-pencil-alt"></i>editar</a>
                                            <a href="delete.php?id=<?php echo $id_producto; ?>" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Borrar</a>
                                          </div>
                                        </td>
                                    </tr>
                                    
                                <?php 
                                }
                            ?>
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
                </table>
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


  <?php include ('../layout/mensajes.php') ; ?>
<?php include ('../layout/parte2.php') ; ?>

<script>
  $(function () {
    $("#example1").DataTable({
      "pageLength": 10,
          language: {
              "emptyTable": "No hay información",
              "decimal": "",
              "info": "Mostrando total de roles",
              "infoEmpty": "Mostrando 0 to 0 of 0 Roles",
              "infoFiltered": "(Filtrado de MAX total Roles)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar MENU Roles",
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
      /* fin de idiomas */

      "responsive": true, "lengthChange": false, "autoWidth": false,
      buttons: [{
                        extend: 'collection',
                        text: 'Reportes',
                        orientation: 'landscape',
                        buttons: [{
                            text: 'Copiar',
                            extend: 'copy'
                        }, {
                            extend: 'pdf',
                        }, {
                            extend: 'csv',
                        }, {
                            extend: 'excel',
                        }, {
                            text: 'Imprimir',
                            extend: 'print'
                        }
                        ]
                    },
                        {
                            extend: 'colvis',
                            text: 'Visol de columnas'
                        }
                    ],
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    
  });
</script>
