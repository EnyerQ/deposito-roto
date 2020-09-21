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
                <h1 class="page-header"><?php echo isset($destino) ? 'Actualizar':'Nuevo' ?> destino |
                    <a href="<?php url("destino/index") ?>" class="btn btn-default">
                        <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!--INICIO CONTENIDO-->

        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form action="<?php url("destino/agregar") ?>" method="post" role="form">
                            <legend>Datos del destino</legend>

                            <?php if(isset($destino)){ ?>
                                <input type="hidden" value="<?php echo $destino->id ?>" name="destino_id">
                            <?php } ?>
                            
                            <!--Creamos el campo para ingresar el nombre del destino.-->

                            <div class="form-group">
                                <label for="nombre">Nombre</label>
                                <input value="<?php echo isset($destino) ? $destino->nombre:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="nombre" id="nombre" placeholder="Nombre del destino">
                            </div>

                            <!---->
                            
                            <!--Creamos el selector para los tipos de destino.-->

                            <div class="form-group">
                                <label for="tipo">Seleccionar tipo</label>

                                <select  name="tipo" id="tipo" class="form-control"
                                         required="required">
                                    <?php
                                    $tipo = new \libreria\ORM\EtORM();
                                    $tipos = $tipo->ejecutar("sp_lista_tipo_cliente",array($_SESSION['cliente']));
                                    foreach($tipos as $tip){ ?>
                                    <option <?php echo  isset($destino) && $destino->id_tipo_cliente == $tip['id']
                                        ? 'selected':'' ?> value="<?php echo $tip['id'] ?>">
                                        <?php echo $tip['nombre'] ?>
                                        </option><?php }?>
                                </select>
                            </div>

                            <!--Creamos el selector para registrar la zona del destino en cuestión-->

                            <div class="form-group">
                                <label for="zona">Seleccione la zona</label>

                                <select name="zona" id="zonal" class="form-control" required>
                                    <option value=""></option>
                                    <option value="SUR" <?php if(isset($destino) && $destino->zona == 'SUR'){echo 'selected';} ?>>SUR</option>
                                    <option value="OESTE" <?php if(isset($destino) && $destino->zona == 'OESTE'){echo 'selected';} ?>>OESTE</option>
                                    <option value="NORTE" <?php if(isset($destino) && $destino->zona == 'NORTE'){echo 'selected';} ?>>NORTE</option>
                                    <option value="CABA" <?php if(isset($destino) && $destino->zona == 'CABA'){echo 'selected';} ?>>CABA</option>
                                </select>
                            </div>

                            <!--Creamos el campo para el registro de la dirección del destino-->

                            <div class="form-group">
                                <label for="descripcion">Dirección</label>
                                <input value="<?php echo isset($destino) ? $destino->descripcion:'' ?>"
                                    required autofocus type="text" class="form-control"
                                       name="descripcion" id="descripcion" placeholder="Descripción del destino">
                            </div>

                            <!--Creamos el boton de submit para el registro.-->

                            <button type="submit" class="btn btn-primary">
                                <?php echo isset($destino) ? 'Actualizar':'Registrar' ?></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!--TERMINO CONTENIDO-->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<?php include(VISTA_RUTA."admininclude/scripts.php") ?>

</body>

</html>