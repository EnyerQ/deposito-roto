
var detalle = angular.module("DetalleAPP", []);
detalle.controller('DetalleControlador', ['$scope', '$http', '$filter', function ($scope, $http, $filter) {

    $scope.id_modelo = "Id del modelo";//carga id_del modelo para los números de serie.
    $scope.ver_modelo = "Algún modelo";//carga el modelo sobre el que vamos a cargar series.
    $scope.categoriaFiltrar = "";//Cargamos la categoria que vamos a estar filtrando.
    $scope.detalles = [];//carga los productos recuperados de la base de datos.
    $scope.detallesAdd = [];//Carga los productos seleccionados.
    $scope.seriesAdd = [];//Se cargan los números de series asociados al movimiento.
    $scope.producto = {};//El objeto producto es para precargar producto seleccionado.
    $scope.url = $("#urlPrincipal").val();//Indica a JS sobre la dirección fija de la APP.
    $scope.ultimo = 'N/A'; //Definimos la variable que va a mostrar el último serie ingresado.
    $scope.cantidadSeries = 0;
    $scope.habilitar = false;
    $scope.foco = false;

    $scope.categorias = [];//Aqui cargaremos el listado de categorias desde un JSON.


    //Función que se encarga de cargar los productos en la varible detalle.
    $scope.cargarDetalle = function () {
        $http.get($scope.url + "producto/todos").then(function ($request) {
            $scope.detalles = $request.data;
        });
    };

    $scope.cargarDetalleSalida = function () {
        $http.get($scope.url + "producto/almacenados/" + $("#origen").val() + "/" + $("#idDeposito").val()).then(function ($request) {
            $scope.detalles = $request.data;
        });
    };

    //Función que se encarga de cargar los productos seleccionados y no repetir los mismos.
    $scope.seleccionarProducto = function ($id_producto, $model, $cate) {
        var prod = $filter("filter")($scope.detalles, {
            id: $id_producto,
            model: $model,
            cate: $cate
        })[0];
        $scope.id_modelo = $id_producto;
        //$scope.cantidadP = $("#cantidadP").val();

        var agregar = true;

        if ($scope.detallesAdd.length == 0) {
            $scope.agregarProducto(prod);
            agregar = false;
        } else {
            angular.forEach($scope.detallesAdd, function (value, key) {
                if (value["id"] == $id_producto) {
                    value.cantidad = $("#cantidadP").val();
                    agregar = false;
                }
            });
        }
        if (agregar) {
            $scope.agregarProducto(prod);
        }

        $scope.cantiDAD = '';

        console.log($scope.detallesAdd);

    }

    //Función que se encarga de cargar los productos seleccionados y no repetir los mismos.
    $scope.seleccionarSalidaProducto = function ($id_producto, $model, $cate, $disponible) {
        var prod = $filter("filter")($scope.detalles, {
            id: $id_producto,
            model: $model,
            cate: $cate
        })[0];
        $scope.id_modelo = $id_producto;
        //$scope.cantidadP = $("#cantidadP").val();

        var agregar = true;

        if ($disponible >= parseInt($('#cantidadP').val())) {
            if ($scope.detallesAdd.length == 0) {
                $scope.agregarProducto(prod);
                agregar = false;
            } else {
                angular.forEach($scope.detallesAdd, function (value, key) {
                    if (value["id"] == $id_producto) {
                        value.cantidad = $("#cantidadP").val();
                        agregar = false;
                    }
                });
            }
            if (agregar) {
                $scope.agregarProducto(prod);
            }
        } else {
            alerta($model, $disponible);
        }

        $scope.cantiDAD = '';

        console.log($scope.detallesAdd);

    }

    //Función para eliminar de la lista de productos, un producto selecionado.

    $scope.eliminarProducto = function (productoR) {
        for (var i = $scope.detallesAdd.length - 1; i >= 0; i--) {
            if ($scope.detallesAdd[i].model == productoR.model) {
                $scope.detallesAdd.splice(i, 1);
            }
        }
    }

    //Función que nos permite eliminar los equipos seriables.
    $scope.eliminarProductoSeriable = function () {
        for (var i = $scope.detallesAdd.length - 1; i >= 0; i--) {
            //Verificamos que el producto sea seriable
            if ($scope.detallesAdd[i].seriable == 1) {
                $scope.detallesAdd.splice(i, 1);
            }
        }
    }

    //Función que nos permite eliminar los equipos seriables.
    $scope.eliminarProductoNoSeriable = function () {
        for (var i = $scope.detallesAdd.length - 1; i >= 0; i--) {
            //Verificamos que el producto sea seriable
            if ($scope.detallesAdd[i].seriable == 0) {
                $scope.detallesAdd.splice(i, 1);
            }
        }
    }

    //Función para la recarga de los series y productos.
    $scope.recargarDetalleMovimiento = function () {
        $scope.verificarEstadoSerie();
        $scope.eliminarProductoNoSeriable();
    }

    //Función de carga de productos seleccionados en la variable detallesAdd.
    $scope.agregarProducto = function (prod) {

        $scope.producto = {
            id: prod.id,
            cate: prod.cate,
            nomcat: prod.nomcat,
            model: prod.model,
            cantidad: $("#cantidadP").val(),
            seriable: prod.seriable
        };

        $scope.detallesAdd.push($scope.producto);
    }

    //Función de carga de productos seleccionados en la variable detallesAdd.
    $scope.agregarProductoSeriable = function (prod) {

        $scope.producto = {
            id: prod.id,
            cate: prod.cate,
            nomcat: prod.nomcat,
            model: prod.model,
            cantidad: 1,
            seriable: prod.seriable
        };

        $scope.detallesAdd.push($scope.producto);
    }

    //Función que se encarga de cargar los productos seleccionados y no repetir los mismos.
    $scope.verificarSerieDuplicado = function (verificarSerie) {
        //Asignamos el valor por default de comprobar.
        var comprobar = true;
        angular.forEach($scope.seriesAdd, function (value, key) {
            //Verificamos sí el serie se encuentra en el objeto.
            if (value.series == verificarSerie) {
                //Asignamos el valor false, ya que el serie fue encontrado en el objeto.
                comprobar = false;
                //Recuperamos el control sobre el input
            }
        });

        //Verificamos si el serie es duplicado.
        if (comprobar) {
            //Verificamos que el input o campo de serie no esta vacio.
            if (verificarSerie != "") {
                //Agregamos el número de serie.
                $scope.agregarSerie(verificarSerie);
            } else {
                $("#nuSerie").attr('disabled', false);
                $("#nuSerie").focus();
            }

        } else {
            $("#nuSerie").attr('disabled', false);
            $("#nuSerie").focus();
        }

    }


    //Función que carga la variable id_modelo, con el id del producto seleccionado.
    $scope.verId_Modelo = function (idModel, verModelo) {
        $scope.ver_modelo = verModelo;
        $scope.id_modelo = idModel;
    };

    //Función que carga el número de serie sobre la variable seriesAdd.
    $scope.agregarSerie = function (valorSerie) {
        //Recuperamos el serie y lo cargamos en un variable.
        $scope.serieEnviado = valorSerie;
        //Cargamos el ultimo serie agregado.
        $scope.ultimo = valorSerie;

        //Hacemos uso de ajax para recuperar el estado del serie
        $http.post($scope.url + 'seguimiento/recuperarSerie',
            {
                numeroSerie: $scope.serieEnviado,
                idDeposito: $("#idDeposito").val(),
                tipoMovimiento: $("#tipoMovimiento").val(),
                origenMovimiento: $("#origenMovimiento").val(),
                destinoMovimiento: $("#destinoMovimiento").val()
            }).success(function (respuesta) {
                $scope.serie = {
                    id: $scope.id_modelo,
                    series: $scope.serieEnviado,
                    idModelo: respuesta.idModelo,
                    modelo: respuesta.modelo,
                    categoria: respuesta.categoria,
                    categoriaCodigo: respuesta.categoriaCodigo,
                    estado: respuesta.respuesta,
                    color: respuesta.color,
                    icono: respuesta.icono,
                };

                $scope.seriesAdd.push($scope.serie);

                if (respuesta.respuesta == 'OK') {
                    $scope.cargarSeriables(respuesta.idModelo, respuesta.modelo, respuesta.categoriaCodigo, respuesta.categoria);
                }

                $scope.cantidadSeries = $scope.seriesAdd.length;

                console.log($scope.seriesAdd);

                $("#nuSerie").attr('disabled', false);
                $("#nuSerie").focus();

            });
    }

    //Definimos la función para agregar los números de serie recuperados por un cierre
    $scope.agregarSerieCierre = function (serieAgregar) {
        //Recuperamos el serie y lo cargamos en un variable.

        //Hacemos uso de ajax para recuperar el estado del serie
        $http.post($scope.url + 'seguimiento/recuperarSerie',
            {
                numeroSerie: serieAgregar,
                idDeposito: $("#idDeposito").val(),
                tipoMovimiento: $("#tipoMovimiento").val(),
                origenMovimiento: $("#origenMovimiento").val(),
                destinoMovimiento: $("#destinoMovimiento").val()
            }).success(function (respuesta) {
                $scope.serie = {
                    id: $scope.id_modelo,
                    series: serieAgregar,
                    idModelo: respuesta.idModelo,
                    modelo: respuesta.modelo,
                    categoria: respuesta.categoria,
                    categoriaCodigo: respuesta.categoriaCodigo,
                    estado: respuesta.respuesta,
                    color: respuesta.color,
                    icono: respuesta.icono,
                };

                $scope.seriesAdd.push($scope.serie);

                if (respuesta.respuesta == 'OK') {
                    $scope.cargarSeriables(respuesta.idModelo, respuesta.modelo, respuesta.categoriaCodigo, respuesta.categoria);
                }


                console.log($scope.seriesAdd);


            });
    }


    //Función que controla si se presiona la tecla enter en el input de los series.
    $scope.myFunct = function (keyEvent) {
        if (keyEvent.which === 13) {
            if ($scope.numSerie != '') {
                $("#nuSerie").attr('disabled', true);
                console.log($scope.habilitar);
                $scope.verificarSerieDuplicado($scope.numSerie.trim());
                //borramos el valor del elemento HTML;
                $scope.numSerie = '';
            }
        }
    }

    //Busca caracter seleccionado en los seies y lo elimina

    $scope.eliminarCaracter = function () {
        //Eliminamos los equipos seriables del listado de productos.
        $scope.eliminarProductoSeriable();
        //Recorremos los series y recargamos en caso de ser necesario
        angular.forEach($scope.seriesAdd, function (value, key) {
            if (value.id == $scope.id_modelo) {
                value.series = value.series.replace($("#eCaracter").val(), "");

                //Verificamos el nuevo número de serie.
                //Hacemos uso de ajax para recuperar el estado del serie
                $http.post($scope.url + 'seguimiento/recuperarSerie',
                    {
                        numeroSerie: value.series,
                        idDeposito: $("#idDeposito").val(),
                        tipoMovimiento: $("#tipoMovimiento").val(),
                        origenMovimiento: $("#origenMovimiento").val(),
                        destinoMovimiento: $("#destinoMovimiento").val()
                    }).success(function (respuesta) {
                        value.modelo = respuesta.modelo;
                        value.idModelo = respuesta.idModelo;
                        value.categoria = respuesta.categoria;
                        value.categoriaCodigo = respuesta.categoriaCodigo;
                        value.estado = respuesta.respuesta;
                        value.color = respuesta.color;
                        value.icono = respuesta.icono;
                        //Cargamos los números de serie que estan verificados y disponibles
                        if (respuesta.respuesta == 'OK') {
                            $scope.cargarSeriables(respuesta.idModelo, respuesta.modelo, respuesta.categoriaCodigo, respuesta.categoria);
                        }

                    });
            }
        })
        $scope.eCaracter = "";
    }

    //Definimos el modulo para volver a validar los números de serie
    $scope.verificarEstadoSerie = function () {
        $scope.eliminarProductoSeriable();
        //Recorremos el json de números de serie
        angular.forEach($scope.seriesAdd, function (value, key) {
            if (value.id == $scope.id_modelo) {
                //Verificamos el nuevo número de serie.
                //Hacemos uso de ajax para recuperar el estado del serie
                $http.post($scope.url + 'seguimiento/recuperarSerie',
                    {
                        numeroSerie: value.series,
                        idDeposito: $("#idDeposito").val(),
                        tipoMovimiento: $("#tipoMovimiento").val(),
                        origenMovimiento: $("#origenMovimiento").val(),
                        destinoMovimiento: $("#destinoMovimiento").val()
                    }).success(function (respuesta) {
                        value.modelo = respuesta.modelo;
                        value.idModelo = respuesta.idModelo;
                        value.categoria = respuesta.categoria;
                        value.categoriaCodigo = respuesta.categoriaCodigo;
                        value.estado = respuesta.respuesta;
                        value.color = respuesta.color;
                        value.icono = respuesta.icono;

                        //Cargamos los números de serie que estan verificados y disponibles
                        if (respuesta.respuesta == 'OK') {
                            $scope.cargarSeriables(respuesta.idModelo, respuesta.modelo, respuesta.categoriaCodigo, respuesta.categoria);
                        }
                    });
            }
        })
    }

    //Recuperamos los productos que son seriables para listarlos en el selector
    //Función que se encarga de cargar los productos en la varible detalle.
    $scope.cargarProductosSeriables = function () {
        $http.get($scope.url + "producto/todos").then(function ($request) {
            $scope.detalles = $request.data;
        });
    };

    //Elimine y nos carga el número de serie selecionado para ser editado.
    //El número de serie seleccionado se cargado sobre el input de carga.
    $scope.editarSerie = function (numeroSerie, serieR) {
        angular.forEach($scope.seriesAdd, function (value, key) {
            if (value.series == numeroSerie) {
                $scope.numSerie = value.series;
                $scope.eliminarSerie(serieR);
            }
        })
        $scope.eCaracter = "";
    }

    //Elimina un número de serie seelcionado.
    $scope.eliminarSerie = function (seriesR) {
        for (var i = $scope.seriesAdd.length - 1; i >= 0; i--) {
            if ($scope.seriesAdd[i].series == seriesR.series) {
                $scope.ultimo = seriesR.series + ' (eliminado)';
                $scope.seriesAdd.splice(i, 1);
                $scope.cantidadSeries = $scope.seriesAdd.length;
                //Verificamos los números de serie.
                $scope.verificarEstadoSerie();
            }
        }
    }

    $scope.recuperarDetalles = function () {
        //Variable que almacena el id del movimiento.
        $scope.id_movimiento = $("#movimiento_id").val();
        //Recuperamos los poructos y cantidades.
        $http.get($scope.url + "producto/detalle/" + $scope.id_movimiento).then(function ($request) {
            $scope.detallesAdd = $request.data;
        });
        //Recuperamos los series involucrados.
        $http.get($scope.url + "producto/serie/" + $scope.id_movimiento).then(function ($request) {
            $scope.seriesAdd = $request.data;
        });
    }

    //Recuperar detalle de movimineto por un ID
    $scope.recuperarDetallesId = function () {
        //Variable que almacena el id del movimiento.
        $scope.id_movimiento = $("#idDetalles").val();

        //Recuperamos los poructos y cantidades.
        $http.get($scope.url + "producto/detalle_id/" + $scope.id_movimiento).then(function ($request) {
            $scope.detallesAdd = $request.data;
        });
        //Recuperamos los series involucrados.
        $http.get($scope.url + "producto/serie/" + $scope.id_movimiento).then(function ($request) {
            $scope.seriesAdd = $request.data;
        });
        $scope.idDeta = "";
    }

    //Esto es una prueba
    $scope.seleccionar = function ($id_producto, $model, $cate) {
        var prod = $filter("filter")($scope.detalles, {
            id: $id_producto,
            model: $model,
            cate: $cate
        })[0];
        $scope.id_modelo = prod.id;
        //$scope.cantidadP = $("#cantidadP").val();

        var agregar = true;

        if ($scope.detallesAdd.length == 0) {
            $scope.agregarProducto(prod);
            agregar = false;
        } else {
            angular.forEach($scope.detallesAdd, function (value, key) {
                if (value["id"] == $id_producto) {
                    value.cantidad = $("#cantidadP").val();
                    agregar = false;
                }
            });
        }
        if (agregar) {
            $scope.agregarProducto(prod);
        }

        $scope.cantiDAD = '';

        console.log($scope.detallesAdd);

    }

    //Cargamos los equipos seriables
    $scope.cargarSeriables = function ($id_producto, $model, $cate, $categoria) {
        var prod = {
            id: $id_producto,
            model: $model,
            cate: $cate,
            nomcat: $categoria,
            seriable: 1,
        };
        //$scope.cantidadP = $("#cantidadP").val();

        var agregar = true;

        if ($scope.detallesAdd.length == 0) {
            $scope.agregarProductoSeriable(prod);
            agregar = false;
        } else {
            angular.forEach($scope.detallesAdd, function (value, key) {
                if (value["id"] == $id_producto) {
                    value.cantidad++;
                    agregar = false;
                }
            });
        }
        if (agregar) {
            $scope.agregarProductoSeriable(prod);
        }

        $scope.cantiDAD = '';

        console.log($scope.detallesAdd);

    }


    //Función que nos permite cerrar los lamacenes.
    $scope.generarCierre = function () {
        //Borramos los números de serie que esten asignados.
        $scope.seriesAdd = [];
        //Variable que almacena el id del origen.
        $scope.id_origen = $("#origenMovimiento").val();
        //Recuperamos los poructos y cantidades.
        $http.get($scope.url + "producto/cerrar/" + $scope.id_origen).then(function ($request) {
            $scope.detallesAdd = $request.data;
        });

        //Recuperamos los series involucrados.
        $http.get($scope.url + "producto/cerrarserie/" + $scope.id_origen).then(function ($request) {
            //Recorremos el objeto recuperado.
            angular.forEach($request.data, function (value, key) {
                //Agregamos el número de serie recuperado.
                $scope.agregarSerieCierre(value['series']);
            });
        });
    }

    $scope.cargarProductosSeriables();

}]);
