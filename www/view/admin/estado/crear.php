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
                <h1 class="page-header"><?php echo isset($estado) ? 'Actualizar':'Nuevo' ?> Almacén |
                    <a href="<?php url("estado/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("estado/agregar") ?>" method="post" role="form">
                            <legend>Datos del almacén</legend>

                            <?php if(isset($estado)){ ?>
                                <input type="hidden" value="<?php echo $estado->id ?>" name="estado_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="codigo">Nombre del almacén</label>
                                <input value="<?php echo isset($estado) ? $estado->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre estado">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">descripción del almacén</label>
                                <input value="<?php echo isset($estado) ? $estado->descripcion:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del estado">
                            </div>

                            <div class="form-group">
                                <label for="estado">El almacén permite Stock</label>

                                <select  name="stock" id="stock" class="form-control"
                                         required="required">

                                    <option <?php echo  isset($estado) && $estado->stock == "NO"
                                        ? 'selected':'' ?> value="NO">
                                        NO
                                    </option>
                                    <option <?php echo  isset($estado) && $estado->stock == "SI"
                                        ? 'selected':'' ?> value="SI">
                                        SI
                                    </option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($estado) ? 'Actualizar':'Registrar' ?></button>
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