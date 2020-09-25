<?php

/**

 */

use App\model\Categoria;
use App\model\Deposito;
use App\model\Destino;
use App\model\Detalle;
use App\model\Estado;
use App\model\Movimiento;
use App\model\Seguimiento;
use App\model\TipoMovimiento;
use libreria\ORM\EtORM;
use \vista\Vista;

class MovimientoController
{
    //Definimos un index a para redirecionar a la raiz del proyecto.
    public function index()
    {
        redirecciona()->to('/');
    }

    //Definimos el llamado al ofmrulario generico de carga de movimientos.
    public function formularioMovimiento()
    {
        //Verificamos que el usuario tenga una sessión iniciada.
        if (isset($_SESSION['inicio']) && $_SESSION['inicio'] == true && $_SESSION['OPERADOR'] == true) {
            //Recuperamos el listado de los depsoitos.
            $depositos = Deposito::all();
            //Recuperamos los tipos de movimientos posibles.
            $tiposMovimiento = TipoMovimiento::all();
            //Retornamos la vista del formulario
            return Vista::crear('movimiento.formularioMovimiento', array(
                "depositos" => $depositos,
                "tiposMovimiento" => $tiposMovimiento,
            ));
        } else {
            //Enviamos al usuario a la pantalla de login
            redirecciona()->to('/');
        }
    }

    //Definimos el llamado al ofmrulario generico de carga de movimientos.
    public function descripcionMovimiento()
    {
        //Verificamos que el usuario tenga una sessión iniciada.
        if (isset($_SESSION['inicio']) && $_SESSION['inicio'] == true && $_SESSION['OPERADOR'] == true) {
            //Recuperamos el ID del tipo de movimiento.
            $tipo = input('idTipoMovimiento');
            //Recuperamos el tipo de movimiento.
            $tipoMovimiento = TipoMovimiento::find(input('idTipoMovimiento'));
            //Recuperamos los destinos y los origenes
            $origenes = Destino::where('tipo', $tipoMovimiento->origen);
            $destinos = Destino::where('tipo', $tipoMovimiento->destino);
            //Definimos los registros necesarios, para el selector de productos.
            $categorias = Categoria::where('seriable', 1);
            //Recuperamos los estados posibles de los equipos asignados a los moimiento.
            $objOrm = new EtORM();
            $subEstados = $objOrm->ejecutar('sp_recuperar_estado_equipo', array(
                $_SESSION['cliente'],
                input('idTipoMovimiento'),
            ));
            //Retornamos la vista para la descripción de l movimiento.
            return Vista::crear('movimiento.descripcionMovimiento', array(
                "origenes" => $origenes,
                "destinos" => $destinos,
                "subEstados" => $subEstados,
                "categorias" => $categorias,
                "tipo" => $tipo,
            ));
        } else {
            //Enviamos al usuario a la pantalla de login
            redirecciona()->to('/');
        }
    }

