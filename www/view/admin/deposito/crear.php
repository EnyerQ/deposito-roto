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
                <h1 class="page-header"><?php echo isset($deposito) ? 'Actualizar':'Nuevo' ?> Depósito |
                    <a href="<?php url("deposito/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("deposito/agregar") ?>" method="post" role="form">
                            <legend>Datos del depósito</legend>

                            <?php if(isset($deposito)){ ?>
                                <input type="hidden" value="<?php echo $deposito->id ?>" name="deposito_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="cod_produto">Nombre del depósito</label>
                                <input value="<?php echo isset($deposito) ? $deposito->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre del depósito">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción del depósito</label>
                                <input value="<?php echo isset($deposito) ? $deposito->descripcion:'' ?>"
                                       required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del depósito">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($deposito) ? 'Actualizar':'Registrar' ?></button>
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