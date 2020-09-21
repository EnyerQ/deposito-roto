<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

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
                    <h1 class="page-header"><?php echo isset($salida) ? 'Actualizar' : 'Nueva' ?> salida |
                        <a href="<?php url("salida/index") ?>" class="btn btn-default">
                            <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->
            <form action="<?php url("salida/agregar") ?>" id="registrar" method="post" role="form">
                <div class="row">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <legend>Datos de la salida</legend>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <?php if (isset($salida)) { ?>
                                <input type="hidden" value="<?php echo $salida->id ?>" name="salida_id"
                                    id="movimiento_id">
                                <?php } ?>
                                <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
                                <input type="hidden"
                                    value="<?php echo isset($salida) ? $salida->interviene : $_SESSION['origen'] ?>"
                                    name="interviene">

                                <div class="form-group">
                                    <label for="remito">Remito o referencía</label>
                                    <input value="<?php echo isset($salida) ? $salida->remito : '' ?>" autofocus
                                        type="text" class="form-control" name="remito" id="remito"
                                        placeholder="Número de remito" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="fecha">Fecha</label>

                                    <input class="form-control" id="fecha" name="fecha" type="date"
                                        value="<?php echo isset($salida) ? $salida->fecha : date("Y-m-d") ?>">
                                </div>

                                <div class="form-group">
                                    <label for="origen">Almacén</label>

                                    <select name="origen" id="origen" class="form-control" required="required">
                                        <option value=""></option>
                                        <?php
                                        $est = new libreria\ORM\EtORM();
                                        $estado = $est->ejecutar("sp_estado_stock", array($_SESSION['cliente']));
                                        foreach ($estado as $estados) { ?>
                                        <option <?php echo isset($salida) && $salida->id_origen == $estados['id']
                                                        ? 'selected' : '' ?> value="<?php echo $estados['id'] ?>">
                                            <?php echo ($estados['nombre']); ?>
                                        </option><?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="destino">Destino</label>

                                    <select name="destino" id="destino" class="form-control" required="required">
                                        <option value=""></option>
                                        <?php
                                        if (isset($salida)) {
                                            $tipo = $salida->interviene;
                                        } else {
                                            if (isset($_SESSION['origen'])) {
                                                $tipo = $_SESSION['origen'];
                                                unset($_SESSION['origen']);
                                            }
                                        }
                                        $pro = new libreria\ORM\EtORM();
                                        $prove = $pro->ejecutar("sp_entrada_origen", array($_SESSION['cliente'], $tipo));
                                        foreach ($prove as $provedor) { ?>
                                        <option <?php echo isset($salida) && $salida->id_destino == $provedor['id']
                                                        ? 'selected' : '' ?> value="<?php echo $provedor['id'] ?>">
                                            <?php echo ($provedor['nombre']); ?>
                                        </option><?php } ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="sub_estado">Estado equipos</label>

                                    <select name="sub_estado" id="sub_estado" class="form-control" required="required">
                                        <option value=""></option>
                                        <?php
                                        $sub_est = new libreria\ORM\EtORM();
                                        $sub_estado = $sub_est->ejecutar("sp_estado_movimiento", array($_SESSION['cliente']));
                                        foreach ($sub_estado as $sub_estados) { ?>
                                        <option <?php echo isset($salida) && $salida->id_sub_estado == $sub_estados['id']
                                                        ? 'selected' : '' ?> value="<?php echo $sub_estados['id'] ?>">
                                            <?php echo ($sub_estados['nombre']); ?>
                                        </option><?php } ?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="observacion">Observación</label>
                                    <input value="<?php echo isset($salida) ? $salida->observacion : '' ?>" type="text"
                                        class="form-control" name="observacion" id="observacion" autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="comentario">Comentarios:</label>
                                    <textarea class="form-control" rows="5" name="comentario" id="comentario"
                                        placeholder="En caso de ser necesarío agregue aquí comentarios."><?php echo isset($salida) ? $salida->comentario : "" ?>
                                </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="ticket">Ticket u orden de salida</label>
                                    <input value="<?php echo isset($salida) ? $salida->ticket : '' ?>" type="text"
                                        class="form-control" name="ticket" id="ticket" placeholder="Ticket u orden"
                                        autocomplete="off">
                                </div>

                                <div class="form-group">
                                    <label for="progreso">Estado movimiento</label>

                                    <select name="progreso" id="progreso" class="form-control" required="required">
                                        <?php
                                        $progre = new libreria\ORM\EtORM();
                                        $progresos = $progre->ejecutar("sp_progreso_movimiento");
                                        foreach ($progresos as $progreso) { ?>
                                        <option <?php echo isset($salida) && $salida->progreso == $progreso['id']
                                                        ? 'selected' : '' ?> value="<?php echo $progreso['id'] ?>">
                                            <?php echo ($progreso['Nombre']); ?>
                                        </option><?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <button ng-click="cargarDetalleSalida()" type="button" data-toggle="modal"
                                            data-target="#listaProductos" class="btn btn-sm btn-success">Agregar
                                            Producto</button>
                                        <?php if (isset($salida)) { ?>
                                        <input type="HIDDEN" ng-init="recuperarDetalles()">
                                        <?php } ?>
                                        <?php if ($_SESSION["ADMINISTRADOR"] == true) { ?>
                                        <button ng-click="generarCierre()" type="button" class="btn btn-sm btn-danger">
                                            Cargar Cierre</button>
                                        <?php } ?>
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Código categoría</th>
                                                    <th>Categoría</th>
                                                    <th>Modelo</th>
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
                                                            class="btn btn-sm btn-danger"><i
                                                                class="fa fa-trash-o fa-1x"></i></button>
                                                        <button ng-click="verId_Modelo(pd.id,pd.model)" type="button"
                                                            data-toggle="modal" data-target="#listarSeries"
                                                            class="btn btn-sm btn-success"
                                                            ng-show="pd.seriable == '1'">series</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <button type="submit" id="enviar_f" class="btn btn-primary">
                                    <!--Boton de envío Formulario-->
                                    <?php echo isset($salida) ? 'Actualizar' : 'Registrar' ?></button>
                            </div>
                            <input type="hidden" value="{{detallesAdd}}" name="detalle">
                            <input type="hidden" value="{{seriesAdd}}" name="serie">

                        </div>
                    </div>
                </div>
            </form>

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

            <div class="modal fade" id="listarSeries" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="modalSerie" role="document">
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
                                        <td>Acciones</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="sr in seriesAdd | filter: {id:id_modelo}">
                                        <td>{{$index+1}}</td>
                                        <td>{{sr.series}}</td>
                                        <td>
                                            <button type="button" ng-click="editarSerie(sr.series,sr)"
                                                class="btn btn-sm btn-success">Editar
                                            </button>
                                            <button type="button" ng-click="eliminarSerie(sr)"
                                                class="btn btn-sm btn-danger">Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Fin Modal cuerpo -->
                        <div class="modal-footer">
                            <label for="eCaracter">Ingrese caracteres a eliminar: </label>
                            <input ng-model="eCaracter" ng-keypress="myFunct($event)" id="eCaracter" name="eCaracter"
                                type="text" class="form-group" />
                            <button type="button" class="btn btn-danger" ng-click="eliminarCaracter()">Eliminar</button>
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

</body>

</html>