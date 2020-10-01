<!DOCTYPE html>
<html lang="en">

<head>

    <?php include VISTA_RUTA . "admininclude/head.php"?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include VISTA_RUTA . "admininclude/menu.php"?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h3 class="page-header">Equipos no disponibles <?php echo $almacen->nombre; ?></h3>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <!-- /.row -->
            <div class="panel-default">

                <div class="panel-body">
                    <table class="table table-bordered table-condensed table-striped small">
                        <thead>
                            <tr>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Serie</th>
                                <th>Estado</th>
                                <th class="text-center"><i class="fa fa-gear"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($noDisponibles as $key => $noDisponible) {?>
                            <tr>
                                <td><?php echo $noDisponible['categoria']; ?></td>
                                <td><?php echo $noDisponible['marca']; ?></td>
                                <td><?php echo $noDisponible['modelo']; ?></td>
                                <td><?php echo $noDisponible['serie']; ?></td>
                                <td><?php echo $noDisponible['estado']; ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>

            </div>
            <!--TERMINO CONTENIDO-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include VISTA_RUTA . "admininclude/scripts.php"?>
    <script src="<?php asset('js/controladores/PrincipalController.js')?>"></script>

    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

</body>

</html>