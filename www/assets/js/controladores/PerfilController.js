var perfil = angular.module("PerfilAPP",[]);
perfil.controller('PerfilControlador',['$scope','$http','$filter',function($scope, $http, $filter){
    $scope.igualarClave = "false";
    $scope.classInput = "";
    $scope.enabledBtn = "disabled";
    $scope.mensaje = "";
    $scope.classMensaje = "";
    $scope.candado = "fa-lock";

    //Compara las casillas para cambiar el password(Contraseña).
    $scope.compararCasillasPass = function(){
        if($("#pass2").val()==$("#pass3").val()&& $("#pass3").val()!="" && $("#pass1").val()!=""){
            $scope.classInput = "has-success";
            $scope.igualarClave = "false";
            $scope.enabledBtn = "";
            $scope.mensaje = "Ya puede cambiar la contraseña";
            $scope.classMensaje = "text-success";
            $scope.candado = "fa-unlock-alt";
        }else{
            $scope.classInput = "has-error";
            $scope.igualarClave = "true";
            $scope.enabledBtn = "disabled";
            $scope.mensaje = "Las contraseñas son diferentes o no completo todos los campos";
            $scope.classMensaje = "text-danger";
            $scope.candado = "fa-lock";
        }
    }
    //Compara las casillas para cambiar el nombre de usuario.
    $scope.compararCasillasUser = function(){
        if($("#user2").val()==$("#user3").val()&& $("#user3").val()!="" && $("#user1").val()!=""){
            $scope.classInput = "has-success";
            $scope.igualarClave = "false";
            $scope.enabledBtn = "";
            $scope.mensaje = "Ya puede cambiar el usuario";
            $scope.classMensaje = "text-success";
            $scope.candado = "fa-unlock-alt";
        }else{
            $scope.classInput = "has-error";
            $scope.igualarClave = "true";
            $scope.enabledBtn = "disabled";
            $scope.mensaje = "Los nombres de usuario son diferentes o no completo todos los datos";
            $scope.classMensaje = "text-danger";
            $scope.candado = "fa-lock";
        }
    }
    //Borra mensajes en variables.
    $scope.borrarMensajes = function(){
        $scope.igualarClave = "false";
        $scope.classInput = "";
        $scope.enabledBtn = "disabled";
        $scope.mensaje = "";
        $scope.classMensaje = "";
        $scope.candado = "fa-lock";
    }
}]);