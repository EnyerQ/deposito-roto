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
                    <h1 class="page-header"><?php echo isset($movimiento) ? 'Actualizar' : 'Nuevo' ?> movimiento </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->
            <form action="<?php url("seguimiento/registrarAlta") ?>" id="registrar" method="post" role="form">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <legend>Datos del movimiento</legend>
                        </div>
                        <div class="panel-body">
                            <?php if (isset($movimiento)) { ?>
                            <input type="hidden" value="<?php echo $movimiento->id ?>" name="idMovimiento"
                                id="idMovimiento">
                            <?php } ?>

                            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">

                            <input type="hidden" value="" id="origen">

                            <input type="hidden" value="" id="idDeposito">
                            <input type="hidden" value="" id="origenMovimiento">
                            <input type="hidden" value="" id="destinoMovimiento">

                            <input type="hidden" value="200" id="tipoMovimiento">
                            <script>
                            cargarProductosSeriables();
                            </script>

                            <div class="col-md-6">
                                <label for="categoria">Seleccionar categoria:</label>
                                <select name="categoria" id="categoria" ng-model="categoria" class="form-control"
                                    required>
                                    <option value=""></option>
                                    <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria->codigo ?>">
                                        <?php echo $categoria->codigo . '|' . $categoria->nombre ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="modelo">Seleccione modelo:</label>
                                <select name="modelo" id="modelo" class="form-control" required>
                                    <option value=""></option>
                                    <option ng-repeat="detalle in detalles | filter: categoria"
                                        ng-if="detalle.seriable == 1" value="{{detalle.id}}">{{detalle.model}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>

                            <div class="descripcionMovimiento" style="display: none"></div>

                            <div class="col-md-12"><br><br>
                                <div class="panel panel-default">
                                    <div class="panel-body">

                                        <button ng-click="verId_Modelo(pd.id,pd.model)" type="button"
                                            data-toggle="modal" data-target="#listarSeries" id="btnSeriesCargar"
                                            class="btn btn-sm btn-info pull-right">series</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" id="enviar_f" class="btn btn-primary">
                                    <!--Boton de envío Formulario-->
                                    <?php echo isset($entrada) ? 'Actualizar' : 'Registrar' ?></button>
                            </div>
                            <input type="hidden" value="{{seriesAdd}}" name="serie">

                        </div>
                    </div>
                </div>
            </form>

            <!-- Modal -->
            <div class="modal fade" id="listaProductosSalida" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="modalEntrada" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Listado de productos</h4>
                        </div>
                        <!-- Modal cuerpo -->
                        <div class="modal-body">
                            <div class="col-md-6">
                                <input type="text" placeholder="Buscar..." class="form-control"
                                    ng-model="buscarProducto">
                            </div>
                            <div class="col-md-6">
                                <input type="text" placeholder="Ingresa la cantidad" class="form-control" id="cantidadP"
                                    ng-model="cantiDAD">
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cod. Categoría</th>
                                        <th>Categoría</th>
                                        <th>Part Number</th>
                                        <th>Modelo</th>
                                        <th>Marca</th>
                                        <th>Disponibles</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="detalle in detalles | filter: buscarProducto"
                                        ng-hide="{{detalle.disponible}}<1" ng-if="detalle.seriable == 0">
                                        <td> {{detalle.cate}} </td>
                                        <td> {{detalle.nomcat}} </td>
                                        <td> {{detalle.part}} </td>
                                        <td> {{detalle.model}} </td>
                                        <td> {{detalle.marc}} </td>
                                        <td> {{detalle.disponible}} </td>
                                        <td><button
                                                ng-click="seleccionarSalidaProducto(detalle.id,detalle.model,detalle.cate,detalle.disponible)"
                                                type="button" class="btn btn-sm btn-default">Agregar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Fin Modal cuerpo -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="listaProductos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="modalEntrada" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Listado de productos</h4>
                        </div>
                        <!-- Modal cuerpo -->
                        <div class="modal-body">
                            <div class="col-md-6">
                                <input type="text" placeholder="Buscar..." class="form-control"
                                    ng-model="buscarProducto">
                            </div>
                            <div class="col-md-6">
                                <input type="text" placeholder="Ingresa la cantidad" class="form-control" id="cantidadP"
                                    ng-model="cantiDAD">
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Cod. Categoría</th>
                                        <th>Categoría</th>
                                        <th>Part Number</th>
                                        <th>Modelo</th>
                                        <th>Marca</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="detalle in detalles | filter: buscarProducto"
                                        ng-if="detalle.seriable == 0">
                                        <td> {{detalle.cate}} </td>
                                        <td> {{detalle.nomcat}} </td>
                                        <td> {{detalle.part}} </td>
                                        <td> {{detalle.model}} </td>
                                        <td> {{detalle.marc}} </td>
                                        <td><button
                                                ng-click="seleccionarProducto(detalle.id,detalle.model,detalle.cate)"
                                                type="button" class="btn btn-sm btn-default">Agregar</button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Fin Modal cuerpo -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="listarSeries" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="modalEntrada" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Ingresar Series de {{ver_modelo}}</h4>
                        </div>
                        <!-- Modal cuerpo -->
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input ng-model="numSerie" ng-keypress="myFunct($event)" id="nuSerie" type="text"
                                        class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <td>Orden</td>
                                        <td>Números de serie</td>
                                        <td>Categoria</td>
                                        <td>Modelo</td>
                                        <td>Estado serie</td>
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="sr in seriesAdd | filter: {id:id_modelo}">
                                        <td>{{$index+1}}</td>
                                        <td>{{sr.series}}</td>
                                        <td>{{sr.categoria}}</td>
                                        <td>{{sr.modelo}}</td>
                                        <td class="{{sr.color}}"><i class="{{sr.icono}}"></i> {{sr.estado}}</td>
                                        <td>
                                            <button type="button" ng-click="editarSerie(sr.series,sr)"
                                                class="btn btn-sm btn-success"><i class="fa fa-pencil"></i>
                                            </button>
                                            <button type="button" ng-click="eliminarSerie(sr)"
                                                class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Fin Modal cuerpo -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info pull-left"
                                ng-click="verificarEstadoSerie()">Verificar</button>
                            <label for="eCaracter">Ingrese caracteres a eliminar: </label>
                            <input ng-model="eCaracter" ng-keypress="myFunct($event)" id="eCaracter" name="eCaracter"
                                type="text" class="form-group" />
                            <button type="button" class="btn btn-danger" ng-click="eliminarCaracter()">Eliminar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--MODAL PARA CARGAR DETALLE SEGÚN UN ID MOVIMIENTO-->

            <div class="modal fade" id="idDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="modalIdDetalles" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Recuperar detalle de un movimiento por su ID</h4>
                        </div>
                        <!-- Modal cuerpo -->
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="idDetalles">Ingresar ID:</label>
                                <input ng-model="idDeta" id="idDetalles" type="text" class="form-control" />
                            </div>

                        </div>
                        <!-- Fin Modal cuerpo -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" ng-click="recuperarDetallesId()"
                                data-dismiss="modal">Cargar</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
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