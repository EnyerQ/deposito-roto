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
                <h1 class="page-header"><?php echo isset($cliente) ? 'Actualizar':'Nuevo' ?> Cliente |
                    <a href="<?php url("cliente/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("cliente/agregar") ?>" method="post" role="form">
                            <legend>Datos del cliente</legend>

                            <?php if(isset($cliente)){ ?>
                                <input type="hidden" value="<?php echo $cliente->id ?>" name="cliente_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="cod_produto">Razón social del cliente</label>
                                <input value="<?php echo isset($cliente) ? $cliente->razon_social:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="razon_social" id="razon_social" placeholder="Nombre de la empresa">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción del cliente</label>
                                <input value="<?php echo isset($cliente) ? $cliente->descripcion:'' ?>"
                                       required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del cliente">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($cliente) ? 'Actualizar':'Registrar' ?></button>
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