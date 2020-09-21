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
                    <h1 class="page-header">Seguimiento y trazabilidad del número de serie |
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Tabla de trazabilidad</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover small" id="tabla_filtro">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>S/N</th>
                                <th>Cod. Categoria</th>
                                <th>Descripción</th>
                                <th>Deposito</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Ticket</th>
                                <?php if ($_SESSION["OPERADOR"] == true) {?>
                                <th>Opciones</th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($trazas as $traza) {?>
                            <tr <?php if ($traza['tipo'] == 'salida') {
    $class = 'danger';
} elseif ($traza['tipo'] == 'entrada') {
    $class = 'success';
} else {
    $class = 'info';
}?> class="<?php echo $class ?>">
                                <td><?php echo $traza['fecha'] ?></td>
                                <td><?php echo $traza['serie'] ?></td>
                                <td><?php echo $traza['cate'] ?></td>
                                <td><?php echo $traza['catnom'] ?></td>
                                <td><?php echo $traza['deposito'] ?></td>
                                <td><?php echo $traza['origen'] ?></td>
                                <td><?php echo $traza['destino'] ?></td>
                                <td><?php echo $traza['ticket'] ?></td>
                                <?php if ($_SESSION["OPERADOR"] == true) {?>
                                <td><a class="btn btn-sm btn-success"
                                        href="<?php url('/' . $traza['tipo'] . '/informe/' . $traza['id_mov'])?>">
                                        <i class="fa fa-search"></i> </a> </td>
                                <?php }?>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!--Informe del número de serie-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3>Datos del número de serie</h3>
                </div>
                <div class="panel-body">
                    <?php if (count($detalles) > 0) {?>
                    <table class="table table-hover" id="tabla">
                        <thead>
                            <tr>
                                <th>Descripción</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalles as $detalle) {?>
                            <tr>
                                <td>Número de serie:</td>
                                <td><?php echo $detalle['serie'] ?>
                                    <?php if (isset($_SESSION['OPERADOR']) && $_SESSION['OPERADOR'] == true) {?><i
                                        class="fa fa-pencil text-primary" style="cursor: pointer" data-toggle="modal"
                                        data-target="#modalSerie"></i>
                                    <?php }?></td>
                            </tr>
                            <tr>
                                <td>Codigo Categoria:</td>
                                <td><?php echo $detalle['cate'] ?></td>
                            </tr>
                            <tr>
                                <td>Descripción Categoria:</td>
                                <td><?php echo $detalle['catnom'] ?></td>
                            </tr>
                            <tr>
                                <td>Marca:</td>
                                <td><?php echo $detalle['marca'] ?></td>
                            </tr>
                            <tr>
                                <td>Modelo Producto:</td>
                                <td><?php echo $detalle['modelo'] ?></td>
                            </tr>
                            <tr>
                                <td>Fecha del Alta:</td>
                                <td><?php echo $detalle['alta'] ?></td>
                            </tr>
                            <tr>
                                <td>Ultima fecha de actualización:</td>
                                <td><?php echo $detalle['ultima'] ?></td>
                            </tr>
                            <tr>
                                <td>Deposito:</td>
                                <td><?php echo $detalle['deposito'] ?></td>
                            </tr>
                            <tr>
                                <td>Almacenado en:</td>
                                <td><?php echo $detalle['almacenado'] ?></td>
                            </tr>
                            <tr>
                                <td>Estado del equipo:</td>
                                <td><?php echo $detalle['estado'] ?></td>
                            </tr>
                            <?php }?>
                        </tbody>
                    </table>

                    <!-- Modal -->
                    <div id="modalSerie" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Modificar el número de serie</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="cambiarSerie">Cambiar valor del serie:</label>
                                        <input type="text" value="<?php echo $detalle['serie'] ?>" class="form-control"
                                            id="cambiarSerie" name="cambiarSerie">
                                        <input type="hidden" name="cambiarSerieId" id="cambiarSerieId"
                                            value="<?php echo $detalle['id'] ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success"
                                        id="btnModificarSerie">Guardar</button>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php } else {
    echo "No hay datos al respecto...";
}?>
                </div>
            </div>



            <!--TERMINO CONTENIDO-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include VISTA_RUTA . "admininclude/scripts.php"?>

    <script>
    //Definimos la función que nos permite editar el número de serie.
    function cambiarNumeroSerie() {
        //Hacemos el llamado ajax
        $.ajax({
            type: 'GET',
            url: "<?php url('seguimiento/modificar')?>",
            data: {
                "cambiarSerie": $("#cambiarSerie").val(),
                "cambiarSerieId": $("#cambiarSerieId").val()
            },
            success(respuesta) {
                //Verificamos si la respuesta es correcta
                if (respuesta == 'CORRECTO') {
                    alert('El cambio se realizo correctamente');
                    location.href = "<?php url('seguimiento/trazar/')?>?buscarSerie=" + $("#cambiarSerie")
                        .val();
                } else {
                    if (respuesta == 'SESSION') {
                        alert('Debe iniciar una nueva sessión');
                    } else {
                        if (respuesta == 'EXISTE') {
                            alert('El serie que intente ingresar ya existe');
                        } else {
                            if (respuesta == 'IGUAL') {
                                alert('El valor que intenta cambiar es el mismo');
                            } else {
                                alert('Tenemos un problema al registrar el cambio');
                            }
                        }
                    }
                }

            }
        });
    }

    //Comprobamos el click sobre el boton de guardar
    $("#btnModificarSerie").on('click', function() {
        cambiarNumeroSerie();
    });
    </script>

</body>

</html>