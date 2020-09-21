<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper" ng-app="seleccion" ng-controller="ControladorTab">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper" ng-controller="ModeloControlador">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Principal</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- /.row -->
        <?php
        $tran = new libreria\ORM\EtORM();
        $transitos = $tran->ejecutar("sp_movimiento_estado", array($_SESSION['cliente'],5));?>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-primary hidden-print">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-desktop fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Stock</div>
                                <div class="huge"> </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" ng-click="Cambiotab('asignado')">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalle</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-green hidden-print">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-truck fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Movimientos en Transito</div>
                                <div class="huge"><?php echo count($transitos) ?></div>
                            </div>
                        </div>
                    </div>
                    <a href="#" ng-click="Cambiotab('transito')">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalle</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="panel panel-yellow hidden-print">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-warning fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div>Stock no Disponibles</div>
                                <div class="huge"> </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" ng-click="Cambiotab('nodisponible')">
                        <div class="panel-footer">
                            <span class="pull-left">Ver Detalle</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>

        </div>

        <!-- row -->
        <div class="panel panel-primary" ng-model="ASIGNADOS" ng-show="eleccion == 'asignado'"
             ng-controller="DetalleControlador">
            <div class="panel-heading">
                <legend>Stock de equipos</legend>
            </div>
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-hover small" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th colspan="2">Deposito CTL</th>
                        <th colspan="2">Metropolitana</th>
                    </tr>
                    <tr>
                        <th>Codígo categoría</th>
                        <th>Categoría</th>
                        <th class="text-primary">General</th>
                        <th>Total</th>
                        <th>Disponible</th>
                        <th>Total</th>
                        <th>Disponible</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stocks as $stock) { ?>
                        <tr ng-click="cargarDetalle(<?php echo $id ?>,<?php echo $stock['id'] ?>)"
                            data-toggle="modal" data-target="#listaModelos" style="cursor: pointer">
                            <td><?php echo $stock["codi"] ?></td>
                            <td><?php echo $stock["nombre"] ?></td>
                            <td class="text-primary"><strong>
                                <?php if($stock["entradag"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entradag"];
                                }if($stock["salidag"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salidag"];
                                }
                                echo $valore1 - $valors1; ?>
                                </strong></td>
                            <td>
                                <?php if($stock["entrada1"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entrada1"];
                                }if($stock["salida11"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salida11"];
                                }
                                echo $valore1 - $valors1; ?>
                            </td>
                            <td>
                                <?php if($stock["entrada1"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entrada1"];
                                }if($stock["salida12"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salida12"];
                                }
                                echo $valore1 - $valors1; ?>
                            </td>
                            <td>
                                <?php if($stock["entrada2"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entrada2"];
                                }if($stock["salida21"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salida21"];
                                }
                                echo $valore1 - $valors1; ?>
                            </td>
                            <td>
                                <?php if($stock["entrada2"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entrada2"];
                                }if($stock["salida22"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salida22"];
                                }
                                echo $valore1 - $valors1; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-green" ng-model="TRANSITO" ng-show="eleccion == 'transito'"
             ng-controller="DetalleControlador">
            <div class="panel-heading">
                <legend>Movimientos en transito</legend>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Remito</th>
                        <th>Fecha</th>
                        <th>Deposito</th>
                        <th>Movimiento</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Ticket</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($transitos as $transito) { ?>
                        <tr ng-model="movimiento<?php echo $transito['id'] ?>" style="cursor: pointer"
                            ng-click="verDetalle('deta<?php echo $transito["id"] ?>')">
                            <td><?php echo $transito["remito"] ?></td>
                            <td><?php echo $transito["fecha"] ?></td>
                            <td><?php echo $transito["depo"] ?></td>
                            <td><?php echo $transito["tipo_movimiento"] ?></td>
                            <td><?php echo $transito["origen"] ?></td>
                            <td><?php echo $transito["destino"] ?></td>
                            <td><?php echo $transito["ticket"] ?></td>
                        </tr>
                        <tr ng-model="movi<?php echo $transito['id'] ?>"
                            ng-show="detalle == 'deta<?php echo $transito["id"] ?>'">
                            <td colspan="7">
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
                                    <?php $deta = new libreria\ORM\EtORM();
                                    $detalles = $deta->ejecutar("sp_lista_detalle", array($transito['id']));
                                    foreach ($detalles as $detalle) { ?>
                                        <tr>
                                            <td><?php echo $detalle["codcat"] ?></td>
                                            <td><?php echo $detalle["categoria"] ?></td>
                                            <td><?php echo $detalle["modelo"] ?></td>
                                            <td><?php echo $detalle["cantidad"] ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- No disponibles -->
        <div class="panel panel-yellow" ng-model="NODISPONIBLE" ng-show="eleccion == 'nodisponible'"
             ng-controller="DetalleControlador">
            <div class="panel-heading">
                <legend>Stock no disponible</legend>
            </div>
            <div class="panel-body">
                <div class="col-md-6">
                    <input type="text" placeholder="Filtrar..." class="form-control"
                           ng-model="FiltroNoDisponible">
                </div>
                <table class="table table-hover" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>Codígo categoría</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th class="text-primary">General</th>
                        <th>DepositoCTL</th>
                        <th>Metropolitana</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="nd in noDisponibles | filter: FiltroNoDisponible" ng-show="nd.salidag > 0">
                        <td>{{nd.codi}}</td>
                        <td>{{nd.nombre}}</td>
                        <td>{{nd.sub_est}}</td>
                        <td class="text-primary">{{nd.salidag}}</td>
                        <td>{{nd.salida11}}</td>
                        <td>{{nd.salida21}}</td>
                    </tr>
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
                                <th></th>
                                <th></th>
                                <th></th>
                                <th colspan="2">Deposito CTL</th>
                                <th colspan="2">Metropolitana</th>
                            </tr>
                            <tr>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th class="text-primary">General</th>
                                <th>Total</th>
                                <th>Disponible</th>
                                <th>Total</th>
                                <th>Disponible</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="modelo in modelos | filter: buscarProducto">
                                <td> {{modelo.marc}} </td>
                                <td> {{modelo.model}} </td>
                                <td class="text-primary"><strong> {{modelo.entradag - modelo.salidag}} </strong></td>
                                <td> {{modelo.entrada1 - modelo.salida11}} </td>
                                <td> {{modelo.entrada1 - modelo.salida12}} </td>
                                <td> {{modelo.entrada2 - modelo.salida21}} </td>
                                <td> {{modelo.entrada2 - modelo.salida22}} </td>
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

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>
<script src="<?php asset('js/controladores/PrincipalController.js')?>"></script>

</body>

</html>
