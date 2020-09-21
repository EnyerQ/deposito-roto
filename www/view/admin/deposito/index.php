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
                <h1 class="page-header">Listado depósito |
                    <a href="<?php url("deposito/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo depósito</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Depósito</th>
                <th>Descripción</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($depositos as $deposito){ ?>
                <tr>
                    <td><?php echo $deposito->id ?></td>
                    <td><?php echo $deposito->nombre ?></td>
                    <td><?php echo $deposito->descripcion ?></td>
                    <td>
                        <a href="<?php url('deposito/editar/'.$deposito->id) ?>"
                           class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirma('<?php url('deposito/eliminar/'.$deposito->id)?>',
                                    '<?php echo "el depósito ".$deposito->nombre ?>')"><i class="fa fa-trash-o"></i>
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