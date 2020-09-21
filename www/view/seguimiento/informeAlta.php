<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">

<head>

    <?php include(VISTA_RUTA . "admininclude/head.php") ?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include(VISTA_RUTA . "admininclude/menu.php") ?>

        <div id="page-wrapper" ng-app="DetalleAPP" ng-controller="DetalleControlador">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Informe de alta de series </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th>CATEGORIA</th>
                                <th>MODELO</th>
                                <th>CANTIDAD</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td><?php echo $categoria ?></td>
                                <td><?php echo $modelo ?></td>
                                <td><?php echo $contador ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--TERMINO CONTENIDO-->


        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include(VISTA_RUTA . "admininclude/scripts.php") ?>
    <script>
    //Seleccionamos el boton de registrar por su id.
    $('#registrar').on('submit', function() {
        //Bloqueamos el bonton para que no pueda volver a enviarse el formulario.
        $('#enviar_f').prop('disabled', true);
    });
    </script>

    <script>
    </script>

</body>

</html>