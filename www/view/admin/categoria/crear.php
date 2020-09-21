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
                <h1 class="page-header"><?php echo isset($categoria) ? 'Actualizar':'Nuevo' ?> categoría |
                    <a href="<?php url("categoria/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("categoria/agregar") ?>" method="post" role="form">
                            <legend>Datos de la categoría</legend>

                            <?php if(isset($categoria)){ ?>
                                <input type="hidden" value="<?php echo $categoria->id ?>" name="categoria_id">
                            <?php } ?>

                            <div class="form-group">
                                <label for="codigo">Código de la categoría</label>
                                <input value="<?php echo isset($categoria) ? $categoria->codigo:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="codigo" id="codigo" placeholder="Código">
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre de la categoría</label>
                                <input value="<?php echo isset($categoria) ? $categoria->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre categoría">
                            </div>

                            <div class="form-group">
                                <label for="descripcion">Descripción del producto</label>
                                <input value="<?php echo isset($categoria) ? $categoria->descripcion:'' ?>"
                                       required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción categoría">
                            </div>

                            <div class="form-group">
                                <label for="seriable">La categoria es seriable:</label>

                                <select  name="seriable" id="seriable" class="form-control"
                                         required="required">

                                    <option <?php echo  isset($categoria) && $categoria->seriable == "0"
                                        ? 'selected':'' ?> value="0">
                                        NO
                                    </option>
                                    <option <?php echo  isset($categoria) && $categoria->seriable == "1"
                                        ? 'selected':'' ?> value="1">
                                        SI
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="minimo">Stock minimo</label>
                                <input value="<?php echo isset($categoria) ? $categoria->minimo:'' ?>"
                                       required type="text" class="form-control"
                                       name="minimo" id="minimo" placeholder="Ingrese el stock minimo">
                            </div>

                            <div class="form-group">
                                <label for="medio">Stock medio</label>
                                <input value="<?php echo isset($categoria) ? $categoria->medio:'' ?>"
                                       required type="text" class="form-control"
                                       name="medio" id="medio" placeholder="Ingrese el stock minimo">
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($categoria) ? 'Actualizar':'Registrar' ?></button>
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