    //Definimos el método para registrar el movimiento enviado por medio del formulario.
    public function registrarMovimiento()
    {
        //Verificamos que tengamos una sesión iniciada
        if (isset($_SESSION['inicio']) && $_SESSION['inicio'] == true) {
            //Recuperamos los datos del encabezado del movimiento.
            $deposito = input('idDeposito');
            $tipo = input('tipoMovimiento');
            $origen = input('origenMovimiento');
            $destino = input('destinoMovimiento');
            $remito = input('remitoMovimiento');
            $ticket = input('ordenMovimiento');
            $estadoEquipo = input('estadoEquipoMovimiento');
            $estadoMovimiento = input('progresoMovimiento');
            $comentario = input('comentarioMovimiento');
            $fechaPedido = input('fechaPedido');

            //Recuperamos el detalle del tipo de movimiento.
            $tipoMovimiento = TipoMovimiento::find($tipo);

            //Creamos el objeto de registro para el nuevo movimiento.
            $movimiento = new Movimiento();

            //Cargamos los campos necesarios para registrar el nuevo movimiento.
            $movimiento->remito = $remito;
            $movimiento->fecha = date("Y-m-d");
            $movimiento->fecha_modificacion = date("Y-m-d");
            $movimiento->comentario = $comentario;
            $movimiento->ticket = $ticket;
            $movimiento->progreso = $estadoMovimiento;
            $movimiento->id_origen = $origen;
            $movimiento->id_destino = $destino;
            $movimiento->tipo_movimiento = $tipoMovimiento->tipo;
            $movimiento->tipo = $tipo;
            $movimiento->id_cliente = $_SESSION['cliente'];
            $movimiento->id_sub_estado = $estadoEquipo;
            $movimiento->id_deposito = $deposito;
            $movimiento->id_usuario = $_SESSION['id'];
            $movimiento->fecha_pedido = $fechaPedido;

            //Verificamos que podemos guardar el nuevo registro.
            if ($movimiento->guardar()) {
                //Verificamos el tipo de movimiento, para determinar proceso de carga.
                if ($tipo == 6 || $tipo == 7) {
                    //Recuperamos el modelo a dar de alta.
                    $idModelo = input('modelo');
                    //Contar los series a dar de alta.
                    $contador = 0;

                    //Convertimos el JSON de los series en un ARRAY PHP.
                    $series = json_decode(input("serie"));

                    //Verificamos si tenemos números de serie a verificar.
                    if ($series != []) {

                        //Recorremos los números de serie enviados por el formulario.
                        foreach ($series as $serie) {

                            //Verificamos que el serie enviado esta en estado OK
                            if ($serie->estado == 'ALTA') {

                                //Verificamos si ya existe el número de serie.
                                $seguimiento = new Seguimiento();

                                //Cargamos los nuevos parametros del número de serie.
                                $seguimiento->serie = $serie->series;
                                $seguimiento->id_producto = $idModelo;
                                $seguimiento->fecha_actualizada = date('Y-m-d');
                                $seguimiento->fecha_alta = date('Y-m-d');
                                $seguimiento->id_sub_estado = $estadoEquipo;
                                $seguimiento->id_ultimo_movimiento = $movimiento->id;
                                //Verificamos si el movimiento esta completo o no
                                if ($estadoMovimiento == '2') {
                                    $seguimiento->id_destino = $destino;
                                }
                                //Cargamos el deposito que registra el movimiento.
                                $seguimiento->id_deposito = $deposito;
                                //Cargamos al cliente que pertence.
                                $seguimiento->id_cliente = $_SESSION['cliente'];
                                //Guardamos los cambios en los registros del serie.
                                if ($seguimiento->guardar()) {
                                    //Incrementamos el contador.
                                    $contador++;
                                    //Registramos la trazabilidad del número de serie.
                                    $trB = new libreria\ORM\EtORM();
                                    $trB->ejecutar("sp_insertar_trazabilidad", array($seguimiento->id, $movimiento->id));
                                }

                            }
                        }

                        //Creamos el detalle de carga de modelos, para contabilizar en el stock

                        $md = new Detalle();
                        $md->id_movimiento = $movimiento->id;
                        $md->id_modelo = $idModelo;
                        $md->cantidad = $contador;
                        $md->guardar();
                    }

                } else {
                    //Cargamos el detalle del movimiento las cantidades de los equipos.
                    $detalles = json_decode(input("detalle"));

                    if ($detalles != []) {
                        foreach ($detalles as $detalle) {
                            $md = new Detalle();
                            if (isset($detalle->id_detalle) and $detalle->id_detalle != "") {
                                $md = Detalle::find($detalle->id_detalle);
                            }
                            $md->id_movimiento = $movimiento->id;
                            $md->id_modelo = $detalle->id;
                            $md->cantidad = $detalle->cantidad;
                            $md->guardar();
                        }
                    }

                    //Convertimos el JSON de los series en un ARRAY PHP.
                    $series = json_decode(input("serie"));

                    //Verificamos si tenemos números de serie a verificar.
                    if ($series != []) {

                        //Recorremos los números de serie enviados por el formulario.
                        foreach ($series as $serie) {

                            //Verificamos que el serie enviado esta en estado OK
                            if ($serie->estado == 'OK') {

                                //Verificamos si ya existe el número de serie.
                                $seguimientos = Seguimiento::where('serie', $serie->series);

                                if (!empty($seguimientos)) {

                                    //Recuperamos el registro del serie.
                                    $seguimiento = Seguimiento::find($seguimientos[0]->id);

                                    //Cargamos los nuevos parametros del número de serie.
                                    $seguimiento->fecha_actualizada = date('Y-m-d');
                                    $seguimiento->id_sub_estado = $estadoEquipo;
                                    $seguimiento->id_ultimo_movimiento = $movimiento->id;
                                    //Verificamos si el movimiento esta completo o no
                                    if ($estadoMovimiento == '2') {
                                        $seguimiento->id_destino = $destino;
                                    }
                                    //Cargamos el deposito que registra el movimiento.
                                    $seguimiento->id_deposito = $deposito;
                                    //Cargamos al cliente que pertence.
                                    $seguimiento->id_cliente = $_SESSION['cliente'];
                                    //Guardamos los cambios en los registros del serie.
                                    if ($seguimiento->guardar()) {
                                        //Registramos la trazabilidad del número de serie.
                                        $trB = new libreria\ORM\EtORM();
                                        $trB->ejecutar("sp_insertar_trazabilidad", array($seguimientos[0]->id, $movimiento->id));
                                    }
                                }
                            }
                        }
                    }
                }
                return redirecciona()->to($tipoMovimiento->tipo . "/informe/" . $movimiento->id);
            } else {
                echo 'TUVIMOS UN PROBLEMA AL GUARDAR EL REGIRTOS';
            }
        } else {
            //Enviamos al usuario a la pantalla de login
            redirecciona()->to('/');
        }
    }

    //Definimos el método para visualizar el informe el movimiento.
}