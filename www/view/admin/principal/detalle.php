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
                <h1 class="page-header">Detalle del movimiento |
                    <a href="<?php url("admin") ?>" class="btn btn-primary"> Volver a Dashboard</a></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- /.row -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Tabla detalle movimiento
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Codígo Categoría</th>
                            <th>Categoría</th>
                            <th>Modelo</th>
                            <th>Cantidad</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($detalles as $detalle) { ?>
                            <tr>
                                <td><?php echo $detalle["codcat"] ?></td>
                                <td><?php echo $detalle["categoria"] ?></td>
                                <td><?php echo $detalle["modelo"] ?></td>
                                <td><?php echo $detalle["cantidad"] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.row -->

        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>