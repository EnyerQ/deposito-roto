<?php

use App\model\Categoria;
use App\model\Destino;
use App\model\Producto;
use App\model\Seguimiento;
use App\model\Sub;
use libreria\ORM\Modelo;
use vista\Vista;

class SeguimientoController
{
    public function index()
    {
        if ($_SESSION["inicio"] == true) {
            return vista::crear("admin.seguimiento.alta");
        } else {
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function buscar($serie)
    {
        $ser = new libreria\ORM\EtORM();
        $series = $ser->ejecutar("sp_buscar_serie", array($serie, $_SESSION['cliente']));
        echo json_encode($series);
    }

    //Nos permite buscar por número se serie o parte del mismo.
    //Los registros que tengamos sobre el mismo.

    public function serie()
    {}

    public function detalle($id_movimiento)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_detalle_serie", array($id_movimiento));
        echo json_encode($productos);
    }

    //Generamos una vista de trazabilidad y seguimiento por medio de un número de serie.
    public function trazar()
    {
        $serie = input('buscarSerie');
        //Cargamos la trazabilidad del número de serie.
        $tra = new libreria\ORM\EtORM();
        $trazas = $tra->ejecutar("sp_buscar_trazabilidad", array($serie, $_SESSION['cliente']));
        //Si se encuentra se cargan los detalles del número de serie.
        $det = new libreria\ORM\EtORM();
        $detalles = $det->ejecutar("sp_buscar_detalle_serie", array($serie, $_SESSION['cliente']));
        //Recuperamos la vista de la trazabilidad y enviamos variables con datos.
        return vista::crear("admin.trazabilidad.index", array(
            "trazas" => $trazas,
            "detalles" => $detalles,
        ));
    }

    //Buscamos series almacenados por estados.

    public function serieEstado($cliente, $destino, $categoria, $estado)
    {
        $ser = new libreria\ORM\EtORM();
        $series = $ser->ejecutar("sp_serie_por_estado", array($cliente, $destino, $categoria, $estado));
        echo json_encode($series);
    }

    //Creamos la funcion para recuperar el detalle de los stocks no
    //disponibles cuando no tenemos números de serie.
    public function noSeriables($cliente, $destino, $categoria, $progreso, $estado)
    {
        $ser = new libreria\ORM\EtORM();
        $series = $ser->ejecutar("sp_nodisponible_noseriable", array($cliente, $destino, $categoria, $progreso, $estado));
        echo json_encode($series);
    }

    //Definimos el modulo, para verificar el estado de los números de serie.
    public function recuperarSerie()
    {
        //Recuperamos los valores enviados por el formulario

        $objDatos = json_decode(file_get_contents("php://input"));

        //Recuperamos el número de serie.
        $registro = Seguimiento::where('serie', $objDatos->numeroSerie);

        $serie = trim($objDatos->numeroSerie);

        //Verificamos su existencia.
        if (!empty($registro)) {

            //Recuperamos el modelo del serie.
            $modeloEquipo = Producto::find($registro[0]->id_producto);

            //Recuperamos la categoria del serie.
            $categoriaEquipo = Categoria::find($modeloEquipo->id_categoria);

            //Comprobamos el tipo de movimiento
            if ($objDatos->tipoMovimiento == 1 || $objDatos->tipoMovimiento == 2) {
                //Movimientos de tipo ENTRADA
                //Verificamos que el serie no esté asignado ya en un almacén.
                //Recuperamos los datos del destino que tiene actualmente el serie.
                $destino = Destino::find($registro[0]->id_destino);
                if ($destino->tipo != 'estado') {
                    //Retornamos un OK para poder ser movido.
                    $mensaje = 'OK';
                    $idModelo = $modeloEquipo->id;
                    $modelo = $modeloEquipo->modelo;
                    $categoria = $categoriaEquipo->nombre;
                    $categoriaCodigo = $categoriaEquipo->codigo;
                    $color = 'text-success';
                    $icono = 'fa fa-check ';
                } else {
                    //Retornamos el estado en que esta el equipo.
                    $mensaje = 'YA INGRESADO';
                    $idModelo = $modeloEquipo->id;
                    $modelo = $modeloEquipo->modelo;
                    $categoria = $categoriaEquipo->nombre;
                    $categoriaCodigo = $categoriaEquipo->codigo;
                    $color = 'text-warning';
                    $icono = 'fa fa-info-circle ';
                }
            } elseif ($objDatos->tipoMovimiento == 3 || $objDatos->tipoMovimiento == 4) {
                //Movimientos de tipo SALIDA
                //Comprobamos que el serie este asignado al deposito
                if ($registro[0]->id_deposito == $objDatos->idDeposito) {
                    //Comprobamos el almacén
                    if ($registro[0]->id_destino == $objDatos->origenMovimiento) {
                        //Recuperamos el estado del serie.
                        $estado = Sub::find($registro[0]->id_sub_estado);
                        //Comprobamos el estado del equipo.
                        if ($estado->movil == 'SI') {
                            //Retornamos un OK para poder ser movido.
                            $mensaje = 'OK';
                            $idModelo = $modeloEquipo->id;
                            $modelo = $modeloEquipo->modelo;
                            $categoria = $categoriaEquipo->nombre;
                            $categoriaCodigo = $categoriaEquipo->codigo;
                            $color = 'text-success';
                            $icono = 'fa fa-check ';
                        } else {
                            //Retornamos el estado en que esta el equipo.
                            $mensaje = $estado->nombre;
                            $idModelo = $modeloEquipo->id;
                            $modelo = $modeloEquipo->modelo;
                            $categoria = $categoriaEquipo->nombre;
                            $categoriaCodigo = $categoriaEquipo->codigo;
                            $color = 'text-warning';
                            $icono = 'fa fa-info-circle ';
                        }
                    } else {
                        //Verificamos si se encuentra en un deposito ingresado.
                        //Recuperamos los datos del destino que tiene actualmente el serie.
                        $destino = Destino::find($registro[0]->id_destino);
                        if ($destino->tipo != 'estado') {
                            //Informamos que no esta disponible en el almacén
                            $mensaje = 'NO INGRESADO';
                            $idModelo = $modeloEquipo->id;
                            $modelo = $modeloEquipo->modelo;
                            $categoria = $categoriaEquipo->nombre;
                            $categoriaCodigo = $categoriaEquipo->codigo;
                            $color = 'text-warning';
                            $icono = 'fa fa-info-circle ';
                        } else {
                            //Informamos que no esta disponible en el almacén
                            $mensaje = 'ERROR ALMACÉN';
                            $idModelo = $modeloEquipo->id;
                            $modelo = $modeloEquipo->modelo;
                            $categoria = $categoriaEquipo->nombre;
                            $categoriaCodigo = $categoriaEquipo->codigo;
                            $color = 'text-warning';
                            $icono = 'fa fa-info-circle ';
                        }
                    }
                } else {
                    //Informamos que no se encuentra en el deposito
                    $mensaje = 'ERROR DEPÓSITO';
                    $idModelo = $modeloEquipo->id;
                    $modelo = $modeloEquipo->modelo;
                    $categoria = $categoriaEquipo->nombre;
                    $categoriaCodigo = $categoriaEquipo->codigo;
                    $color = 'text-danger';
                    $icono = 'fa fa-info-circle ';
                }
            } elseif ($objDatos->tipoMovimiento == 5) {
                //Movimientos de tipo TRASLADO
                //Comprobamos que el serie este asignado al deposito
                if ($registro[0]->id_deposito == $objDatos->idDeposito) {
                    //Recuperamos los datos del destino que tiene actualmente el serie.
                    $destino = Destino::find($registro[0]->id_destino);

                    if ($destino->tipo == 'estado') {

                        //Comprobamos el almacén
                        if ($registro[0]->id_destino == $objDatos->origenMovimiento) {
                            //Retornamos un OK para poder ser movido.
                            $mensaje = 'OK';
                            $idModelo = $modeloEquipo->id;
                            $modelo = $modeloEquipo->modelo;
                            $categoria = $categoriaEquipo->nombre;
                            $categoriaCodigo = $categoriaEquipo->codigo;
                            $color = 'text-success';
                            $icono = 'fa fa-check ';
                        } else {
                            //Informamos que no esta disponible en el almacén
                            $mensaje = 'ERROR ALMACÉN ORIGEN';
                            $idModelo = $modeloEquipo->id;
                            $modelo = $modeloEquipo->modelo;
                            $categoria = $categoriaEquipo->nombre;
                            $categoriaCodigo = $categoriaEquipo->codigo;
                            $color = 'text-warning';
                            $icono = 'fa fa-info-circle ';
                        }
                    } else {
                        //Informamos que no esta disponible en el almacén
                        $mensaje = 'NO INGRESADO';
                        $idModelo = $modeloEquipo->id;
                        $modelo = $modeloEquipo->modelo;
                        $categoria = $categoriaEquipo->nombre;
                        $categoriaCodigo = $categoriaEquipo->codigo;
                        $color = 'text-danger';
                        $icono = 'fa fa-info-circle ';
                    }
                } else {
                    //Informamos que no se encuentra en el deposito
                    $mensaje = 'ERROR DEPÓSITO';
                    $idModelo = $modeloEquipo->id;
                    $modelo = $modeloEquipo->modelo;
                    $categoria = $categoriaEquipo->nombre;
                    $categoriaCodigo = $categoriaEquipo->codigo;
                    $color = 'text-danger';
                    $icono = 'fa fa-info-circle ';
                }
            } elseif ($objDatos->tipoMovimiento == 6 || $objDatos->tipoMovimiento == 7) {
                //Movimientos de tipo ALTA//Informamos que no esta disponible en el almacén
                $mensaje = 'YA EXISTE';
                $idModelo = $modeloEquipo->id;
                $modelo = $modeloEquipo->modelo;
                $categoria = $categoriaEquipo->nombre;
                $categoriaCodigo = $categoriaEquipo->codigo;
                $color = 'text-danger';
                $icono = 'fa fa-info-circle ';
            }
        } else {
            //Verificamos si es una alta de número de serie.
            if ($objDatos->tipoMovimiento == 6 || $objDatos->tipoMovimiento == 7) {
                //Retornamos que el serie es posible darle el alta.
                $mensaje = 'ALTA';
                $idModelo = '';
                $modelo = 'NO EXISTE';
                $categoria = 'NO EXISTE';
                $categoriaCodigo = '';
                $color = 'text-success';
                $icono = 'fa fa-check ';
            } else {
                //Definimos el mensaje del que el serie no existe.
                $mensaje = 'NO EXISTE';
                $idModelo = '';
                $modelo = 'NO EXISTE';
                $categoria = 'NO EXISTE';
                $categoriaCodigo = '';
                $color = 'text-danger';
                $icono = 'fa fa-close ';
            }
        }

        //Creamos un array con el contenido de la respesta.
        $data = array(
            'serie' => $serie,
            'respuesta' => $mensaje,
            'idModelo' => $idModelo,
            'modelo' => $modelo,
            'categoria' => $categoria,
            'categoriaCodigo' => $categoriaCodigo,
            'color' => $color,
            'icono' => $icono,
        );

        //Retornamos en un JSON
        echo json_encode($data);
    }

    //Definimos el método para el formulario de las altas de los diferentes números de serie.
    public function formularioAlta()
    {
        //Verificamos que tenemos la sisión iniciada!
        if (isset($_SESSION['inicio']) && $_SESSION['inicio'] == true) {
            //Definimos los registros necesarios, para el selector de productos.
            $categorias = Categoria::where('seriable', 1);
            //Retornamos las vista solicitada.
            return Vista::crear('seguimiento.formularioAlta', array(
                "categorias" => $categorias,
            ));
        } else {
            //Retornamos al usuario a la pantalla de logueo.
            redirecciona()->to('/');
        }
    }

    //Definimos el método para registrar la alta de los números de serie
    public function registrarAlta()
    {
        //Verificamos que tenemos la sisión iniciada!
        if (isset($_SESSION['inicio']) && $_SESSION['inicio'] == true) {
            //Definimos el contado en cero.
            $contador = 0;
            //Recuperamos los campos enviados por el formulario.
            $modelo = input('modelo');
            $categoria = input('categoria');

            $detalleCategoria = Categoria::where('codigo', $categoria);
            $detalleModelo = Producto::find($modelo);

            //Convertimos el JSON de los series en un ARRAY PHP.
            $series = json_decode(input("serie"));

            //Verificamos si tenemos números de serie a verificar.
            if ($series != []) {

                //Recorremos los números de serie enviados por el formulario.
                foreach ($series as $serie) {

                    //Verificamos que el serie enviado esta en estado OK
                    if ($serie->estado == 'ALTA') {

                        //Creamos el objeto para el registro
                        $seguimiento = new Seguimiento();

                        //Cargamos los campos necesarios
                        $seguimiento->serie = $serie->series;
                        $seguimiento->id_producto = $modelo;
                        $seguimiento->fecha_alta = date('Y-m-d');
                        $seguimiento->fecha_actualizada = date('Y-m-d');
                        $seguimiento->id_destino = 53;

                        //Guardamos el nuevo registros
                        if ($seguimiento->guardar()) {
                            $contador++;
                        }
                    }
                }
            }

            //Retornamos la vista del informe de alta de lo nuevos números de serie.
            return Vista::crear('seguimiento.informeAlta', array(
                'modelo' => $detalleModelo->modelo,
                'categoria' => $detalleCategoria[0]->nombre,
                'contador' => $contador,
            ));
        } else {
            //Retornamos al usuario a la pantalla de logueo.
            redirecciona()->to('/');
        }
    }

    //Definimos el metodo que nos permite modificar los el número de serie.
    public function modificar()
    {
        //Verificamos que tenemos la sisión iniciada!
        if (isset($_SESSION['inicio']) && $_SESSION['inicio'] == true) {
            //Recuperamos los valores enviados por el formulario
            $idSerie = input('cambiarSerieId');
            $serie = input('cambiarSerie');

            //Recuperamos el registro del serie.
            $seguimiento = Seguimiento::find($idSerie);

            //Comparamos que el serie enviado nos es el mismo que ya esta cargado.
            if ($seguimiento->serie == $serie) {
                //Informamos que el serie es el mismo
                echo 'IGUAL';
            } else {
                //Realizamos una conaulta sobre el nuevo serie
                $consulta = Seguimiento::where('serie', $serie);

                //Verificamos que el nuevo serie no este en uso.
                if (!empty($consulta)) {
                    echo 'EXISTE';
                } else {
                    //Realizamos el cambio del serie
                    $seguimiento->serie = $serie;

                    //Comprobamos que el cambio se realice de forma correcta
                    if ($seguimiento->guardar()) {
                        echo 'CORRECTO';
                    } else {
                        echo 'ERROR';
                    }
                }
            }
        } else {
            //Informamos problemas con la session
            echo 'SESSION';
        }
    }
}