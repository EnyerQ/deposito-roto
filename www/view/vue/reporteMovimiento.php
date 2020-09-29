<!DOCTYPE html>
<html lang="es">

<head>

    <?php include VISTA_RUTA . "admininclude/head.php"?>

</head>

<body>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include VISTA_RUTA . "admininclude/menu.php"?>


        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Reporte de movimientos de productos </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->

            <!-- /.row -->
            <div class="panel panel-default">
                <div class="panel-body">
                    <div id="app">
                        <div class="row">
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="fechaInicio">Seleccionar fecha de inicio:</label>
                                    <input type="date" name="fechaInicio" v-model="inicio" id="fechInicio"
                                        class="form-control">
                                </div>


                                <div class="form-group">
                                    <label for="fechaInicio">Seleccionar fecha de final:</label>
                                    <input type="date" name="fechaFinal" v-model="final" id="fechFinal"
                                        class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="selectDeposito">Seleccionar depósito:</label>
                                    <select name="selectDeposito" id="selectDeposito" class="form-control" v-model="deposito">
                                        <option value=""></option>
                                        <option v-for="deposito of datos.depositos"
                                            v-bind:value="deposito.id"> {{deposito.nombre}}
                                        </option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="selectCategoria">Seleccionar categoría de producto:</label>
                                    <select name="selectCategoria" id="selectCategoria" class="form-control"  v-model="categoria">
                                        <option value=""></option>
                                        <option v-for="categoria of datos.categorias"
                                            v-bind:value="categoria.id"> {{categoria.nombre}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="selectEstadoAlmacen">Seleccionar estado de almacenamiento:</label>
                                    <select name="selectEstadoAlmacen" id="selectEstadoAlmacen" v-model="estado"
                                        class="form-control">
                                        <option value=""></option>
                                        <option v-for="estado of datos.estados" v-bind:value="estado.id">
                                            {{estado.nombre}}
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="selectProgresoMovimineto">Estado o progreso de los movimientos:</label>
                                    <select name="selectProgresoMovimineto" v-model="progreso"
                                        id="selectProgresoMovimineto" class="form-control">
                                        <option value="1">Pendiente</option>
                                        <option value="2">Completo</option>
                                        </option>
                                    </select>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12"><button @click="crearConsulta()"
                                    class="btn btn-info pull-right">Buscar</button>
                                <br>
                                <br>

                                <div class="row">

                                    <div class="col-md-12 small">
                                        <template>
                                            <vue-blob-json-csv file-type="csv" file-name="sample" :data="registros">
                                                <v-btn elevation="2">Download CSV</v-btn>
                                            </vue-blob-json-csv>
                                        </template>


                                        <v-app>
                                            <v-main>
                                                <v-card-title>
                                                    Filtrar:
                                                    <v-spacer></v-spacer>
                                                    <v-text-field v-model="search" type="text"
                                                        label="Criterios de filtro"></v-text-field>
                                                </v-card-title>

                                                <v-data-table :headers="columnas" :items="registros" class="elevation-2"
                                                    :search="search">

                                                    <template v-slot:no-data>
                                                        <v-alert :value="true">
                                                            Lo sentimos, No se encontraron registros.
                                                        </v-alert>
                                                    </template>

                                                </v-data-table>

                                            </v-main>
                                        </v-app>

                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <!--TERMINO CONTENIDO-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



    <?php include VISTA_RUTA . "admininclude/scripts.php"?>

    <script src="/assets/vue/reporteMovimiento.js"></script>

</body>

</html>