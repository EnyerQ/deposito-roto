<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper" ng-app="seleccion" ng-controller="ModeloControlador">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Stock de equipos
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- /.row -->
        <div class="panel-default"  ng-controller="DetalleControlador">
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-hover small" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th colspan="2">Deposito CTL</th>
                        <th colspan="2">Metropolitana</th>
                        <th colspan="2">Parque Patricios</th>
                    </tr>
                    <tr>
                        <th>Codígo categoría</th>
                        <th>Categoría</th>
                        <th>Total</th>
                        <th>Disponible</th>
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
                                <td>
                                    <?php if($stock["entrada3"] < 1){
                                        $valore1 = 0;
                                    }else {
                                        $valore1 = (int)$stock["entrada3"];
                                    }if($stock["salida31"] < 1){
                                        $valors1 = 0;
                                    }else {
                                        $valors1 = (int)$stock["salida31"];
                                    }
                                    echo $valore1 - $valors1; ?>
                                </td>
                                <td>
                                    <?php if($stock["entrada3"] < 1){
                                        $valore1 = 0;
                                    }else {
                                        $valore1 = (int)$stock["entrada3"];
                                    }if($stock["salida32"] < 1){
                                        $valors1 = 0;
                                    }else {
                                        $valors1 = (int)$stock["salida32"];
                                    }
                                    echo $valore1 - $valors1; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

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
                                <th colspan="2">Deposito CTL</th>
                                <th colspan="2">Metropolitana</th>
                                <th colspan="2">Parque Patricios</th>
                            </tr>
                            <tr>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Total</th>
                                <th>Disponible</th>
                                <th>Total</th>
                                <th>Disponible</th>
                                <th>Total</th>
                                <th>Disponible</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="modelo in modelos | filter: buscarProducto"
                            ng-show="{{modelo.entrada1 - modelo.salida11}} != 0 || {{modelo.entrada2 - modelo.salida21}} != 0 ||
                             {{modelo.entrada3 - modelo.salida31}} != 0">
                                <td> {{modelo.marc}} </td>
                                <td> {{modelo.model}} </td>
                                <td> {{modelo.entrada1 - modelo.salida11}} </td>
                                <td> {{modelo.entrada1 - modelo.salida12}} </td>
                                <td> {{modelo.entrada2 - modelo.salida21}} </td>
                                <td> {{modelo.entrada2 - modelo.salida22}} </td>
                                <td> {{modelo.entrada3 - modelo.salida31}} </td>
                                <td> {{modelo.entrada3 - modelo.salida32}} </td>
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
        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>
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
