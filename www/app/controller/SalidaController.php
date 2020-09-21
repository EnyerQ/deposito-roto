<?php

/**
 * Create by Charly
 */
use vista\Vista;
use App\model\Salida;
use App\model\Detalle;
use App\model\Seguimiento;
use App\model\Sub;

class SalidaController
{
    public function index()
    {
        if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
            $sal = new libreria\ORM\EtORM();
            $titulo = "Egresos";
            $salida = $sal->ejecutar("sp_salida_deposito", array($_SESSION['cliente'], $_SESSION['deposito']));
            return \vista\Vista::crear("admin.salida.index", array(
                "salidas" => $salida,
                "tituloPagina" => $titulo,
            ));
        } else {
            redirecciona()->to("/");
        }
    }
    //devuelve la vista de registro de nueva salida.
    public function crear($origen)
    {
        if ($origen == 1) {
            if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
                $_SESSION['origen'] = "proveedor";
                $titulo = "Nuevo egreso";
                return \vista\Vista::crear("admin.salida.crear", array(
                    "tituloPagina" => $titulo,
                ));
            }
        } elseif ($origen == 2) {
            if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
                $_SESSION['origen'] = "cliente";
                $titulo = "Nuevo egreso";
                return \vista\Vista::crear("admin.salida.crear", array(
                    "tituloPagina" => $titulo,
                ));
            }
        }
    }

    public function agregar()
    {
        try {
            $id_recuperado = "";
            $salida = new Salida();
            if (input('salida_id')) { //Si se envia un id, el cliente sera actualizado.
                $salida = Salida::find(input('salida_id'));
            } else {
                $salida->id_deposito = $_SESSION['deposito'];
            }
            $salida->remito = input("remito");
            $salida->fecha = input("fecha");
            $salida->id_origen = input("origen");
            $salida->id_destino = input("destino");
            $salida->tipo_movimiento = "salida";
            $salida->id_sub_estado = input("sub_estado");
            $salida->interviene = input("interviene");
            $salida->id_cliente = $_SESSION['cliente'];
            $salida->observacion = input("observacion");
            $salida->comentario = input("comentario");
            $salida->fecha_modificacion = date("Y-m-d");
            $salida->ticket = input("ticket");
            $salida->progreso = input("progreso");
            if ($salida->guardar()) {

                if (input("salida_id")) {
                    $id_recuperado = input("salida_id");
                } else {
                    $id_recuperado = $salida->id;
                }

                $detalles = json_decode(input("detalle"));

                if ($detalles != []) {
                    foreach ($detalles as $detalle) {
                        $md = new Detalle();
                        if (isset($detalle->id_detalle) and $detalle->id_detalle != "") {
                            $md = Detalle::find($detalle->id_detalle);
                        }
                        $md->id_movimiento = $id_recuperado;
                        $md->id_modelo = $detalle->id;
                        $md->cantidad = $detalle->cantidad;
                        $md->guardar();
                    }
                }

                //Convertimos el JSON de los series en un ARRAY PHP.
                $series = json_decode(input("serie"));

                //Verificamos si tenemos números de serie a verificar.
                if ($series != []) {

                    foreach ($series as $serie) {


                        //Verificamos si ya existe el número de serie.
                        $serN = new libreria\ORM\EtORM();
                        $serR = $serN->ejecutar("sp_recuperar_serie", array(trim($serie->series), $_SESSION['cliente']));
                        //Si ya existe solo actualizamos lo que corresponde.

                        if (count($serR) > 0) {
                            $sr = new Seguimiento();
                            $sr = Seguimiento::find($serR[0]['id']);
                            $sr->fecha_actualizada = date("Y-m-d");
                            $sr->id_sub_estado = input("sub_estado");
                            $sr->id_ultimo_movimiento = $id_recuperado;
                            if (input("progreso") == "2") {
                                $sr->id_destino = input('destino');
                            }
                            $sr->id_deposito = $_SESSION['deposito'];
                            $sr->guardar();
                        }

                        //Verificamos si ya existe la trazabilidad.
                        //Si existe no cargamos, pero sino existe la cargamos.

                        $trB = new libreria\ORM\EtORM();
                        $trB->ejecutar("sp_insertar_trazabilidad", array($serR[0]['id'], $id_recuperado));
                    }
                }
                return redirecciona()->to("salida/informe/" . $id_recuperado);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editar($id)
    {
        $salida = Salida::find($id);
        if (count($salida)) {
            if ($_SESSION["inicio"] == true and $_SESSION['OPERADOR'] == true) {
                $titulo = "Editar egreso";
                return Vista::crear('admin.salida.crear', array(
                    "salida" => $salida,
                    "tituloPagina" => $titulo,
                ));
            } else {
                redirecciona()->to("/");
            }
        }
        return redirecciona()->to("salida/index");
    }

    public function eliminar($id)
    {
        if (false) {
            $salida = Salida::find($id);
            if (count($salida)) {
                $salida->eliminar();
                return redirecciona()->to("salida/index");
            }
            return redirecciona()->to("salida/index");
        } else {
            echo 'No cuenta con los permisos necessarios para eliminar el movimiento';
        }
    }

    public function series()
    {
        $json = file_get_contents('php://input');
        $obj = json_decode($json);

        foreach ($obj->data->detalle as $item) {
            //Nombre del participante.
            $item->id;
        }
    }

    //Genera informe del registro de salida
    public function informe($id)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_recuperar_detalle", array($id));
        $salida = Salida::find($id);
        //Recuperamos los estados posibles de los equipos asignados a los moimiento.
        $objOrm = new libreria\ORM\EtORM();
        $subEstados = $objOrm->ejecutar('sp_recuperar_estado_equipo', array(
            $_SESSION['cliente'],
            $salida->tipo
        ));
        $titulo = "Detalle Egreso";

        return \vista\Vista::crear("admin.salida.informe", array(
            "salida_id" => $id,
            "productos" => $productos,
            "salida" => $salida,
            "tituloPagina" => $titulo,
            "subEstados" => $subEstados

        ));
    }

    //Cambia remito o referencia de la salida
    public function remito($id)
    {
        $salida = Salida::find($id);
        $salida->remito = input('remito');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia fecha de la salida
    public function fecha($id)
    {
        $salida = Salida::find($id);
        $salida->fecha = input('fecha');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia origen de la salida
    public function origen($id)
    {
        $salida = Salida::find($id);
        $salida->id_origen = input('origen');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia destino de la salida
    public function cambiarDestino($id)
    {
        $salida = Salida::find($id);
        $salida->id_destino = input('destino');
        $salida->guardar();

        //Llamamos al procedimieto almacenado, para actualizar el destino de los series.
        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_destino_serie", array($id, input('destino'), $_SESSION['cliente']));

        //Redireccionamos a la vista de informe del movimiento.
        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia el estado de los equipos y subestado de la salida
    public function cambiarEstado($id)
    {
        $salida = Salida::find($id);
        $salida->id_sub_estado = input('sub_estado');
        $salida->guardar();

        //Llamamos al prodecimiento almacenado, para actualizar el estado de los series.
        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_estado_serie", array($id, input('sub_estado'), $_SESSION['cliente']));

        //Redireccionamos a la vista de informe del movimiento.
        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia observación de la salida
    public function cambiarObservacion($id)
    {
        $salida = Salida::find($id);
        $salida->observacion = input('observacion');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia comentario de la salida
    public function cambiarComentario($id)
    {
        $salida = Salida::find($id);
        $salida->comentario = input('comentario');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia comentario de la salida
    public function cambiarTicket($id)
    {
        $salida = Salida::find($id);
        $salida->ticket = input('ticket');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia el estado de los equipos y subestado de la salida
    public function cambiarEstadoFinal($id)
    {
        $salida = Salida::find($id);
        $salida->id_sub_estado = input('sub_estado');
        $salida->progreso = input('progreso');
        $salida->fecha_modificacion = date("Y-m-d");
        $salida->guardar();

        $destino = new libreria\ORM\EtORM();
        $destinoSeries = $destino->ejecutar("sp_cambiar_destino_serie", array($id, $salida->id_destino, $_SESSION['cliente']));

        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_estado_serie", array($id, input('sub_estado'), $_SESSION['cliente']));

        redirecciona()->to('salida/informe/' . $id);
    }

    //Cambia consumo del movimiento
    public function cambiarConsumo($id)
    {
        $salida = Salida::find($id);
        $salida->consumido = input('consumo');
        $salida->guardar();

        redirecciona()->to('salida/informe/' . $id);
    }
}