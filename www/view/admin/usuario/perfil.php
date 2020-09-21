<!DOCTYPE html>
<html lang="es">

<head>

    <?php include(VISTA_RUTA."admininclude/head.php") ?>

</head>

<body>

<div id="wrapper" ng-app="PerfilAPP" ng-controller="PerfilControlador">

    <!-- Navigation -->
    <?php include(VISTA_RUTA."admininclude/menu.php") ?>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Perfil usuario |
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Editar perfil</legend>

                        <?php if (isset($usuario)) { ?>
                            <input type="hidden" value="<?php echo $usuario->id ?>" name="usuario_id">
                        <?php } ?><!--
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Dato</th>
                                <th>Usuraio</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <?php ?>
                                    Usuario:
                                </td>
                                <td>
                                    <?php echo $usuario->usuariod ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                            data-target="#cambiarUsuario"><i class="fa fa-gear"></i> Editar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Email:
                                </td>
                                <td>
                                    <?php echo $usuario->email ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                            data-target="#cambiarEmail"><i class="fa fa-gear"></i> Editar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Nombre completo:
                                </td>
                                <td>
                                    <?php echo $usuario->nombre ?>
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-sm" type="button" data-toggle="modal"
                                            data-target="#cambiarNombre"><i class="fa fa-gear"></i> Editar
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Deposito:
                                </td>
                                <td>
                                    <?php
                                    $depo = new \libreria\ORM\EtORM();
                                    $depos = $depo->ejecutar("sp_lista_deposito");
                                    foreach ($depos as $dep) {
                                        echo isset($usuario) && $usuario->id_deposito == $dep['id']
                                            ? $dep['nombre'] : '';
                                    } ?>
                                </td>
                                <td>

                                </td>
                            </tr>
                            </tbody>
                        </table>-->
                        <button class="btn btn-success btn-sm" type="button" data-toggle="modal"
                                data-target="#cambiarPassword"><i class="fa fa-lock"></i> Cambiar password
                        </button>
                        <br><br/>
                        <?php if(Session::has("mensaje")){?>
                            <div class="alert alert-<?php echo Session::get("alert") ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <strong><?php echo Session::get("tipo") ?> </strong> <?php echo Session::get("mensaje") ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <legend>Privilegios del usuario</legend>
                        <div class="form-group">
                            <?php
                            $privis = new \libreria\ORM\EtORM();
                            $privi = $privis->ejecutar("sp_lista_privilegio");
                            foreach ($privi as $pri) { ?>
                                <div>
                                <label>
                                    <?php if (isset($usuario)) {
                                        $ver_privi = new \libreria\ORM\EtORM();
                                        $verifica = $ver_privi->ejecutar("sp_verificar_privilegio", array($usuario->id, $pri["id"]));
                                        if (count($verifica) > 0) {
                                            echo $pri["nombre"];
                                        }
                                    } ?>
                                </label>
                                </div><?php } ?>
                        </div>
                        <br>
                        <legend>Clientes</legend>
                        <div class="form-group">
                            <?php
                            $clients = new \libreria\ORM\EtORM();
                            $client = $clients->ejecutar("sp_lista_cliente");
                            foreach ($client as $clien) { ?>
                                <div>
                                <label>
                                    <?php if (isset($usuario)) {
                                        $ver_cliente = new \libreria\ORM\EtORM();
                                        $verifica = $ver_cliente->ejecutar("sp_verificar_permiso_cliente", array($usuario->id, $clien["id"]));
                                        if (count($verifica) > 0) {
                                            echo $clien["razon_social"];
                                        }
                                    } ?>
                                </label>
                                </div><?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Aquí tenemos el modal para cambiar usuario-->
    <div class="modal fade" id="cambiarUsuario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" id="usuario" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cambiar nombre de usuario</h4>
                </div>
                <!-- Modal cuerpo -->
                <form action="<?php url("login/cambiarUser")?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                Ingrese su password:
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" ng-blur="compararCasillasUser()" class="form-control"
                                           required name="user1" id="user1"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                Ingrese un nuevo nombre de usuario:
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{classInput}}">
                                    <input type="text" ng-keyup="compararCasillasUser()" class="form-control"
                                           required name="user2" id="user2" minlength="8"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                Vuelva a ingresar nuevo usuario:
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{classInput}}">
                                    <input type="text" ng-keyup="compararCasillasUser()" class="form-control"
                                           required name="user3" id="user3" minlength="8"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="{{classMensaje}}">{{mensaje}}</p>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-lg btn-danger btn-block  {{enabledBtn}}"><i class="fa {{candado}}"></i> Cambiar</button>
                    </div>
                </form>
                <!-- Fin Modal cuerpo -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="borrarMensajes()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Aquí tenemos el modal para cambiar email-->
    <div class="modal fade" id="cambiarEmail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" id="email" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar E-Mail</h4>
                </div>
                <!-- Modal cuerpo -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="text-info">¡Función no disponible!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Modal cuerpo -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Aquí tenemos el modal para cambiar nombre completo-->
    <div class="modal fade" id="cambiarNombre" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" id="nombre" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Editar nombre completo</h4>
                </div>
                <!-- Modal cuerpo -->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="text-info">¡Función no disponible!</div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin Modal cuerpo -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Aquí tenemos el modal para cambiar nombre completo-->
    <div class="modal fade" id="cambiarPassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" id="nombre" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Cambiar Contraseña (PASSWORD)</h4>
                </div>
                <!-- Modal cuerpo -->
                <form action="<?php url("login/cambiarPassword")?>" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                Ingrese su password actual:
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="password" ng-blur="compararCasillasPass()" class="form-control"
                                           required name="pass1" id="pass1"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                Ingrese un nuevo password:
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{classInput}}">
                                    <input type="password" ng-keyup="compararCasillasPass()" class="form-control"
                                           required name="pass2" id="pass2" minlength="8"/>
                                </div>
                            </div>

                            <div class="col-md-6">
                                Vuelva a ingresar nuevo password:
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{classInput}}">
                                    <input type="password" ng-keyup="compararCasillasPass()" class="form-control"
                                           required name="pass3" id="pass3" minlength="8"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <p class="{{classMensaje}}">{{mensaje}}</p>
                            </div>
                        </div>
                        <br>
                        <button type="submit" class="btn btn-lg btn-danger btn-block  {{enabledBtn}}"><i class="fa {{candado}}"></i> Cambiar</button>
                    </div>
                </form>
                <!-- Fin Modal cuerpo -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" ng-click="borrarMensajes()">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!--TERMINO CONTENIDO-->

</div>
<!-- /#page-wrapper -->

<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>
