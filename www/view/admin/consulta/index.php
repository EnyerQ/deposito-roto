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

                            <input class="form-control" id="fecha_inicio" name="fecha_inicio" type="date" required>
                        </div>

                        <div class="form-group">
                            <label for="fecha_final">Fecha final</label>

                            <input class="form-control" id="fecha_final" name="fecha_final" type="date" required>
                        </div>

                        <div class="form-group">
                            <label for="deposito">Seleccionar depósito</label>

                            <select  name="deposito" id="deposito" class="form-control">
                                <option value=""></option>
                                <?php
                                $depo = new \libreria\ORM\EtORM();
                                $depos = $depo->ejecutar("sp_lista_deposito");
                                foreach($depos as $dep){ ?>
                                <option <?php echo  isset($usuario) && $usuario->id_deposito == $dep['id']
                                    ? 'selected':'' ?> value="<?php echo $dep['id'] ?>">
                                    <?php echo $dep['nombre'] ?>
                                    </option><?php }?>
                            </select>
                          </div>

                          <div class="form-group">
                            <label for="tipo">Seleccionar tipo de movimiento</label>

                            <select  name="tipo" id="tipo" class="form-control"
                                     required="required">
                                <option value="salida">salida</option>
                                <option value="entrada">entrada</option>
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
                                <option <?php echo  isset($producto) && $producto->id_categoria == $categorias['id']
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
                                <option <?php echo isset($entrada) && $entrada->id_origen == $provedor['id']
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
                                <option <?php echo isset($entrada) && $entrada->progreso == $progreso['id']
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
        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>
