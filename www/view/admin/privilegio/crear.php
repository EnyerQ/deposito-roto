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
                <h1 class="page-header"><?php echo isset($privilegio) ? 'Actualizar':'Nuevo' ?> Privilegio |
                    <a href="<?php url("privilegio/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("privilegio/agregar") ?>" method="post" role="form">
                            <legend>Datos del privilegio</legend>

                            <?php if(isset($privilegio)){ ?>
                                <input type="hidden" value="<?php echo $privilegio->id ?>" name="privilegio_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="cod_produto">Nombre del privilegio</label>
                                <input value="<?php echo isset($privilegio) ? $privilegio->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre del privilegio">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción del privilegio</label>
                                <input value="<?php echo isset($privilegio) ? $privilegio->descripcion:'' ?>"
                                       required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del cliente">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($privilegio) ? 'Actualizar':'Registrar' ?></button>
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