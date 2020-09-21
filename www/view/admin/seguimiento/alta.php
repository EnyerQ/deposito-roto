<!DOCTYPE html>
<html lang="en">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper" ng-app="DetalleAPP" ng-controller="DetalleControlador">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Alta de números de serie |</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->
        <form action="<?php url("seguimiento/alta") ?>" method="post" role="form">
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <legend>Datos de series</legend>

                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select name="categoria" id="categoria" class="form-control" ng-model="categoriaFiltro"
                                        ng-change="cargarModelosFiltrados(id)">
                                    <option ng-repeat="ct in categorias" value="{{ct.id}}">{{ct.codigo}}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="modelo">Modelo producto</label>
                                <select name="modelo" id="modelo" class="form-control" ng-model="modeloFiltro">
                                    <option ng-repeat="md in detalles" value="{{md.id}}">
                                        {{md.cate}} / {{md.model}} / {{md.marc}}</option>
                                </select>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="form-group">
                                <label>Ingrese los números de serie</label>
                                <textarea class="form-control" rows="10"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($cliente) ? 'Actualizar' : 'Registrar' ?></button>

                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>