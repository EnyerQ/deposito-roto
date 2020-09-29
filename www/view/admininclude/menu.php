<nav class="navbar navbar-default navbar-static-top menub" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php url("admin")?>"><img src="<?php asset('Imagenes/logoCTL3.png')?>" width="65"
                alt=""></a>
        <a class="navbar-brand" href="<?php url("admin")?>">DEPÓSITO v1.3.1</a>
    </div>
    <!-- /.navbar-header -->

    <ul class="nav navbar-top-links navbar-right">
        <?php if ($_SESSION['OPERADOR']) {?>
        <li class="dropdown">
            <!-- /.dropdown-messages -->
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-building"></i> Depósito: <?php echo $_SESSION["nombre_deposito"]; ?> <i
                    class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <?php
$deps = new \libreria\ORM\EtORM();
    $dep = $deps->ejecutar("sp_deposito_con_permiso", array($_SESSION['id']));
    foreach ($dep as $depo) {?>
                <li><a href="<?php url('deposito/cambiar/' . $depo['id'])?>"><?php echo $depo['nombre'] ?></a></li>
                <?php }?>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <?php }?>
        <li class="text-primary">
            <a href="<?php url("admin")?>">
                <i class="fa fa-institution"></i> Cliente: <?php echo $_SESSION["razon_social"] ?>
            </a>
        </li>
        <li class="dropdown">
            <!-- /.dropdown-messages -->
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION["nombre"]; ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php url("usuario/perfil")?>"><i class="fa fa-user fa-fw"></i> Perfil</a>
                </li>
                <li class="divider"></li>
                <li><a href="<?php url("login/salir")?>"><i class="fa fa-sign-out fa-fw"></i> Salir</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->

    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li class="sidebar-search">
                    <form action="<?php url("seguimiento/trazar")?>">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Buscar S/N..." name="buscarSerie"
                                id="buscarSerie">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                    <!-- /input-group -->
                </li>
                <li>
                    <a href="<?php url("admin")?>"><i class="fa fa-cubes fa-fw"></i> STOCK</a>
                </li>
                <li>
                    <a href="<?php url("admin/almacen/4")?>"><i class="fa fa-cubes fa-fw"></i> RE UTILIZABLE</a>
                </li>
                <?php if ($_SESSION["OPERADOR"] == true) {?>
                <li>
                    <a href="<?php url("producto")?>"><i class="fa fa-archive fa-fw"></i> ABM Productos
                        <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("categoria")?>">Categoría</a>
                        </li>
                        <li>
                            <a href="<?php url("marca")?>">Marca</a>
                        </li>
                        <li>
                            <a href="<?php url("producto")?>">Modelos</a>
                        </li>
                    </ul>
                </li>
                <?php }?>
                <?php if ($_SESSION["ADMINISTRADOR"] == true) {?>
                <li>
                    <a href="#"><i class="fa fa-wrench fa-fw"></i> ABM Administración<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("usuario")?>">Usuarios</a>
                        </li>
                        <li>
                            <a href="<?php url("privilegio")?>">Privilegios</a>
                        </li>
                        <li>
                            <a href="<?php url("cliente")?>">Clientes</a>
                        </li>
                        <li>
                            <a href="<?php url("deposito")?>">Depositos</a>
                        </li>
                    </ul>
                    <!-- /.nav-second-level -->
                </li>
                <?php }?>

                <?php if ($_SESSION["ADMINISTRADOR"] == true) {?>
                <li>
                    <a href="#"><i class="fa fa-th-list fa-fw"></i> ABM Deposito<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("estado")?>">Almacenes</a>
                        </li>
                        <li>
                            <a href="<?php url("sub")?>">Estados</a>
                        </li>
                    </ul>
                </li>
                <?php }?>

                <?php if ($_SESSION["OPERADOR"] == true) {?>
                <li>
                    <a href="#"><i class="fa fa-folder-open fa-fw"></i> ABM Cliente<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("tipo")?>">Tipo de Destinos</a>
                        </li>
                        <li>
                            <a href="<?php url("destino")?>">Destinos en cliente</a>
                        </li>
                        <li>
                            <a href="<?php url("proveedor")?>">Proveedores</a>
                        </li>
                    </ul>
                </li>
                <?php }?>
                <!--Menú de movmientos -->
                <?php if ($_SESSION["OPERADOR"] == true) {?>
                <li>
                    <a href="#"><i class="fa fa-edit fa-fw"></i> Registro<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("movimiento/formularioMovimiento")?>">Nuevo Movimiento</a>
                        </li>

                        <?php if (false) { ?>
                        <li>
                            <a href="<?php url("seguimiento/formularioAlta")?>">Nuevos N/S</a>
                        </li>
                        <?php } ?>

                        <li>
                            <a href="<?php url("entrada")?>">Entrada</a>
                        </li>

                        <li>
                            <a href="<?php url("salida")?>">Salida</a>
                        </li>

                        <li>
                            <a href="<?php url("traslado")?>">Traslado</a>
                        </li>

                        <li>
                            <a href="<?php url("pendientes")?>">Pendientes</a>
                        </li>
                    </ul>
                </li>
                <?php }?>
                <!--Menú de STOCKS -->
                <?php if ($_SESSION["CONSULTOR"] == true) {?>
                <li>
                    <a href="#"><i class="fa fa-desktop fa-fw"></i> Almacenes<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <?php
$est = new libreria\ORM\EtORM();
    $estado_st = $est->ejecutar("sp_estado_stock", array($_SESSION['cliente']));
    foreach ($estado_st as $estados_st) {?>
                        <li>
                            <a href="<?php url("stock/calcular/" . $estados_st['id'])?>">
                                <?php echo $estados_st['nombre'] ?></a>
                        </li><?php }?>
                    </ul>
                </li>
                <?php }?>
                <!--Menú de CONSULTAS-->
                <?php if ($_SESSION["CONSULTOR"] == true) {?>
                <li>
                    <a href="#"><i class="fa fa-table fa-fw"></i> Reportes<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="<?php url("reporte/cambio")?>">Movimiento Productos</a>
                        </li>
                        <li>
                            <a href="<?php url("consulta/index_evo")?>">Estadistica Productos</a>
                        </li>
                        <li>
                            <a href="<?php url("consulta/index_series")?>">Buscar Series Almacenados</a>
                        </li>
                    </ul>
                </li>
                <?php }?>

            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>