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
                <h1 class="page-header">Listado de privilegios |
                    <a href="<?php url("privilegio/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo privilegio</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Privilegio</th>
                <th>Descripción</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($privilegios as $privilegio){ ?>
                <tr>
                    <td><?php echo $privilegio->id ?></td>
                    <td><?php echo $privilegio->nombre ?></td>
                    <td><?php echo $privilegio->descripcion ?></td>
                    <td>
                        <a href="<?php url('privilegio/editar/'.$privilegio->id) ?>"
                           class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirma('<?php url('privilegio/eliminar/'.$privilegio->id)?>',
                                    '<?php echo "el privilegio ".$privilegio->nombre ?>')"><i class="fa fa-trash-o"></i>
                            Eliminar</button>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>

        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>