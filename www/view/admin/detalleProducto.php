<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper" ng-app="series" ng-controller="ControladorSeries">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Detalle <?php echo $almacen ?> no disponible <?php if(count($detalles)>0){ ?>
                        <i><?php echo $detalles[0]["nombre"] ?></i>
                    <?php } ?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- row -->
        <div class="panel panel-default">
            <div class="panel-heading">
                <legend>Detalle</legend>
            </div>
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover small">
                    <thead>
                    <tr>
                        <?php foreach ($detalles as $detalle) { ?>
                        <?php if($detalle['salidag']>0){ ?>
                        <th class="text-center"><?php echo $detalle["sub_est"] ?></th><?php } ?>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php foreach ($detalles as $detalle) { ?>
                            <?php if($detalle['salidag']>0){ ?>
                            <td class="text-center" ng-model="detalle" style="cursor: pointer"
                                <?php if ($detalle['seriable'] == 1) { ?>
                                  ng-click="recuperarSeries(<?php echo $_SESSION['cliente'] ?>,<?php echo $idAlmacen ?>,<?php echo  $detalle['id'] ?>,<?php echo  $detalle['id_estado'] ?>)"><?php echo $detalle["salidag"] ?></td>
                                <?php }else{ ?>
                                  ng-click="recuperarDetalle(<?php echo $_SESSION['cliente'] ?>,<?php echo $idAlmacen ?>,<?php echo  $detalle['id'] ?>,1,<?php echo  $detalle['id_estado'] ?>)"><?php echo $detalle["salidag"] ?></td>
                                <?php } ?>
                              <?php } ?>
                            <?php } ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-default" ng-show="mostrar">
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover small">
                    <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Serie</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Deposito</th>
                        <th>Alta</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="nd in noDisponibles">
                        <td>{{nd.ticket}}</td>
                        <td>{{nd.serie}}</td>
                        <td>{{nd.marca}}</td>
                        <td>{{nd.modelo}}</td>
                        <td>{{nd.deposito}}</td>
                        <td>{{nd.alta}}</td>
                        <td>{{nd.estado}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel panel-default" ng-show="mostrar2">
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover small">
                    <thead>
                    <tr>
                        <th>Ticket</th>
                        <th>Código</th>
                        <th>Modelo</th>
                        <th>Depósito</th>
                        <th>Cantidad</th>
                        <th>Estado</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="nd in noDisponibles">
                        <td>{{nd.ticket}}</td>
                        <td>{{nd.codigo}}</td>
                        <td>{{nd.modelo}}</td>
                        <td>{{nd.deposito}}</td>
                        <td>{{nd.cantidad}}</td>
                        <td>{{nd.estado}}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- /.row -->

        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>
<script src="<?php asset('js/controladores/SerieController.js')?>?v=1"></script>

</body>

</html>
