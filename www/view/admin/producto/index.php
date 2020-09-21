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
                <h1 class="page-header">Listado de productos |
                    <a href="<?php url("producto/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo producto</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- /.row -->
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-hover" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>Cod. Categoría</th>
                        <th>Categoría</th>
                        <th>Part Number</th>
                        <th>Modelo</th>
                        <th>Marca</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($productos as $producto) { ?>
                        <tr>
                            <td><?php echo $producto["cate"] ?></td>
                            <td><?php echo $producto["nomcat"] ?></td>
                            <td><?php echo $producto["part"] ?></td>
                            <td><?php echo $producto["model"] ?></td>
                            <td><?php echo $producto["marc"] ?></td>
                            <td>
                                <a href="<?php url('producto/editar/' . $producto["id"]) ?>"
                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                <?php if($_SESSION['ADMINISTRADOR'] == true){ ?>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirma('<?php url('producto/eliminar/' . $producto["id"]) ?>',
                                            '<?php echo "el producto " . $producto["model"] ?>')"><i
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