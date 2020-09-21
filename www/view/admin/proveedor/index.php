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
                <h1 class="page-header">Listado de proveedores |
                    <a href="<?php url("proveedor/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo proveedor</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- /.row -->
        <div class="panel-default">
            <div class="panel-body">
                <table class="table table-hover" id="tabla_filtro">
                    <thead>
                    <tr>
                        <th>Proveedor</th>
                        <th>Dirección u observación</th>
                        <th>Zona</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($proveedores as $proveedor) { ?>
                        <tr>
                            <td><?php echo $proveedor["nombre"] ?></td>
                            <td><?php echo $proveedor["descripcion"] ?></td>
                            <td><?php echo $proveedor["zona"] ?></td>
                            <td>
                                <a href="<?php url('proveedor/editar/' . $proveedor["id"]) ?>"
                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirma('<?php url('proveedor/eliminar/' . $proveedor["id"]) ?>',
                                            '<?php echo "el proveedor " . $proveedor["nombre"] ?>')"><i
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

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>