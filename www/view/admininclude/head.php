<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title><?php if(isset($tituloPagina)){echo $tituloPagina;} ?> - <?php echo $_SESSION['razon_social'] ?> </title>

<link rel="icon" type="image/png" href="<?php asset('Imagenes/LogoCTL3.png') ?>" />

<link href="<?php asset('bower_components/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
<!-- Estilos del menu-->
<link href="<?php asset('bower_components/metisMenu/dist/metisMenu.min.css') ?>" rel="stylesheet">
<!-- Aqui tenemos los bootstrap table-->
<link href="<?php asset('datatables-plugins/dataTables.bootstrap.css') ?>" rel="stylesheet">
<link href="<?php asset('datatables-responsive/dataTables.responsive.css') ?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
<!-- Estilo general de la APP-->
<link href="<?php asset('dist/css/sb-admin-2.css') ?>" rel="stylesheet">

<link href="<?php asset('css/jquery-confirm.min.css') ?>" rel="stylesheet">
<link href="<?php asset('css/modal.css') ?>" rel="stylesheet">

<link href="<?php asset('bower_components/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php asset('css/stilos.css') ?>">


<link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">