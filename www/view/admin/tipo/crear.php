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
                <h1 class="page-header"><?php echo isset($tipo) ? 'Actualizar':'Nuevo' ?> tipo cliente |
                    <a href="<?php url("tipo/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("tipo/agregar") ?>" method="post" role="form">
                            <legend>Datos del tipo de destino</legend>

                            <?php if(isset($tipo)){ ?>
                                <input type="hidden" value="<?php echo $tipo->id ?>" name="tipo_destino_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="codigo">Nombre del tipo de destino en el cliente</label>
                                <input value="<?php echo isset($tipo) ? $tipo->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Ejemplo CAPs o FILIAL">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">descripción del tipo de destino en cliente</label>
                                <input value="<?php echo isset($tipo) ? $tipo->descripcion:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del tipo de destino">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($tipo) ? 'Actualizar':'Registrar' ?></button>
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