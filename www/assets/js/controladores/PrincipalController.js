var app = angular.module('seleccion', [])

app.controller('ControladorTab', ['$scope','$http','$filter',function($scope, $http, $filter){
    $scope.eleccion = 'asignado';
    $scope.noDisponibles = [];
    $scope.Cambiotab = function(nombreTab){

        $scope.eleccion = nombreTab;
        if($scope.eleccion == 'nodisponible'){
            $scope.recuperarNoDisponibles();

            console.log($scope.noDisponibles);
        }
    }

    $scope.recuperarNoDisponibles = function(){
        $http.get($scope.url + "stock/nodisponible").then(function ($request) {
            $scope.noDisponibles = $request.data;
        });
    }

}])

app.controller('DetalleControlador',function($scope){
    $scope.detalle = 'deta0';
    $scope.verDetalle = function(idMovimiento){

        if($scope.detalle == idMovimiento){
            $scope.detalle = 'deta0';
        }else{
            $scope.detalle = idMovimiento;
        }
    }
});

app.controller('ModeloControlador',['$scope','$http','$filter',function($scope, $http, $filter){

    $scope.modelos = [];
    $scope.url = $("#urlPrincipal").val();


    $scope.cargarDetalle = function (estado,categoria) {
        $http.get($scope.url + "stock/modelos/" + estado + "/" + categoria ).then(function ($request) {
            $scope.modelos = $request.data;
        });
    };

}]);
