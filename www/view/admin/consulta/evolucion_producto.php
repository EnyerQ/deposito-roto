<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Consultar movimientos mensuales por equipos
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="panel panel-green">
            <div class="panel-heading">
                <legend>Filtros para reportes</legend>
            </div>
            <div class="panel-body">
                <form action="<?php url("consulta/evolucion") ?>" method="post" role="form">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="categoria">La categoría del producto</label>

                            <select  name="categoria" id="categoria" class="form-control"
                                     required="required">
                                <option value=""></option>
                                <?php
                                $cat = new \libreria\ORM\EtORM();
                                $categoria = $cat->ejecutar("sp_lista_categoria",array($_SESSION["cliente"]));
                                foreach($categoria as $categorias){ ?>
                                <option <?php echo  isset($cate) && $cate == $categorias['id']
                                    ? 'selected':'' ?> value="<?php echo $categorias['id'] ?>">
                                    <?php echo ($categorias['codigo']." | ".$categorias['nombre']); ?>
                                    </option><?php }?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="deposito">Seleccionar depósito</label>

                            <select  name="deposito" id="deposito" class="form-control"
                                     required="required">
                                <option value=""></option>
                                <?php
                                $depo = new \libreria\ORM\EtORM();
                                $depos = $depo->ejecutar("sp_lista_deposito");
                                foreach($depos as $dep){ ?>
                                <option <?php echo  isset($deposito) && $deposito == $dep['id']
                                    ? 'selected':'' ?> value="<?php echo $dep['id'] ?>">
                                    <?php echo $dep['nombre'] ?>
                                    </option><?php }?>
                            </select>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="estado">Estado</label>

                            <select name="estado" id="estado" class="form-control"
                                    required="required">
                                <option value=""></option>
                                <?php

                                $pro = new libreria\ORM\EtORM();
                                $prove = $pro->ejecutar("sp_entrada_origen", array($_SESSION['cliente'],"estado"));
                                foreach ($prove as $provedor) { ?>
                                <option <?php echo isset($estado) && $estado == $provedor['id']
                                    ? 'selected' : '' ?> value="<?php echo $provedor['id'] ?>">
                                    <?php echo($provedor['nombre']); ?>
                                    </option><?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="progreso">Estado o progreso de los movimientos</label>

                            <select name="progreso" id="progreso" class="form-control"
                                    required="required">
                                <?php
                                $progre = new libreria\ORM\EtORM();
                                $progresos = $progre->ejecutar("sp_progreso_movimiento");
                                foreach ($progresos as $progreso) { ?>
                                <option <?php echo isset($progred) && $progred == $progreso['id']
                                    ? 'selected' : '' ?> value="<?php echo $progreso['id'] ?>">
                                    <?php echo($progreso['Nombre']); ?>
                                    </option><?php } ?>
                            </select>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary"><!--Boton de envío Formulario-->
                            Buscar</button>
                    </div>
                </form>
            </div>
        </div>

        <?php if(isset($consultas)) {?>
            <div class="panel panel-green">
                <div class="panel-body">
                    <table class="table table-hover" id="tabla">
                        <thead>
                        <tr>
                            <th>Mes</th>
                            <?php foreach ($consultas as $consulta) { ?>
                            <th><?php echo $consulta['mes'] ?></th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="danger">
                                <td>Salida</td>
                                <?php foreach ($consultas as $consulta) { ?>
                                <td><?php echo $consulta['salida'] ?></td>
                                <?php } ?>
                            </tr>
                            <tr class="success">
                                <td>Entrada</td>
                                <?php foreach ($consultas as $consulta) { ?>
                                <td><?php echo $consulta['entrada'] ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } ?>

        <div class="col-lg-12">
            <div class="panel panel-green">
                <div class="panel-heading">
                    Bar Chart Example
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div id="morris-bar-chart"></div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>


        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

<script>
    $(function() {

        Morris.Bar({
            element: 'morris-bar-chart',
            barColors:["#FB5012", "#519872"],
            data: [<?php foreach ($consultas as $consulta) { ?>
                {
                y: '<?php echo $consulta['mes'] ?>',
                a: <?php echo $consulta['salida'] ?>,
                b: <?php echo $consulta['entrada'] ?>
            },<?php } ?>
            ],
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Salida', 'Entrada'],
            hideHover: 'auto',
            resize: true
        });


    });
</script>

</body>

</html>