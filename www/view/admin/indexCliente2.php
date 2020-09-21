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

        <!-- row -->
        <div class="panel panel-default" ng-model="ASIGNADOS" ng-show="eleccion == 'asignado'"
             ng-controller="DetalleControlador">
            <div class="panel-heading">
                <legend>Stock de equipos</legend>
            </div>
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover small" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Deposito CTL</th>
                        <th>Metropolitana</th>
                        <th></th>
                    </tr>
                    <tr>
                        <th>Codígo categoría</th>
                        <th>Categoría</th>
                        <th class="text-primary">STOCK</th>
                        <th>Disponible</th>
                        <th>Disponible</th>
                        <th>Alerta</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stocks as $stock) { ?>
                        <tr>
                            <td><?php echo $stock["codi"] ?></td>
                            <td><?php echo $stock["nombre"] ?></td>
                            <td class="text-primary text-center"><strong>
                                    <?php if($stock["entradag"] < 1){
                                        $valore1 = 0;
                                    }else {
                                        $valore1 = (int)$stock["entradag"];
                                    }if($stock["salidag"] < 1){
                                        $valors1 = 0;
                                    }else {
                                        $valors1 = (int)$stock["salidag"];
                                    }

                                    $total = $valore1 - $valors1;

                                    echo $total ; ?>
                                </strong></td>
                            <td class="text-center">
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
                            <td class="text-center v">
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
                            <td>
                                <ul class="<?php
                                if($total>20){
                                    echo 'semaforo verde" title="El STOCK es adecuado';
                                }
                                elseif($total>10){
                                    echo 'semaforo naranja" title="Precación con el STOCK';
                                }
                                else{
                                    echo 'semaforo rojo" title="El STOCK es muy bajo';
                                }
                                ?>">
                                    <li></li>
                                    <li></li>
                                    <li></li>
                                </ul>
                            </td>
                        </tr>
                    <?php } ?>
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
<script src="<?php asset('js/controladores/PrincipalController.js')?>"></script>

</body>

</html>