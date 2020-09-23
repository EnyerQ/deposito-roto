<!DOCTYPE html>
<html lang="es">

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
                    <h1 class="page-header">Reporte de movimientos de productos </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <!-- /.row -->
            <div class="panel panel-default">
                <div class="panel-body">

                    <div id="app">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Usuario</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario of usuarios">
                                    <td>{{usuario.nombre}}</td>
                                    <td>{{usuario.usuariod}}</td>
                                    <td>{{usuario.email}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--TERMINO CONTENIDO-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include(VISTA_RUTA."admininclude/scripts.php") ?>

    <script src="/assets/vue/index.js"></script>

</body>

</html>