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
                <h1 class="page-header">Consultar Números de Serie Almacenados
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="panel panel-green">
            <div class="panel-heading">
                <legend>Busqueda por productos</legend>
            </div>
            <div class="panel-body">
                <form action="<?php url("consulta/consulta_series") ?>" method="post" role="form">
                    <div class="col-md-6">

                        <div class="form-group">
                            <label for="categoria">La categoría del producto</label>

                            <select  name="categoria" id="categoria" class="form-control">
                                <option value=""></option>
                                <?php
                                $cat = new \libreria\ORM\EtORM();
                                $categoria = $cat->ejecutar("sp_listar_categoria_seriable",array($_SESSION["cliente"]));
                                foreach($categoria as $categorias){ ?>
                                <option <?php echo  isset($producto) && $producto->id_categoria == $categorias['id']
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
                                <option <?php echo  isset($usuario) && $usuario->id_deposito == $dep['id']
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
                                <option <?php echo isset($entrada) && $entrada->id_origen == $provedor['id']
                                    ? 'selected' : '' ?> value="<?php echo $provedor['id'] ?>">
                                    <?php echo($provedor['nombre']); ?>
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