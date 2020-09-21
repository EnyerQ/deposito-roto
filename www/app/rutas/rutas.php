<?php
//todas las rutas disponibles en nuestra aplicación
$ruta = new Ruta();
$ruta->controladores(array(
    "/" => "WelcomeController",
    "/login" => "AuthController",
    "/usuario" => "UsuarioController",
    "/ventas" => "VentaController",
    "/admin" => "AdminController",
    "/producto" => "ProductoController",
    "/entrada" => "EntradaController",
    "/categoria" => "CategoriaController",
    "/cliente" => "ClienteController",
    "/marca" => "MarcaController",
    "/privilegio" => "PrivilegioController",
    "/deposito" => "DepositoController",
    "/estado" => "EstadoController",
    "/proveedor" => "ProveedorController",
    "/tipo" => "TipoController",
    "/destino" => "DestinoController",
    "/sub" => "SubController",
    "/stock" => "StockController",
    "/seguimiento" => "SeguimientoController",
    "/salida" => "SalidaController",
    "/traslado" => "TrasladoController",
    "/pendiente" => "PendienteController",
    "/consulta" => "ConsultaController",
    "/movimiento" => "MovimientoController",
));