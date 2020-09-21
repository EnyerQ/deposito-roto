<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA . "admininclude/head.php") ?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include(VISTA_RUTA . "admininclude/menu.php") ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Listado de entradas |
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tabla de movimientos de entrada
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover small"
                            id="tabla_filtro">
                            <thead>
                                <tr>
                                    <th>Remito</th>
                                    <th>Fecha</th>
                                    <th>Origen</th>
                                    <th>Destino</th>
                                    <th>Proviene de</th>
                                    <th>Sub_Estado</th>
                                    <th>Ticket</th>
                                    <th>opc</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($entradas as $entrada) { ?>
                                <tr class="odd gradeX">
                                    <td class="col-lg-3"><?php echo $entrada['remito'] ?></td>
                                    <td><?php echo $entrada['fecha'] ?></td>
                                    <td><?php echo $entrada['origen'] ?></td>
                                    <td><?php echo $entrada['destino'] ?></td>
                                    <td><?php echo $entrada['interviene'] ?></td>
                                    <td><?php echo $entrada['sub'] ?></td>
                                    <td><?php echo $entrada['ticket'] ?></td>
                                    <td class="btn-group col-lg-1">
                                        <a href="<?php url('entrada/informe/' . $entrada['id']) ?>"
                                            class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger btn-sm" onclick="confirma('<?php url('entrada/eliminar/' . $entrada['id']) ?>',
                                                    '<?php echo "la entrada " . $entrada['remito'] ?>')"><i
                                                class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php } ?>
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

    <?php include(VISTA_RUTA . "admininclude/scripts.php") ?>


    <script>

    </script>

</body>

</html>