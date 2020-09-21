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
                <h1 class="page-header"><?php echo isset($estado) ? 'Actualizar':'Nuevo' ?> proveedor |
                    <a href="<?php url("proveedor/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("proveedor/agregar") ?>" method="post" role="form">
                            <legend>Datos del proveedor</legend>

                            <?php if(isset($proveedor)){ ?>
                                <input type="hidden" value="<?php echo $proveedor->id ?>" name="proveedor_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="codigo">Nombre</label>
                                <input value="<?php echo isset($proveedor) ? $proveedor->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre del proveedor">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Dirección u observación</label>
                                <input value="<?php echo isset($proveedor) ? $proveedor->descripcion:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del proveedor">
                            </div>

                            <!--Creamos el selector para registrar la zona del destino en cuestión-->

                            <div class="form-group">
                                <label for="zona">Seleccione la zona</label>

                                <select name="zona" id="zonal" class="form-control" required>
                                    <option value=""></option>
                                    <option value="SUR" <?php if(isset($proveedor) && $proveedor->zona == 'SUR'){echo 'selected';} ?>>SUR</option>
                                    <option value="OESTE" <?php if(isset($proveedor) && $proveedor->zona == 'OESTE'){echo 'selected';} ?>>OESTE</option>
                                    <option value="NORTE" <?php if(isset($proveedor) && $proveedor->zona == 'NORTE'){echo 'selected';} ?>>NORTE</option>
                                    <option value="CABA" <?php if(isset($proveedor) && $proveedor->zona == 'CABA'){echo 'selected';} ?>>CABA</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($proveedor) ? 'Actualizar':'Registrar' ?></button>
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