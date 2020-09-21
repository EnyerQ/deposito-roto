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
                <h1 class="page-header">Consultar movimientos por productos
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="panel panel-green">
            <div class="panel-heading">
                <legend>Busqueda por productos</legend>
            </div>
            <div class="panel-body">
                <form action="<?php url("consulta/movimiento") ?>" method="post" role="form">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fecha_inicio">Fecha inicio</label>

                        <input class="form-control" id="fecha_inicio" name="fecha_inicio" type="date" required
                        <?php if(isset($fecha_inicio)){ ?> value="<?php echo $fecha_inicio; ?>" <?php } ?>>
                    </div>

                    <div class="form-group">
                        <label for="fecha_final">Fecha final</label>

                        <input class="form-control" id="fecha_final" name="fecha_final" type="date" required
                            <?php if(isset($fecha_final)){ ?> value="<?php echo $fecha_final; ?>" <?php } ?>>
                    </div>

                    <div class="form-group">
                        <label for="deposito">Seleccionar depósito</label>

                        <select  name="deposito" id="deposito" class="form-control">
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

                    <div class="form-group">
                      <label for="tipo">Seleccionar tipo de movimiento</label>

                      <select  name="tipo" id="tipo" class="form-control"
                               required="required">
                          <option value="salida" <?php echo  isset($tipo) && $tipo == 'salida'
                              ? 'selected':'' ?>>SALIDA</option>
                          <option value="entrada" <?php echo  isset($tipo) && $tipo == 'entrada'
                              ? 'selected':'' ?>>ENTRADA</option>
                      </select>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="categoria">La categoría del producto</label>

                        <select  name="categoria" id="categoria" class="form-control">
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
                        <label for="estado">Estado</label>

                        <select name="estado" id="estado" class="form-control">
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
                <table class="table table-hover table-condensed small" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Depósito</th>
                        <th>Categoría</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Cantidad</th>
                        <th>Ticket</th>
                        <th>Consumido</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($consultas as $consulta) { ?>
                        <tr <?php if($consulta['tipo']=='salida') {?> class="danger" <?php }else{ ?> class="success" <?php } ?>>
                            <td><?php echo $consulta['fecha'] ?></td>
                            <td><?php echo $consulta['depo'] ?></td>
                            <td><?php echo $consulta['categoria'] ?></td>
                            <td><?php echo $consulta['marca'] ?></td>
                            <td><?php echo $consulta['modelo'] ?></td>
                            <td><?php echo $consulta['cantidad'] ?></td>
                            <td><?php echo $consulta['ticket'] ?></td>
                            <td><?php echo $consulta['consumo'] ?></td>
                            <td><a href="<?php url('/'.$tipo.'/informe/'.$consulta['id_mov']) ?>"
                               target="_blank">Detalle</a> </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php } ?>
        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>
