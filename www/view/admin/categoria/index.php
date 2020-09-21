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
                <h1 class="page-header">Listado de categorías |
                    <a href="<?php url("categoria/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nueva categoría</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>Código</th>
                        <th>Categoría</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($categorias as $categoria) { ?>
                        <tr>
                            <td><?php echo $categoria->codigo ?></td>
                            <td><?php echo $categoria->nombre ?></td>
                            <td>
                                <a href="<?php url('categoria/editar/' . $categoria->id) ?>"
                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                <?php if($_SESSION['ADMINISTRADOR'] == true){ ?>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirma('<?php url('categoria/eliminar/' . $categoria->id) ?>',
                                            '<?php echo "la categoría " . $categoria->nombre ?>')"><i
                                        class="fa fa-trash-o"></i>
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