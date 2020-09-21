<!DOCTYPE html>
<html lang="es">

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
                <h1 class="page-header">Listado de tipos de destinos en cliente |
                    <a href="<?php url("tipo/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nueva tipo de destino</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <table class="table table-hover">
            <thead>
            <tr>
                <th>Tipo destino</th>
                <th>Descripción</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($tipos as $tipo){ ?>
                <tr>
                    <td><?php echo $tipo["nombre"] ?></td>
                    <td><?php echo $tipo["descripcion"] ?></td>
                    <td>
                        <a href="<?php url('tipo/editar/'.$tipo["id"]) ?>"
                           class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirma('<?php url('tipo/eliminar/'.$tipo["id"])?>',
                                    '<?php echo "el tipo ".$tipo["nombre"] ?>')"><i class="fa fa-trash-o"></i>
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