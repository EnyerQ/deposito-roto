<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">

<head>

    <?php include VISTA_RUTA . "admininclude/head.php"?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include VISTA_RUTA . "admininclude/menu.php"?>

        <div id="page-wrapper" ng-app="DetalleAPP" ng-controller="DetalleControlador">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo isset($movimiento) ? 'Actualizar' : 'Nuevo' ?> movimiento </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->
            <form action="<?php url("movimiento/registrarMovimiento")?>" id="registrar" method="post" role="form">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <legend>Datos del movimiento</legend>
                        </div>
                        <div class="panel-body">
                            <?php if (isset($movimiento)) {?>
                            <input type="hidden" value="<?php echo $movimiento->id ?>" name="idMovimiento"
                                id="idMovimiento">
                            <?php }?>

                            <input type="hidden" value="<?php url('')?>" id="urlPrincipal">

                            <input type="hidden" value="" id="origen">



                            <div class="col-md-6">
                                <label for="idDeposito">Seleccionar el depósito:</label>
                                <select name="idDeposito" id="idDeposito" class="form-control" ng-model="idDeposito"
                                    ng-change="recargarDetalleMovimiento()" required>
                                    <option value=""></option>
                                    <?php foreach ($depositos as $deposito) {?>
                                    <option value="<?php echo $deposito->id ?>"><?php echo $deposito->nombre ?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="tipoMovimiento">Seleccione el tipo de movimiento:</label>
                                <select name="tipoMovimiento" id="tipoMovimiento" class="form-control"
                                    ng-model="tipoMovimiento" ng-change="recargarDetalleMovimiento()" required>
                                    <option value=""></option>
                                    <?php foreach ($tiposMovimiento as $tipoMovimiento) {?>
                                    <option value="<?php echo $tipoMovimiento->id ?>">
                                        <?php echo $tipoMovimiento->nombre ?></option>
                                    <?php }?>
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
                                            class="btn btn-sm btn-info pull-right" style="display: none">series</button>


                                        <div class="btnMovimientoEntrada" style="display: none">
                                            <button ng-click="cargarDetalle()" type="button" data-toggle="modal"
                                                data-target="#listaProductos" class="btn btn-sm btn-success">Agregar
                                                Producto</button>
                                            <?php if (false) {?>
                                            <button type="button" data-toggle="modal" data-target="#idDetalle"
                                                class="btn btn-sm btn-warning">Detalle X ID</button>
                                            <?php if (isset($entrada)) {?>
                                            <input type="hidden" ng-init="recuperarDetalles()" />
                                            <?php }
}?>
                                        </div>


                                        <div class="btnMovimientoSalida" style="display: none">
                                            <button ng-click="cargarDetalleSalida()" type="button" data-toggle="modal"
                                                data-target="#listaProductosSalida"
                                                class="btn btn-sm btn-success">Agregar Producto</button>
                                            <?php if (isset($salida)) {?>
                                            <input type="HIDDEN" ng-init="recuperarDetalles()">
                                            <?php }?>
                                            <?php if (true) {?>
                                            <?php if ($_SESSION["ADMINISTRADOR"] == true) {?>
                                            <button ng-click="generarCierre()" type="button" style="display: none"
                                                class="btn btn-sm btn-danger" id="btnCierre">
                                                Cargar Cierre</button>
                                            <?php }
}?>
                                        </div>


                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Categoría</th>
                                                    <th>Modelo</th>
                                                    <th>Descripción</th>
                                                    <th>Cantidad</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="pd in detallesAdd">
                                                    <td>{{pd.cate}}</td>
                                                    <td>{{pd.nomcat}}</td>
                                                    <td>{{pd.model}}</td>
                                                    <td>{{pd.cantidad}}</td>
                                                    <td><button ng-click="eliminarProducto(pd)" type="button"
                                                            class="btn btn-sm btn-danger"
                                                            ng-show="pd.seriable == '0'"><i
                                                                class="fa fa-trash-o fa-1x"></i></button>
                                                        <i class="text-success" ng-show="pd.seriable == '1'">Asignado
                                                            por N/S</i></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" id="enviar_f" class="btn btn-primary">
                                    <!--Boton de envío Formulario-->
                                    <?php echo isset($entrada) ? 'Actualizar' : 'Registrar' ?></button>
                            </div>
                            <input type="hidden" value="{{detallesAdd}}" name="detalle" id="detalle">
                            <input type="hidden" value="{{seriesAdd}}" name="serie" id="serie">

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
                            <h4 class="modal-title" id="myModalLabel">Último serie: <b>{{ultimo}}</b> |
                                Cantidad:
                                <b>{{cantidadSeries}}</b></h4>
                        </div>
                        <!-- Modal cuerpo -->
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input ng-model="numSerie" ng-keypress="myFunct($event)" id="nuSerie" type="text"
                                        class="form-control" ng-disabled="habilitar" ng-focus="foco"/>
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

    <?php include VISTA_RUTA . "admininclude/scripts.php"?>
    <script>
    //Seleccionamos el boton de registrar por su id.
    $('#registrar').on('submit', function() {
        //Bloqueamos el bonton para que no pueda volver a enviarse el formulario.
        $('#enviar_f').prop('disabled', true);
    });
    </script>

    <script>
    //Definimos los scripts para recuperar los campos de los movimientos
    function recuperarDescripcion() {
        //Escondemos el formulario si ya existe
        $(".descripcionMovimiento").fadeOut(1000, function() {
            //Hcaemos el llamado ajax a los campos de descripción del movimiento
            $.ajax({
                type: 'GET',
                url: "<?php url('movimiento/descripcionMovimiento')?>",
                data: {
                    'idTipoMovimiento': $("#tipoMovimiento").val(),
                },
                success(respuesta) {
                    //Cargamos la respuesta en el div cofrrespondiente
                    $(".descripcionMovimiento").html(respuesta);
                    //Ocultamos los botones de cargar detalles
                    $(".btnMovimientoEntrada").fadeOut(500);
                    $(".btnMovimientoSalida").fadeOut(500);

                    //Mostramos el contenido de la respuesta.
                    $(".descripcionMovimiento").fadeIn(1000);
                }
            });
        });
    }

    //Verificamos los combos selectores
    function verificarSelectores() {
        //Verificamos el selector de deposito
        if ($("#idDeposito").val() != '') {
            //Verifcamos el selector de tipoMovimiento
            if ($("#tipoMovimiento").val() != '') {
                recuperarDescripcion();
            } else {
                $(".descripcionMovimiento").fadeOut(1000);
                $(".btnMovimientoEntrada").fadeOut(500);
                $(".btnMovimientoSalida").fadeOut(500);
            }
        } else {
            $(".descripcionMovimiento").fadeOut(1000);
            $(".btnMovimientoEntrada").fadeOut(500);
            $(".btnMovimientoSalida").fadeOut(500);

        }
    }

    //Verificamos cambios en los combos selectores
    $("#idDeposito").on('change', function() {
        verificarSelectores();
        $("#btnSeriesCargar").fadeOut(500);
    });

    $("#tipoMovimiento").on('change', function() {
        verificarSelectores();
        $("#btnSeriesCargar").fadeOut(500);
    });

    //Definimos la función de llamado para verificar botones a ser cargado.
    function mostraBotonesCarga() {
        //Verificamos el valor del selector tipo de movimiento
        if ($("#tipoMovimiento").val() == 1 || $("#tipoMovimiento").val() == 2) {
            //Escondemos los botones de salida
            $(".btnMovimientoSalida").fadeOut(500, function() {
                //Mostramos los botones para movimientos de entrada
                $(".btnMovimientoEntrada").fadeIn(500);
            });
        } else if ($("#tipoMovimiento").val() == 3 || $("#tipoMovimiento").val() == 4 ||
            $("#tipoMovimiento").val() == 5) {
            //Escondemos los botones con los movimientos de entrada
            $(".btnMovimientoEntrada").fadeOut(500, function() {
                //Mostramos los botones para movimientos de entrada
                $(".btnMovimientoSalida").fadeIn(500);
                //Verificamos que almacén realiza la salida.
                if ($("#origenMovimiento").val() == 18) {
                    //Si el almacén SCRAP realiza el movimiento, mostramos el boton de cierre.
                    $("#btnCierre").fadeIn(500);
                } else {
                    //En caso contrario ocultamos el boton de cierre.
                    $("#btnCierre").fadeOut(500);
                }

            });

        } else {
            $(".btnMovimientoEntrada").fadeOut(500);
            $(".btnMovimientoSalida").fadeOut(500);
        }

    }

    //Definimos la función para mostrar el boton de cargar series
    function mostrarBtnSeries() {
        //Verificamos que el valor del selector es distinto de vacio
        if ($("#origenMovimiento").val() != '') {
            $("#btnSeriesCargar").fadeIn(500);
            mostraBotonesCarga();
        } else {
            $("#btnSeriesCargar").fadeOut(500);
            $(".btnMovimientoEntrada").fadeOut(500);
            $(".btnMovimientoSalida").fadeOut(500);
        }
    }

    //Ejacutamos la verificación en caso de estar cargando un movimiento existente
    verificarSelectores();
    </script>

</body>

</html>