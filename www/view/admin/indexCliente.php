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
                <h1 class="page-header"><?php echo $tituloPagina ?></h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- row -->
        <div class="panel panel-default" ng-model="ASIGNADOS" ng-show="eleccion == 'asignado'"
             ng-controller="DetalleControlador">
            <input type="hidden" value="<?php url('') ?>" id="urlPrincipal">
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover small col_fil" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th colspan="3" class="text-center">Disponibles</th>
                        <th>No Disponible</th>
                        <?php if ($leds) { ?>
                          <th>Alertas</th>
                        <?php } ?>
                    </tr>
                    <tr>
                        <th class="col-lg-1">Código</th>
                        <th class="col-lg-3">Categoría</th>
                        <th class="text-primary">Stock</th>
                        <th>Deposito CTL</th>
                        <th>Metropolitana</th>
                        <th>Parque Patricios</th>
                        <th>Detalle</th>
                        <?php if ($leds) { ?>
                          <th></th>
                        <?php } ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($stocks as $stock) { ?>
                        <tr>
                            <td><?php echo $stock["codi"] ?></td>
                            <td><?php echo $stock["nombre"] ?></td>
                            <td class="text-primary text-center"
                            ng-click="cargarDetalle(<?php echo $id ?>,<?php echo $stock['id'] ?>)"
                               data-toggle="modal" data-target="#listaModelos" style="cursor: pointer" title="Cantidad y Modelos"><strong>
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
                                $valor1 = $valore1 - $valors1;
                                echo $valor1;?>
                            </td>
                            <td class="text-center">
                                <?php if($stock["entrada2"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entrada2"];
                                }if($stock["salida22"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salida22"];
                                }
                                $valor2 = $valore1 - $valors1;
                                echo $valor2; ?>
                            </td>
                            <td class="text-center">
                                <?php if($stock["entrada3"] < 1){
                                    $valore1 = 0;
                                }else {
                                    $valore1 = (int)$stock["entrada3"];
                                }if($stock["salida32"] < 1){
                                    $valors1 = 0;
                                }else {
                                    $valors1 = (int)$stock["salida32"];
                                }
                                $valor3 = $valore1 - $valors1;
                                echo $valor3;?>
                            </td>
                            <td class="text-center"><?php if($valor1+$valor2+$valor3 != $total){ ?>
                                <a href="<?php url('admin/detalle/'.$id.'/'.$stock["id"]) ?>" title="Ver No Disponible"
                                   class="btn btn-primary btn-sm"><?php echo $total-$valor1-$valor2-$valor3; ?></a>
                            <?php } ?></td>
                            <?php if ($leds) { ?>
                              <td>
                                  <div class="<?php
                                  if($total>$stock["medio"]){
                                      echo 'led-green" title="El STOCK es adecuado';
                                  }
                                  elseif($total>$stock["minimo"]){
                                      echo 'led-yellow" title="El stock esta por debajo de '.$stock["medio"];
                                  }
                                  else{
                                      echo 'led-red" title="El stock esta por debajo de '.$stock["minimo"];
                                  }
                                  ?>">
                                  </div>
                              </td>
                            <?php } ?>
                        </tr>
                    <?php } ?>
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
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th class="text-primary text-center">Stock</th>
                                <th class="text-center">Depósito CTL</th>
                                <th class="text-center">Metropolitana</th>
                                <th class="text-center">Parque Patricios</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr ng-repeat="modelo in modelos | filter: buscarProducto" ng-show="(modelo.entradag-modelo.salidag) != 0">
                                <td> {{modelo.marc}} </td>
                                <td><a href="https://www.google.com.ar/search?q={{modelo.marc}} {{modelo.model}}" target="_blank"> {{modelo.model}} </a></td>
                                <td class="text-primary text-center"><strong> {{modelo.entradag - modelo.salidag}} </strong></td>
                                <td class="text-center"> {{modelo.entrada1 - modelo.salida12}} </td>
                                <td class="text-center"> {{modelo.entrada2 - modelo.salida22}} </td>
                                <td class="text-center"> {{modelo.entrada3 - modelo.salida32}} </td>
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
