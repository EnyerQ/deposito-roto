<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">

<head>

    <?php include(VISTA_RUTA . "admininclude/head.php") ?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <?php include(VISTA_RUTA . "admininclude/menu.php") ?>

        <div id="page-wrapper" ng-app="DetalleAPP" ng-controller="DetalleControlador">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"> Informe Salida |
                        <a href="<?php url("salida/index") ?>" class="btn btn-default">
                            <i class="fa fa-dropbox"></i> Ver Listado</a> </h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!--INICIO CONTENIDO-->
            <div class="panel panel-red col-lg-12">
                <div class="row">
                    <div class="col-md-6">
                        <br>
                        <div class="panel panel-default col-md-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Remito:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->remito ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarRemito">Editar</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Fecha pedido:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->fecha_pedido ?>
                                        </td>
                                        <td>
                                            <?php if (false) { ?>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarFecha">Editar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    
                                    <tr>
                                        <td>
                                            <b>Fecha:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->fecha ?>
                                        </td>
                                        <td>
                                            <?php if (false) { ?>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarFecha">Editar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    
                                    <tr>
                                        <td>
                                            <b>Fecha ultima acción:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->fecha_modificacion ?>
                                        </td>
                                        <td>
                                            <?php if (false) { ?>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarFecha">Editar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td>
                                            <b>Origen:</b>
                                        </td>
                                        <td>
                                            <?php
                                            $ori = new libreria\ORM\EtORM();
                                            $origen_nombre = $ori->Ejecutar('sp_buscar_destino', array($salida->id_origen, $_SESSION['cliente']));
                                            echo $origen_nombre[0]['nombre'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (false) { ?>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarOrigen">Editar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Destino:</b>
                                        </td>
                                        <td>
                                            <?php
                                            $des = new libreria\ORM\EtORM();
                                            $destino_nombre = $des->Ejecutar('sp_buscar_destino', array($salida->id_destino, $_SESSION['cliente']));
                                            echo $destino_nombre[0]['nombre'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (false) { ?>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarDestino">Editar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Estado equipos:</b>
                                        </td>
                                        <td>
                                            <?php
                                            $est = new libreria\ORM\EtORM();
                                            $estado_nombre = $est->Ejecutar('sp_buscar_estado', array($salida->id_sub_estado, $_SESSION['cliente']));
                                            echo $estado_nombre[0]['nombre'];
                                            ?>
                                        </td>
                                        <td>
                                            <?php if (false) { ?>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarEstado">Editar</button>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <br>
                    <div class="col-md-6">
                        <div class="panel panel-default col-md-12">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <td>
                                            <b>Comentario:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->comentario ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarComentario">Editar</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Ticket:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->ticket ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarTicket">Editar</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>Estado Movimiento:</b>
                                        </td>
                                        <td>
                                            <?php
                                            if ($salida->progreso == 1) {
                                                echo "Pendiente";
                                            } elseif ($salida->progreso == 2) {
                                                echo "Completo";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarEstadoFinal">Editar</button>
                                        </td>
                                    </tr>
                                    <?php if ($salida->id_origen == 1 || $salida->id_origen == 190) { ?>
                                    <tr>
                                        <td>
                                            <b>Equipos consumidos:</b>
                                        </td>
                                        <td>
                                            <?php echo $salida->consumido ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-primary btn-sm pull-right" data-toggle="modal"
                                                data-target="#cambiarConsumo">Editar</button>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-red col-lg-12">
                <h3>Detalle del movimiento</h3>
                <br>
                Asignado en el deposito
                <?php
                $depo = new libreria\ORM\EtORM();
                $deposito_nombre = $depo->Ejecutar('sp_buscar_deposito', array($salida->id_deposito));
                echo $deposito_nombre[0]['nombre'];
                ?>, del almacén:
                <?php
                $ori = new libreria\ORM\EtORM();
                $origen_nombre = $ori->Ejecutar('sp_buscar_destino', array($salida->id_origen, $_SESSION['cliente']));
                echo $origen_nombre[0]['nombre'];
                ?>
                <br><br>
                <?php
                foreach ($productos as $producto) {
                    echo $producto['cantidad'] . " " . $producto['nomcat'] . " (" .
                        $producto['cate'] . ") Modelo " . $producto['model'] . "<br>";
                    $prod = new libreria\ORM\EtORM();
                    $series = $prod->ejecutar("sp_series_informe", array($producto['id'], $salida_id));
                    foreach ($series as $serie) {
                        echo $serie['serie'] . "<br>";
                    }
                    echo "<br>";
                }
                ?>

                                
<br><br><h3>Series para cargar</h3>
                <?php
                foreach ($productos as $producto) {
                    $prod = new libreria\ORM\EtORM();
                    $series = $prod->ejecutar("sp_series_informe", array($producto['id'], $salida_id));
                    foreach ($series as $serie) {
                        echo $serie['serie'] . ", ";
                    }
                    echo "<br>";
                }
                ?>


                <br>
                <?php echo nl2br($salida->comentario) ?>
                <br>
                <br>
            </div>

            <!-- Modal editar remito o referencia-->
            <div class="modal fade" id="cambiarRemito" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="remito" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/remito/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el número de remito o referencia</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        Ingrese el remito o referencia:
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="remito" id="remito"
                                                value="<?php echo $salida->remito ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar fecha-->
            <div class="modal fade" id="cambiarFecha" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="fecha" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/fecha/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar la fecha del registro</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="fecha">Fecha</label>

                                            <input class="form-control" id="fecha" name="fecha" type="date"
                                                value="<?php echo isset($salida) ? $salida->fecha : date("Y-m-d") ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar origen-->
            <div class="modal fade" id="cambiarOrigen" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="origen" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/origen/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el Origen</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="origen">Origen</label>

                                            <select name="origen" id="origen" class="form-control" required="required">
                                                <option value=""></option>
                                                <?php
                                                $ori = new libreria\ORM\EtORM();
                                                $origen = $ori->ejecutar("sp_estado_stock", array($_SESSION['cliente']));
                                                foreach ($origen as $origenes) { ?>
                                                <option <?php echo isset($salida) && $salida->id_origen == $origenes['id']
                                                                    ? 'selected' : '' ?>
                                                    value="<?php echo $origenes['id'] ?>">
                                                    <?php echo ($origenes['nombre']); ?>
                                                </option><?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar destino-->
            <div class="modal fade" id="cambiarDestino" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="destino" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarDestino/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el Destino</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="destino">Destino</label>

                                            <select name="destino" id="destino" class="form-control"
                                                required="required">
                                                <option value=""></option>
                                                <?php
                                                if (isset($salida)) {
                                                    $tipo = $salida->interviene;
                                                } else {
                                                    if (isset($_SESSION['origen'])) {
                                                        $tipo = $_SESSION['origen'];
                                                        unset($_SESSION['origen']);
                                                    }
                                                }
                                                $des = new libreria\ORM\EtORM();
                                                $destino = $des->ejecutar("sp_entrada_origen", array($_SESSION['cliente'], $tipo));
                                                foreach ($destino as $destinos) { ?>
                                                <option <?php echo isset($salida) && $salida->id_destino == $destinos['id']
                                                                    ? 'selected' : '' ?>
                                                    value="<?php echo $destinos['id'] ?>">
                                                    <?php echo ($destinos['nombre']); ?>
                                                </option><?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar estado equipos-->
            <div class="modal fade" id="cambiarEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="estado" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarEstado/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el estado de los equipos</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="sub_estado">Estado equipos</label>

                                            <select name="sub_estado" id="sub_estado" class="form-control"
                                                required="required">
                                                <option value=""></option>
                                                <?php
                                                $sub_est = new libreria\ORM\EtORM();
                                                $sub_estado = $sub_est->ejecutar("sp_estado_movimiento", array($_SESSION['cliente']));
                                                foreach ($sub_estado as $sub_estados) { ?>
                                                <option <?php echo isset($salida) && $salida->id_sub_estado == $sub_estados['id']
                                                                    ? 'selected' : '' ?>
                                                    value="<?php echo $sub_estados['id'] ?>">
                                                    <?php echo ($sub_estados['nombre']); ?>
                                                </option><?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar Observación-->
            <div class="modal fade" id="cambiarObservacion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="observacion" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarObservacion/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar la Observación</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        Ingrese la observación:
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="observacion"
                                                id="observacion" value="<?php echo $salida->observacion ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar comentario-->
            <div class="modal fade" id="cambiarComentario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="comentario" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarComentario/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar los Comentarios</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        Ingrese los comentarios:
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <textarea class="form-control" rows="5" name="comentario" id="comentario"><?php echo $salida->comentario ?>
                                        </textarea>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar ticket u orden de compra-->
            <div class="modal fade" id="cambiarTicket" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="ticket" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarTicket/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el Ticket u Orden de Compra</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        Ingrese el ticket u orden de compra:
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" required name="ticket" id="ticket"
                                                value="<?php echo $salida->ticket ?>" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar estado movimiento y equipos-->
            <div class="modal fade" id="cambiarEstadoFinal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="estadoFinal" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarEstadoFinal/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el estado del movimiento y de los
                                    equipos</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="sub_estado">Estado equipos</label>

                                            <select name="sub_estado" id="sub_estado" class="form-control"
                                                required="required">
                                                <option value=""></option>
                                                <?php
                                                foreach ($subEstados as $estado) { ?>
                                                <option <?php echo isset($salida) && $salida->id_sub_estado == $estado['id']
                                                                    ? 'selected' : '' ?>
                                                    value="<?php echo $estado['id'] ?>">
                                                    <?php echo ($estado['nombre']); ?>
                                                </option><?php } ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="progreso">Estado movimiento</label>

                                            <select name="progreso" id="progreso" class="form-control"
                                                required="required">
                                                <?php
                                                $progre = new libreria\ORM\EtORM();
                                                $progresos = $progre->ejecutar("sp_progreso_movimiento");
                                                foreach ($progresos as $progre) { ?>
                                                <option <?php echo isset($salida) && $salida->progreso == $progre['id']
                                                                    ? 'selected' : '' ?>
                                                    value="<?php echo $progre['id'] ?>">
                                                    <?php echo ($progre['Nombre']); ?>
                                                </option><?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal editar estado movimiento y equipos-->
            <div class="modal fade" id="cambiarConsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                <div class="modal-dialog" id="estadoFinal" role="document">
                    <div class="modal-content">
                        <form action="<?php url("salida/cambiarConsumo/" . $salida->id) ?>" method="post">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Cambiar el estado del movimiento y de los
                                    equipos</h4>
                            </div>
                            <!-- Modal cuerpo -->

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="consumo">Consumido</label>

                                            <select name="consumo" id="consumo" class="form-control"
                                                required="required">
                                                <option value="NO" <?php echo isset($salida) && $salida->consumido == 'NO'
                                                                        ? 'selected' : '' ?>>NO</option>
                                                <option value="SI" <?php echo isset($salida) && $salida->consumido == 'SI'
                                                                        ? 'selected' : '' ?>>SI</option>
                                                <option value="NA" <?php echo isset($salida) && $salida->consumido == 'NA'
                                                                        ? 'selected' : '' ?>>NA</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Fin Modal cuerpo -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i>
                                    Cambiar</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--TERMINO CONTENIDO-->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include(VISTA_RUTA . "admininclude/scripts.php") ?>

</body>

</html>