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
                <h1 class="page-header"><?php echo isset($producto) ? 'Actualizar':'Nuevo' ?> producto |
                    <a href="<?php url("producto/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("producto/agregar") ?>" method="post" role="form">
                            <legend>Datos del producto</legend>

                            <?php if(isset($producto)){ ?>
                                <input type="hidden" value="<?php echo $producto->id ?>" name="producto_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="cod_produto">Código del producto</label>
                                <input value="<?php echo isset($producto) ? $producto->codigo:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="codigo" id="codigo" placeholder="Código">
                            </div>

                            <div class="form-group">
                                <label for="modelo">Modelo del producto</label>
                                <input value="<?php echo isset($producto) ? $producto->modelo:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="modelo" id="modelo" placeholder="Modelo del producto">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción del producto</label>
                                <input value="<?php echo isset($producto) ? $producto->descripcion:'' ?>"
                                       required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del producto">
                            </div>

                            <div class="form-group">
                                <label for="categoria">La categoría del producto</label>

                                <select  name="categoria" id="categoria" class="form-control"
                                         required="required">
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
                                <label for="marca">La marca del producto</label>

                                <select  name="marca" id="marca" class="form-control"
                                         required="required">
                                    <?php
                                    $mark = new \libreria\ORM\EtORM();
                                    $marca = $mark->ejecutar("sp_lista_marca",array($_SESSION["cliente"]));
                                    foreach($marca as $marcas){ ?>
                                    <option <?php echo  isset($producto) && $producto->id_marca == $marcas['id']
                                        ? 'selected':'' ?> value="<?php echo $marcas['id'] ?>">
                                        <?php echo $marcas['nombre'] ?>
                                        </option><?php }?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($producto) ? 'Actualizar':'Registrar' ?></button>
                        </form>
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

</body>

</html>