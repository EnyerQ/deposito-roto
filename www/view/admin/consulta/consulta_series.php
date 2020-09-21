<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA . "admininclude/head.php") ?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include(VISTA_RUTA . "admininclude/menu.php") ?>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Consultar Números de Serie Almacenados
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <div class="panel panel-green">
                <div class="panel-heading">
                    <legend>Filtros para reportes</legend>
                </div>
                <div class="panel-body">
                    <form action="<?php url("consulta/consulta_series") ?>" method="post" role="form">
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="categoria">La categoría del producto</label>

                                <select name="categoria" id="categoria" class="form-control">
                                    <option value=""></option>
                                    <?php
                                    $cat = new \libreria\ORM\EtORM();
                                    $categoria = $cat->ejecutar("sp_listar_categoria_seriable", array($_SESSION["cliente"]));
                                    foreach ($categoria as $categorias) { ?>
                                    <option <?php echo  isset($cate) && $cate == $categorias['id']
                                                    ? 'selected' : '' ?> value="<?php echo $categorias['id'] ?>">
                                        <?php echo ($categorias['codigo'] . " | " . $categorias['nombre']); ?>
                                    </option><?php } ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="deposito">Seleccionar depósito</label>

                                <select name="deposito" id="deposito" class="form-control" required="required">
                                    <option value=""></option>
                                    <?php
                                    $depo = new \libreria\ORM\EtORM();
                                    $depos = $depo->ejecutar("sp_lista_deposito");
                                    foreach ($depos as $dep) { ?>
                                    <option <?php echo  isset($deposito) && $deposito == $dep['id']
                                                    ? 'selected' : '' ?> value="<?php echo $dep['id'] ?>">
                                        <?php echo $dep['nombre'] ?>
                                    </option><?php } ?>
                                </select>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="estado">Estado</label>

                                <select name="estado" id="estado" class="form-control" required="required">
                                    <option value=""></option>
                                    <?php

                                    $pro = new libreria\ORM\EtORM();
                                    $prove = $pro->ejecutar("sp_entrada_origen", array($_SESSION['cliente'], "estado"));
                                    foreach ($prove as $provedor) { ?>
                                    <option <?php echo isset($estado) && $estado == $provedor['id']
                                                    ? 'selected' : '' ?> value="<?php echo $provedor['id'] ?>">
                                        <?php echo ($provedor['nombre']); ?>
                                    </option><?php } ?>
                                </select>
                            </div>

                            <br>
                            <button type="submit" class="btn btn-primary">
                                <!--Boton de envío Formulario-->
                                Buscar</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if (isset($consultas)) { ?>
            <div class="panel panel-green">
                <div class="panel-body">
                    <table class="table table-hover small" id="tabla_filtro">
                        <thead>
                            <tr>
                                <th>Serie</th>
                                <th>Categoria</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Sub_Estado</th>
                                <th>Alta</th>
                                <th>Opc</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($consultas as $consulta) { ?>
                            <tr>
                                <td><?php echo $consulta['serie'] ?></td>
                                <td><?php echo $consulta['cate'] ?></td>
                                <td><?php echo $consulta['marca'] ?></td>
                                <td><?php echo $consulta['modelo'] ?></td>
                                <td><?php echo $consulta['sub_estado'] ?></td>
                                <td><?php echo $consulta['alta'] ?></td>
                                <td>
                                    <div>
                                        <form action="<?php url("seguimiento/trazar") ?>">
                                            <div class="input-group inli">
                                                <input type="hidden" value="<?php echo $consulta['serie'] ?>"
                                                    name="buscarSerie" id="buscarSerie">
                                                <button class="btn btn-default btn-sm" type="submit">
                                                    <i class="fa fa-search"></i>
                                                </button>&nbsp;
                                                <?php if (false) { ?>
                                                <a href="<?php url($consulta['tipo'] . '/editar/' . $consulta['id_ultimo_movimiento']) ?>"
                                                    class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                                <?php } ?>
                                            </div>
                                        </form>

                                    </div>
                                </td>

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

    <?php include(VISTA_RUTA . "admininclude/scripts.php") ?>

</body>

</html>