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
                <h1 class="page-header"><?php echo isset($marca) ? 'Actualizar':'Nuevo' ?> marca |
                    <a href="<?php url("marca/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("marca/agregar") ?>" method="post" role="form">
                            <legend>Datos de la marca</legend>

                            <?php if(isset($marca)){ ?>
                                <input type="hidden" value="<?php echo $marca->id ?>" name="marca_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="codigo">Nombre de la marca</label>
                                <input value="<?php echo isset($marca) ? $marca->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre marca">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">descripción de la marca</label>
                                <input value="<?php echo isset($marca) ? $marca->descripcion:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción de la marca">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($marca) ? 'Actualizar':'Registrar' ?></button>
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