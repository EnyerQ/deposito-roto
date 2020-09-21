<?php

/**
 * Create by Charly
 */
use vista\Vista;
use App\model\Entrada;
use App\model\Detalle;
use App\model\Seguimiento;

class EntradaController
{
    public function index()
    {
        if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
            $titulo = "Ingresos";
            $ent = new libreria\ORM\EtORM();
            $entrada = $ent->ejecutar("sp_entrada_deposito", array($_SESSION['cliente'], $_SESSION['deposito']));
            return \vista\Vista::crear("admin.entrada.index", array(
                "entradas" => $entrada,
                "tituloPagina" => $titulo,
            ));
        } else {
            redirecciona()->to("/");
        }
    }
    //devuelve la vista de registro de nueva salida.
    public function crear($origen)
    {
        if ($_SESSION['inicio'] == true and $_SESSION['OPERADOR'] == true) {
            $_SESSION['origen'] = $origen;
            $titulo = "Nuevo Ingreso";
            return \vista\Vista::crear("admin.entrada.crear", array(
                "tituloPagina" => $titulo,
            ));
        }
    }

    public function agregar()
    { //Resgistramos la entrada y sus datos.
        try {
            $arrayAltaSeries = [];
            $id_recuperado = "";
            $entrada = new Entrada();
            if (input('entrada_id')) { //Si se envia un id, el movimiento sera actualizado.
                $entrada = Entrada::find(input('entrada_id'));
            } else {
                $entrada->id_deposito = $_SESSION['deposito'];
            }
            $entrada->remito = input("remito");
            $entrada->fecha = input("fecha");
            $entrada->id_origen = input("origen");
            $entrada->id_destino = input("destino");
            $entrada->tipo_movimiento = "entrada";
            $entrada->id_sub_estado = input("sub_estado");
            $entrada->interviene = input("interviene");
            $entrada->id_cliente = $_SESSION['cliente'];
            $entrada->observacion = input("observacion");
            $entrada->comentario = input("comentario");
            $entrada->fecha_modificacion = date("Y-m-d");
            $entrada->ticket = input("ticket");
            $entrada->progreso = input("progreso");
            if ($entrada->guardar()) {

                //aqui cargamos los detalles del movimiento. Esto quiere decir productos y cantidad
                $detalles = json_decode(input("detalle"));

                if (input("entrada_id")) {
                    $id_recuperado = input('entrada_id');
                } else {
                    $id_recuperado = $entrada->id;
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
            return redirecciona()->to("entrada/informe/" . $id_recuperado);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function editar($id)
    {
        $entrada = Entrada::find($id);
        if (count($entrada)) {
            if ($_SESSION["inicio"] == true and $_SESSION['OPERADOR'] == true) {
                $titulo = "Editar ingreso";
                return Vista::crear('admin.entrada.crear', array(
                    "entrada" => $entrada,
                    "tituloPagina" => $titulo,
                ));
            } else {
                redirecciona()->to("/");
            }
        }
        return redirecciona()->to("entrada/index");
    }

    public function eliminar($id)
    {
        if (false) {
            $entrada = Entrada::find($id);
            if (count($entrada)) {
                $entrada->eliminar();
                return redirecciona()->to("entrada/index");
            }
            return redirecciona()->to("entrada/index");
        } else {
            echo 'No cuenta con los permisos hecesarios para eliminar el movimeinto';
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
        $entrada = Entrada::find($id);
        //Recuperamos los estados posibles de los equipos asignados a los moimiento.
        $objOrm = new libreria\ORM\EtORM();
        $subEstados = $objOrm->ejecutar('sp_recuperar_estado_equipo', array(
            $_SESSION['cliente'],
            $entrada->tipo
        ));
        $titulo = "Detalle Ingreso";

        return \vista\Vista::crear("admin.entrada.informe", array(
            "entrada_id" => $id,
            "productos" => $productos,
            "entrada" => $entrada,
            "tituloPagina" => $titulo,
            "subEstados" => $subEstados

        ));
    }

    //Cambia remito o referencia de la entrada
    public function remito($id)
    {
        $entrada = Entrada::find($id);
        $entrada->remito = input('remito');
        $entrada->guardar();

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia fecha de la entrada
    public function fecha($id)
    {
        $entrada = Entrada::find($id);
        $entrada->fecha = input('fecha');
        $entrada->guardar();

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia origen de la entrada
    public function origen($id)
    {
        $entrada = Entrada::find($id);
        $entrada->id_origen = input('origen');
        $entrada->guardar();

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia destino de la entrada
    public function cambiarDestino($id)
    {
        $entrada = Entrada::find($id);
        $entrada->id_destino = input('destino');
        $entrada->guardar();

        //Llamamos al procedimieto almacenado, para actualizar el destino de los series.
        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_destino_serie", array($id, input('destino'), $_SESSION['cliente']));

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia el estado de los equipos y subestado de la entrada
    public function cambiarEstado($id)
    {
        $entrada = Entrada::find($id);
        $entrada->id_sub_estado = input('sub_estado');
        $entrada->guardar();

        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_estado_serie", array($id, input('sub_estado'), $_SESSION['cliente']));

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia observación de la entrada
    public function cambiarObservacion($id)
    {
        $entrada = Entrada::find($id);
        $entrada->observacion = input('observacion');
        $entrada->guardar();

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia comentario de la entrada
    public function cambiarComentario($id)
    {
        $entrada = Entrada::find($id);
        $entrada->comentario = input('comentario');
        $entrada->guardar();

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia comentario de la entrada
    public function cambiarTicket($id)
    {
        $entrada = Entrada::find($id);
        $entrada->ticket = input('ticket');
        $entrada->guardar();

        redirecciona()->to('entrada/informe/' . $id);
    }

    //Cambia el estado de los equipos y subestado de la entrada
    public function cambiarEstadoFinal($id)
    {
        $entrada = Entrada::find($id);
        $entrada->id_sub_estado = input('sub_estado');
        $entrada->progreso = input('progreso');
        $entrada->fecha_modificacion = date("y-m-d");
        $entrada->guardar();

        $destino = new libreria\ORM\EtORM();
        $destinoSeries = $destino->ejecutar("sp_cambiar_destino_serie", array($id, $entrada->id_destino, $_SESSION['cliente']));

        $sub_est = new libreria\ORM\EtORM();
        $estadoSeries = $sub_est->ejecutar("sp_cambiar_estado_serie", array($id, input('sub_estado'), $_SESSION['cliente']));

        redirecciona()->to('entrada/informe/' . $id);
    }
}