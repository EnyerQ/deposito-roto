<!DOCTYPE html>
<html lang="es">

<head>

    <?php include VISTA_RUTA . "admininclude/head.php"?>

</head>

<body>

    <div id="wrapper" ng-app="seleccion" ng-controller="ControladorTab">

        <!-- Navigation -->
        <?php include VISTA_RUTA . "admininclude/menu.php"?>

        <div id="page-wrapper" ng-controller="ModeloControlador">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><?php echo $tituloPagina ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <!-- row -->
            <div class="panel panel-default" ng-model="ASIGNADOS" ng-show="eleccion == 'asignado'"
                ng-controller="DetalleControlador">
                <input type="hidden" value="<?php url('')?>" id="urlPrincipal">
                <div class="panel-body">
                    <table class="table table-striped table-bordered table-hover small col_fil" id="tabla_filtro">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="3" class="text-center">Disponibles</th>
                                <th>No Disponible</th>
                                <?php if ($leds) {?>
                                <th>Alertas</th>
                                <?php }?>
                            </tr>
                            <tr>
                                <th class="col-lg-1">Código</th>
                                <th class="col-lg-3">Categoría</th>
                                <th class="text-primary">Stock</th>
                                <th>Deposito CTL</th>
                                <th>Metropolitana</th>
                                <th>Parque Patricios</th>
                                <th>Detalle</th>
                                <?php if ($leds) {?>
                                <th></th>
                                <?php }?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($stocks as $stock) {?>
                            <?php if ($stock->stock_general != 0) {?>
                            <tr>
                                <td><?php echo $stock->codigo ?></td>
                                <td><?php echo $stock->nombre ?></td>
                                <?php if ($stock->seriable == 1) {?>

                                <td class="text-primary text-center"
                                    ng-click="cargarDetalleSeriable(<?php echo $id ?>,<?php echo $stock->id ?>)"
                                    data-toggle="modal" data-target="#listaModelos" style="cursor: pointer"
                                    title="Cantidad y Modelos"><strong>
                                        <?php

    echo $stock->stock_general; ?>
                                    </strong></td>
                                <?php } else {?>

                                <td class="text-primary text-center"
                                    ng-click="cargarDetalleNoSeriable(<?php echo $id ?>,<?php echo $stock->id ?>)"
                                    data-toggle="modal" data-target="#listaModelos" style="cursor: pointer"
                                    title="Cantidad y Modelos"><strong>
                                        <?php

    echo $stock->stock_general; ?>
                                    </strong></td>
                                <?php }?>
                                <td class="text-center">
                                    <?php if ($stock->stock_ctl != '') {echo $stock->stock_ctl;} else {echo 0;}?>
                                </td>
                                <td class="text-center">
                                    <?php if ($stock->stock_metro != '') {echo $stock->stock_metro;} else {echo 0;}?>
                                </td>
                                <td class="text-center">
                                    <?php if ($stock->stock_pp != '') {echo $stock->stock_pp;} else {echo 0;}?>
                                </td>
                                <td class="text-center">
                                    <?php if ($stock->stock_general - $stock->stock_ctl - $stock->stock_metro - $stock->stock_pp > 0) {?>
                                    <a href="<?php url('stock/detalleNoDisponible/' . $id . '/' . $stock->id . '/' . $stock->seriable)?>"
                                        title="Ver No Disponible" target="_blank"
                                        class="btn btn-primary btn-sm"><?php echo $stock->stock_general - $stock->stock_ctl - $stock->stock_metro - $stock->stock_pp; ?></a>
                                    <?php }?>
                                </td>
                                <?php if ($leds) {?>
                                <td></td>
                                <?php }?>
                            </tr>
                            <?php }?>
                            <?php }?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Modal para ver detalle -->
            <div class="modal fade" id="listaModelos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="modalStock" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Listado de modelos</h4>
                        </div>
                        <!-- Modal cuerpo -->
                        <div class="modal-body">
                            <div class="col-md-6">
                                <input type="text" placeholder="Buscar..." class="form-control"
                                    ng-model="buscarProducto">
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Categoria</th>
                                        <th>Marca</th>
                                        <th>Modelo</th>
                                        <th class="text-primary text-center">Stock</th>
                                        <th class="text-center">Depósito CTL</th>
                                        <th class="text-center">Metropolitana</th>
                                        <th class="text-center">Parque Patricios</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="modelo in modelos | filter: buscarProducto"
                                        ng-show="modelo.stock != 0">
                                        <td> {{modelo.categoria}} </td>
                                        <td> {{modelo.marca}} </td>
                                        <td><a href="https://www.google.com.ar/search?q={{modelo.marca}} {{modelo.modelo}}"
                                                target="_blank"> {{modelo.modelo}} </a></td>
                                        <td class="text-primary text-center"><strong>
                                                {{modelo.stock}} </strong></td>
                                        <td class="text-center"> {{modelo.ctl}} </td>
                                        <td class="text-center"> {{modelo.metro}} </td>
                                        <td class="text-center"> {{modelo.pp}} </td>
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
            <!-- /.row -->

            <!--TERMINO CONTENIDO-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include VISTA_RUTA . "admininclude/scripts.php"?>
    <script src="<?php asset('js/controladores/PrincipalController.js')?>"></script>

</body>

</html>