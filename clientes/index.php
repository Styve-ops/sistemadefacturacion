<?php
include ('../app/config.php');
include ('../layout/sesion.php');

include ('../layout/parte1.php');

include ('../app/controllers/clientes/listado_de_clientes.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <h1 class="m-0">Listado de clientes</h1>
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
                <h3 class="card-title">Clientes Registrados</h3>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                </div>
                
              </div>
              
              <div class="card-body" style="display: block;">
                    <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                            <th><center>Nro</center></th>
                            <th><center>Nombre del cliente</center></th>
                            <th><center>Nit / CC del cliente</center></th>
                            <th><center>Celular del cliente</center></th>
                            <th><center>Email</center></th>
                        </tr>
                  </thead>
                  <tbody>
                  <?php
                            $contador =0;
                                foreach($clientes_datos as $clientes_dato) { 
                                  $id_cliente = $clientes_dato['id_cliente'];
                                  ?>
                                    <tr>
                                        <td><center><?php echo  $contador =  $contador + 1; ?></center></td>
                                        <td><?php echo $clientes_dato['nombre_cliente']; ?></td>
                                        <td><?php echo $clientes_dato['nit_ci_cliente']; ?></td>
                                        <td><center><?php echo $clientes_dato['celular_cliente']; ?></center></td>
                                        <td><center><?php echo $clientes_dato['email_cliente']; ?></center></td>
                                    </tr>
                                <?php 
                                }
                            ?>
                  </tbody>
                  <tfoot>
                  <tr>
                            <th><center>Nro</center></th>
                            <th><center>Nombre del cliente</center></th>
                            <th><center>Nit / CC del cliente</center></th>
                            <th><center>Celular del cliente</center></th>
                            <th><center>Email</center></th>
                        </tr>
                  </tfoot>
                </table>

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
              "info": "Mostrando total de usuarios",
              "infoEmpty": "Mostrando 0 to 0 of 0 Usuarios",
              "infoFiltered": "(Filtrado de MAX total Usuarios)",
              "infoPostFix": "",
              "thousands": ",",
              "lengthMenu": "Mostrar MENU Usuarios",
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