<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Listado de registros pendientes |
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tabla de registros pendientes
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover small" id="tabla_filtro">
                        <thead>
                        <tr>
                            <th>Tipo_Mov</th>
                            <th>Remito</th>
                            <th>Fecha</th>
                            <th>Deposito</th>
                            <th>Origen</th>
                            <th>Destino</th>
                            <th>Sub_Estado</th>
                            <th>Ticket</th>
                            <th>opc</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($movimientos as $movimiento){ ?>
                            <tr class="odd gradeX">
                                <td><?php echo $movimiento['tipo'] ?></td>
                                <td><?php echo $movimiento['remito'] ?></td>
                                <td><?php echo $movimiento['fecha'] ?></td>
                                <td><?php echo $movimiento['deposito'] ?></td>
                                <td><?php echo $movimiento['origen'] ?></td>
                                <td><?php echo $movimiento['destino'] ?></td>
                                <td><?php echo $movimiento['sub'] ?></td>
                                <td><?php echo $movimiento['ticket'] ?></td>
                                <td>
                                    <a href="<?php url($movimiento['tipo'].'/informe/'.$movimiento['id']) ?>"
                                       class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>


<script>

</script>

</body>

</html>