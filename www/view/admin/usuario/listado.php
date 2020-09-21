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
                <h1 class="page-header">Listado de usuarios | <a href="<?php url("usuario/nuevo") ?>" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo Usuario</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="panel-default">
            <div class="panel-body">
                <table class="table table-hover" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>E-mail</th>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <tr>
                            <td><?php echo $usuario->id ?></td>
                            <td><?php echo $usuario->usuariod ?></td>
                            <td><?php echo $usuario->email ?></td>
                            <td><?php echo $usuario->nombre ?></td>
                            <td>
                                <a href="<?php url("usuario/editar/" . $usuario->id) ?>"
                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirma('<?php url('usuario/eliminar/' . $usuario->id) ?>',
                                            '<?php echo "el usuario " . $usuario->usuariod ?>')"><i
                                        class="fa fa-trash-o"></i>
                                    Eliminar
                                </button>
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
