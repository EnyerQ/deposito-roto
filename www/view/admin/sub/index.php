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
                <h1 class="page-header">Listado de Estados |
                    <a href="<?php url("sub/nuevo") ?>" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Nuevo Estado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <!-- /.row -->
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Estado</th>
                <th>Descripción</th>
                <th>Es movil</th>
                <th>Acción</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($estados as $estado){ ?>
                <tr>
                    <td><?php echo $estado["nombre"] ?></td>
                    <td><?php echo $estado["descripcion"] ?></td>
                    <td><?php echo $estado["movil"] ?></td>
                    <td>
                        <a href="<?php url('sub/editar/'.$estado["id"]) ?>"
                           class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                        <button class="btn btn-danger btn-sm"
                                onclick="confirma('<?php url('sub/eliminar/'.$estado["id"])?>',
                                    '<?php echo "el estado ".$estado["nombre"] ?>')"><i class="fa fa-trash-o"></i>
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

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>