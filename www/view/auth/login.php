<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Desposito CTL | Login</title>

    <link rel="icon" type="image/png" href="<?php asset('Imagenes/palet4.png') ?>"/>

    <!-- Bootstrap Core CSS -->
    <link href="<?php asset("bower_components/bootstrap/dist/css/bootstrap.min.css") ?>" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="<?php asset("bower_components/metisMenu/dist/metisMenu.min.css") ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php asset("dist/css/sb-admin-2.css") ?>" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php asset("bower_components/font-awesome/css/font-awesome.min.css") ?>" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php asset('css/stilos.css') ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="iniciob">

<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="text-center">
            <h2><b>Depósito</b></h2>
          </div>
            <div class="login-panel panel panel-default">
                <div class="panel-body">
                  <div class="text-center">
                    Ingrese sus datos.<br><br>
                  </div>
                    <form role="form" action="<?php url("login/ingresar") ?>" method="post">
                        <input value="<?php csrf_token() ?>" name="_token" type="hidden">
                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Usuario" name="usuario" type="text" required autocomplete="off" autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                           <!-- <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Recordarme
                                </label>
                            <!--</div>
                            <!-- Change this to a button or input when using this as a form -->
                            <div class="form-group">
                                <label for="cliente">Seleccionar cliente</label>

                                <select  name="cliente" id="cliente" class="form-control"
                                         required="required">
                                    <?php
                                    $client = new \libreria\ORM\EtORM();
                                    $cliente = $client->ejecutar("sp_lista_cliente");
                                    foreach($cliente as $clientes){ ?>
                                    <option value="<?php echo $clientes['id'] ?>">
                                        <?php echo $clientes['razon_social'] ?>
                                        </option><?php }?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-lg btn-primary btn-block">Ingresar</button>
                            <br>
                            <?php if(Session::has("estado") && Session::has("mensaje")){?>
                            <div class="alert alert-danger">
                            	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            	<strong>Error!</strong> <?php echo Session::get("mensaje") ?>
                            </div>
                            <?php } ?>
                        </fieldset>
                    </form>
                </div>
            </div>
            <!--Aqui colocamos el logo de CTL.-->
            <div>
              <img class="img-responsive container-logo" src="<?php asset('Imagenes/logo-slider.png') ?>"
              width="60%" style="margin:auto">
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="<?php asset("bower_components/jquery/dist/jquery.min.js") ?>"></script>

<!-- Bootstrap Core JavaScript -->
<script src="<?php asset("bower_components/bootstrap/dist/js/bootstrap.min.js") ?>"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="<?php asset("bower_components/metisMenu/dist/metisMenu.min.js") ?>"></script>

<!-- Custom Theme JavaScript -->
<script src="<?php asset("dist/js/sb-admin-2.js") ?>"></script>

</body>

</html>
