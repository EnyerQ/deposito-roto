var app = angular.module('series', [])

app.controller('ControladorSeries', ['$scope','$http','$filter',function($scope, $http, $filter){
    $scope.eleccion = 'asignado';
    $scope.noDisponibles = [];
    $scope.url = $("#urlPrincipal").val();//Indica a JS sobre la dirección fija de la APP.
    $scope.mostrar = false;
    $scope.mostrar2 = false;
    $scope.Cambiotab = function(nombreTab){

        $scope.eleccion = nombreTab;
        if($scope.eleccion == 'nodisponible'){
            $scope.recuperarNoDisponibles();

            console.log($scope.noDisponibles);
        }
    }

    $scope.recuperarSeries = function(cliente,destino,categoria,estado){
        $scope.mostrar2 = false;

        $http.get($scope.url + "seguimiento/serieEstado/" + cliente + "/" + destino + "/" + categoria + "/" + estado).then(function ($request) {
            $scope.noDisponibles = $request.data;
        });

        $scope.mostrar = true;
    }

    $scope.recuperarDetalle = function(cliente,destino,categoria,progreso,estado){
        $scope.mostrar = false;

        $http.get($scope.url + "seguimiento/noSeriables/" + cliente + "/" + destino + "/" + categoria + "/" + progreso + "/" + estado).then(function ($request) {
            $scope.noDisponibles = $request.data;
        });

        $scope.mostrar2 = true;
    }

}]);
