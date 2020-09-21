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
                <h1 class="page-header">Listado de destinos |
                    <a href="<?php url("destino/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo destino</a> </h1>
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
                        <th>Destinos</th>
                        <th>Dirección</th>
                        <th>Tipo</th>
                        <th>Zona</th>
                        <th>Acción</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($destinos as $destino) { ?>
                        <tr>
                            <td><?php echo $destino["nombre"] ?></td>
                            <td><?php echo $destino["descripcion"] ?></td>
                            <td><?php echo $destino["tipo"] ?></td>
                            <td><?php echo $destino['zona'] ?></td>
                            <td>
                                <a href="<?php url('destino/editar/' . $destino["id"]) ?>"
                                   class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                <button class="btn btn-danger btn-sm"
                                        onclick="confirma('<?php url('destino/eliminar/' . $destino["id"]) ?>',
                                            '<?php echo "el proveedor " . $destino["nombre"] ?>')"><i
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