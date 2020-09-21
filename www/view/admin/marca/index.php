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
                <h1 class="page-header">Listado de marcas |
                    <a href="<?php url("marca/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nueva marca</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>Marca</th>
                        <th>Descripción</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($marcas as $marca) { ?>
                        <tr>
                            <td><?php echo $marca->nombre ?></td>
                            <td><?php echo $marca->descripcion ?></td>
                            <td>
                                <a href="<?php url('marca/editar/' . $marca->id) ?>"
                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                <?php if($_SESSION['ADMINISTRADOR'] == true){ ?>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirma('<?php url('marca/eliminar/' . $marca->id) ?>',
                                            '<?php echo "la marca " . $marca->nombre ?>')"><i class="fa fa-trash-o"></i>
                                    Eliminar
                                </button><?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
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