<?php

/**
 * Create by Charly
 */

use vista\Vista;
use App\model\Traslado;
use App\model\Detalle;
use App\model\Seguimiento;

class TrasladoController
{
    public function index()
    {
        if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
            $ent = new libreria\ORM\EtORM();
            $titulo = "Traslado";
            $traslado = $ent->ejecutar("sp_traslado_deposito", array($_SESSION['cliente'], $_SESSION['deposito']));
            return \vista\Vista::crear("admin.traslado.index", array(
                "traslados" => $traslado,
                "tituloPagina" => $titulo,
            ));
        } else {
            redirecciona()->to("/");
        }
    }
    //devuelve la vista de registro de nueva salida.
    public function crear()
    {
        if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
            $titulo = "Nuevo Traslado";
            return \vista\Vista::crear("admin.traslado.crear", array(
                "tituloPagina" => $titulo,
            ));
        }
    }

    public function agregar()
    { //Resgistramos la entrada y sus datos.
        try {
            $arrayAltaSeries = [];
            $id_recuperado = "";
            $traslado = new Traslado();
            if (input('traslado_id')) { //Si se envia un id, el movimiento sera actualizado.
                $traslado = Traslado::find(input('traslado_id'));
            } else {
                $traslado->id_deposito = $_SESSION['deposito'];
            }
            $traslado->remito = input("remito");
            $traslado->fecha = input("fecha");
            $traslado->id_origen = input("origen");
            $traslado->id_destino = input("destino");
            $traslado->tipo_movimiento = "traslado";
            $traslado->id_sub_estado = input("sub_estado");
            $traslado->interviene = input("interviene");
            $traslado->id_cliente = $_SESSION['cliente'];
            $traslado->observacion = input("observacion");
            $traslado->comentario = input("comentario");
            $traslado->fecha_modificacion = date("Y-m-d");
            $traslado->ticket = input("ticket");
            $traslado->progreso = input("progreso");
            if ($traslado->guardar()) {

                //aqui cargamos los detalles del movimiento. Esto quiere decir productos y cantidad
                $detalles = json_decode(input("detalle"));

                if (input("traslado_id")) {
                    $id_recuperado = input('traslado_id');
                } else {
                    $id_recuperado = $traslado->id;
                }

                if ($detalles != []) {
                    foreach ($detalles as $detalle) {
                        $md = new Detalle();
                        //verificamos si el id del movimiento se genoro por la carga o viene
                        //del formulario.
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

                        $sr = new Seguimiento();
                        //Verificamos si ya existe el número de serie.
                        $serN = new libreria\ORM\EtORM();
                        $serR = $serN->ejecutar("sp_recuperar_serie", array(trim($serie->series), $_SESSION['cliente']));
                        //Si ya existe solo actualizamos lo que corresponde.
                        if (count($serR) > 0) {
                            $sr = Seguimiento::find($serR[0]['id']);
                            $sr->fecha_actualizada = date("Y-m-d");
                            $sr->id_sub_estado = input("sub_estado");
                            $sr->id_ultimo_movimiento = $id_recuperado;
                            if (input("progreso") == "2") {
                                $sr->id_destino = input('destino');
                            }
                            $sr->id_deposito = $_SESSION["deposito"];
                        } else { //Si no existe lo damos de alta.
                            $sr->id_producto = $serie->id;
                            $sr->serie = trim($serie->series);
                            $sr->fecha_actualizada = date("Y-m-d");
                            $sr->fecha_alta = input("fecha");
                            $sr->id_cliente = $_SESSION['cliente'];
                            $sr->id_sub_estado = input("sub_estado");
                            $sr->id_ultimo_movimiento = $id_recuperado;
                            if (input("progreso") == "2") {
                                $sr->id_destino = input('destino');
                            }
                            $sr->id_deposito = $_SESSION["deposito"];
                            $altaSeries = trim($serie->series);
                            array_push($arrayAltaSeries, $altaSeries);
                        }

                        $sr->guardar();

                        if (count($serR) > 0) {
                            $id_serie = $serR[0]['id'];
                        } else {
                            $id_serie = $sr->id;
                        }

                        $trB = new libreria\ORM\EtORM();
                        $trB->ejecutar("sp_insertar_trazabilidad", array($id_serie, $id_recuperado));
                    }
                }
            }
            return redirecciona()->to("traslado/informe/" . $id_recuperado);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editar($id)
    {
        $traslado = Traslado::find($id);
        if (count($traslado)) {
            if ($_SESSION["inicio"] == true and $_SESSION['OPERADOR'] == true) {
                $titutlo = "Editar traslado";
                return Vista::crear('admin.traslado.crear', array(
                    "traslado" => $traslado,
                    "tituloPagina" => $titulo,
                ));
            } else {
                redirecciona()->to("/");
            }
        }
        return redirecciona()->to("traslado/index");
    }

    public function eliminar($id)
    {
        if (false) {
            $traslado = Traslado::find($id);
            if (count($traslado)) {
                $traslado->eliminar();
                return redirecciona()->to("traslado/index");
            }
            return redirecciona()->to("traslado/index");
        } else {
            echo 'no cuenta con los permisos necsarios para eliminar el movimiento';
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

    public function informe($id)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_recuperar_detalle", array($id));
        $traslado = Traslado::find($id);
        //Recuperamos los estados posibles de los equipos asignados a los moimiento.
        $objOrm = new libreria\ORM\EtORM();
        $subEstados = $objOrm->ejecutar('sp_recuperar_estado_equipo', array(
            $_SESSION['cliente'],
            $traslado->tipo
        ));
        $titulo = "Detalle traslado";
        return \vista\Vista::crear("admin.traslado.informe", array(
            "traslado_id" => $id,
            "productos" => $productos,
            "traslado" => $traslado,
            "tituloPagina" => $titulo,
            "subEstados" => $subEstados
        ));
    }

    //Cambia remito o referencia de la traslado
    public function remito($id)
    {
        $traslado = Traslado::find($id);
        $traslado->remito = input('remito');
        $traslado->guardar();

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia fecha de la traslado
    public function fecha($id)
    {
        $traslado = Traslado::find($id);
        $traslado->fecha = input('fecha');
        $traslado->guardar();

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia origen de la traslado
    public function origen($id)
    {
        $traslado = Traslado::find($id);
        $traslado->id_origen = input('origen');
        $traslado->guardar();

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia destino de la traslado
    public function cambiarDestino($id)
    {
        $traslado = Traslado::find($id);
        $traslado->id_destino = input('destino');
        $traslado->guardar();

        //Llamamos al procedimieto almacenado, para actualizar el destino de los series.
        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_destino_serie", array($id, input('destino'), $_SESSION['cliente']));

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia el estado de los equipos y subestado de la traslado
    public function cambiarEstado($id)
    {
        $traslado = Traslado::find($id);
        $traslado->id_sub_estado = input('sub_estado');
        $traslado->guardar();

        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_estado_serie", array($id, input('sub_estado'), $_SESSION['cliente']));

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia observación de la traslado
    public function cambiarObservacion($id)
    {
        $traslado = Traslado::find($id);
        $traslado->observacion = input('observacion');
        $traslado->guardar();

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia comentario de la traslado
    public function cambiarComentario($id)
    {
        $traslado = Traslado::find($id);
        $traslado->comentario = input('comentario');
        $traslado->guardar();

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia comentario de la traslado
    public function cambiarTicket($id)
    {
        $traslado = Traslado::find($id);
        $traslado->ticket = input('ticket');
        $traslado->guardar();

        redirecciona()->to('traslado/informe/' . $id);
    }

    //Cambia el estado de los equipos y subestado de la traslado
    public function cambiarEstadoFinal($id)
    {
        $traslado = Traslado::find($id);
        $traslado->id_sub_estado = input('sub_estado');
        $traslado->progreso = input('progreso');
        $traslado->fecha_modificacion = date("y-m-d");
        $traslado->guardar();

        $destino = new libreria\ORM\EtORM();
        $destinoSeries = $destino->ejecutar("sp_cambiar_destino_serie", array($id, $traslado->id_destino, $_SESSION['cliente']));

        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_estado_serie", array($id, input('sub_estado'), $_SESSION['cliente']));

        redirecciona()->to('traslado/informe/' . $id);
    }
}