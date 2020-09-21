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
                <h1 class="page-header"><?php echo isset($usuario) ? 'Actualizar':'Nuevo' ?> usuario |
                    <a href="<?php url("usuario") ?>" class="btn btn-default">
                        <i class="fa fa-users"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <form action="<?php url("usuario/agregar") ?>" method="post" role="form">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <legend>Datos del usuario</legend>

                            <?php if(isset($usuario)){ ?>
                                <input type="hidden" value="<?php echo $usuario->id ?>" name="usuario_id">
                            <?php } ?>
                            <?php ?>
                            <div class="form-group">
                                <label for="usuario">Usuario</label>
                                <input value="<?php echo isset($usuario) ? $usuario->usuariod:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="usuario" id="usuario" placeholder="Usuario">
                            </div>

                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input value="<?php echo isset($usuario) ? $usuario->email:'' ?>"
                                    required autofocus type="email" class="form-control"
                                       name="email" id="email" placeholder="raul@catalinascenter.com.ar">
                            </div>

                            <div class="form-group">
                                <label for="nombre">Nombre Completo</label>
                                <input value="<?php echo isset($usuario) ? $usuario->nombre:'' ?>"
                                       required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre completo">
                            </div>

                            <div class="form-group">
                                <label for="pwd">Password</label>
                                <input type="password" class="form-control"
                                       name="password" id="pwd">
                            </div>

                            <div class="form-group">
                                <label for="deposito">Seleccionar depósito principal para el usuario</label>

                                <select  name="deposito" id="deposito" class="form-control"
                                         required="required">
                                    <?php
                                    $depo = new \libreria\ORM\EtORM();
                                    $depos = $depo->ejecutar("sp_lista_deposito");
                                    foreach($depos as $dep){ ?>
                                    <option <?php echo  isset($usuario) && $usuario->id_deposito == $dep['id']
                                        ? 'selected':'' ?> value="<?php echo $dep['id'] ?>">
                                        <?php echo $dep['nombre'] ?>
                                        </option><?php }?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($usuario) ? 'Actualizar':'Registrar' ?></button>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <legend>Privilegios del usuario</legend>
                            <div class="form-group">
                                <label>Seleccione los privilegios para el usuario</label>
                                <?php
                                $privis = new \libreria\ORM\EtORM();
                                $privi = $privis->ejecutar("sp_lista_privilegio");
                                foreach($privi as $pri){ ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="<?php echo $pri["nombre"] ?>"
                                               value="<?php echo $pri["id"] ?>"
                                                <?php if(isset($usuario)){
                                                $ver_privi = new \libreria\ORM\EtORM();
                                                $verifica = $ver_privi->ejecutar("sp_verificar_privilegio",array($usuario->id,$pri["id"]));
                                                if(count($verifica) > 0){ ?> checked <?php }} ?> >
                                        <?php echo $pri["nombre"] ?>
                                    </label>
                                </div><?php }?>
                            </div>
                            <br>
                            <legend>Clientes para el usuario</legend>
                            <div class="form-group">
                                <label>Seleccione los clientes para el usuario</label>
                                <?php
                                $clients = new \libreria\ORM\EtORM();
                                $client = $clients->ejecutar("sp_lista_cliente");
                                foreach($client as $clien){ ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="<?php echo $clien["razon_social"] ?>"
                                               value="<?php echo $clien["id"] ?>"
                                                <?php if(isset($usuario)){
                                                $ver_cliente = new \libreria\ORM\EtORM();
                                                $verifica = $ver_cliente->ejecutar("sp_verificar_permiso_cliente",array($usuario->id,$clien["id"]));
                                                if(count($verifica) > 0){ ?> checked <?php }} ?> >
                                        <?php echo $clien["razon_social"] ?>
                                    </label><?php }?>
                                </div>
                            </div>
                            <br>
                            <legend>Acceso a depósitos</legend>
                            <div class="form-group">
                                <label>Seleccione los depósitos con permisos para el usuario</label>
                                <?php
                                $deps = new \libreria\ORM\EtORM();
                                $dep = $deps->ejecutar("sp_lista_deposito");
                                foreach($dep as $depo){ ?>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="<?php echo $depo["nombre"] ?>"
                                               value="<?php echo $depo["id"] ?>"
                                                <?php if(isset($usuario)){
                                                $ver_dep = new \libreria\ORM\EtORM();
                                                $verifica = $ver_dep->ejecutar("sp_verificar_permiso_deposito",array($usuario->id,$depo["id"]));
                                                if(count($verifica) > 0){ ?> checked <?php }} ?> >
                                        <?php echo $depo["nombre"] ?>
                                    </label><?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

        <!--TERMINO CONTENIDO-->

</div>
<!-- /#page-wrapper -->

<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>
