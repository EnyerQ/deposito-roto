<?php

/**
 * Created by PhpStorm.
 * User: c_mat
 * Date: 24/06/2016
 * Time: 19:23
 */

use App\model\Categoria;
use App\model\Destino;
use libreria\ORM\EtORM;
use vista\Vista;

class StockController
{
    public function index()
    {
        if ($_SESSION["inicio"] == true) {
            return vista::crear("admin.index");
        } else {
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function calcular($id_almacen)
    {
        if ($_SESSION["inicio"] == true) {
            //Verificamos la vista del semaforo LED
            if ($id_almacen == 1) {
                $led = true;
            } else {
                $led = false;
            }
            //Recuperamos el almacén solicitado.
            $almacen = Destino::find($id_almacen);
            //Totulo de la vista.
            $titulo = "Stock " . $almacen->nombre;
            //Recuperamos el listado de categorias.
            $stocks = Categoria::all();

            //Creamos el objeto de consulta de procedimientos almacenados.
            $consulta = new EtORM();

            //Recorremos el listado de categorias de producto.
            foreach ($stocks as $key => $stock) {
                //Verificamos y definimos los precedimientos a consumir.
                if ($stock->seriable == 1) {
                    $procedimiento_general = "sp_stock_serie_categoria";
                    $procedimiento_deposito = 'sp_stock_serie_categoria_deposito';
                } else {
                    $procedimiento_general = 'sp_stock_generico_categoria';
                    $procedimiento_deposito = 'sp_stock_generico_categoria_deposito';
                }
                //Recuperamos el valor del stock general.
                $stock_general = $consulta->Ejecutar($procedimiento_general, array(
                    $stock->id,
                    $id_almacen,
                ));
                //Cargamos el stock general en el objeto.
                if (count($stock_general) > 0) {
                    //Cargamos el valor recuperado del stock.
                    $stocks[$key]->stock_general = $stock_general[0]['stock'];
                } else {
                    //Informamos que le valor es cero.
                    $stocks[$key]->stock_general = 0;
                }

                //Recuperamos el valor del stock deposito CTL.
                $stock_general = $consulta->Ejecutar($procedimiento_deposito, array(
                    $stock->id,
                    $id_almacen,
                    1,
                ));
                //Cargamos el stock general en el objeto.
                if (count($stock_general) > 0) {
                    //Cargamos el valor recuperado del stock.
                    $stocks[$key]->stock_ctl = $stock_general[0]['stock'];
                } else {
                    //Informamos que le valor es cero.
                    $stocks[$key]->stock_ctl = 0;
                }

                //Recuperamos el valor del stock deposito METRO.
                $stock_general = $consulta->Ejecutar($procedimiento_deposito, array(
                    $stock->id,
                    $id_almacen,
                    2,
                ));
                //Cargamos el stock general en el objeto.
                if (count($stock_general) > 0) {
                    //Cargamos el valor recuperado del stock.
                    $stocks[$key]->stock_metro = $stock_general[0]['stock'];
                } else {
                    //Informamos que le valor es cero.
                    $stocks[$key]->stock_metro = 0;
                }

                //Recuperamos el valor del stock deposito PP.
                $stock_general = $consulta->Ejecutar($procedimiento_deposito, array(
                    $stock->id,
                    $id_almacen,
                    3,
                ));
                //Cargamos el stock general en el objeto.
                if (count($stock_general) > 0) {
                    //Cargamos el valor recuperado del stock.
                    $stocks[$key]->stock_pp = $stock_general[0]['stock'];
                } else {
                    //Informamos que le valor es cero.
                    $stocks[$key]->stock_pp = 0;
                }
            }

            return Vista::crear('admin.stock.stockAlmacen', array(
                "stocks" => $stocks,
                "id" => $id_almacen,
                "leds" => $led,
                "tituloPagina" => $titulo,
            ));
        } else {
            return redirecciona()->to("/");
        }
    }
    //Genera un JSON detallando una categoria determinada por modelos.
    public function modelos($estado, $categoria)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_stock_por_modelo", array($_SESSION['cliente'], $estado, $categoria));
        echo json_encode($productos);
    }

    public function nodisponible()
    {
        $asig = new libreria\ORM\EtORM();
        $noDisponibles = $asig->ejecutar("sp_stock_no_disponible", array($_SESSION['cliente'], 1));
        echo json_encode($noDisponibles);
    }

    //Definimos el metódo para recuperar el detalle de stock de los equipos seriables
    public function detalleSeriable($almacen, $categoria)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_stock_detalle_seriable", array($almacen, $categoria));
        echo json_encode($productos);
    }

    //Definimos el metódo para recuperar el detalle de stock de los equipos seriables
    public function detalleNoSeriable($almacen, $categoria)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_stock_detalle_no_seriable", array($almacen, $categoria));
        echo json_encode($productos);
    }

    //Definimos el método para el detalle de los equipos no disponobles.
    public function detalleNoDisponible($almacen, $categoria, $seriable)
    {
        if ($_SESSION["inicio"] == true) {
            //Verificamos si es seriable.
            if ($seriable == 1) {
                $procedimiento = 'sp_stock_seriable_no_disponible';
                $vista = 'admin.stock.detalleNoDisponibleSeriable';
            } else {
                $procedimiento = 'sp_stock_no_seriable_no_disponible';
                $vista = 'admin.stock.detalleNoDisponibleNoSeriable';
            }

            //Recuperamos el registro del almacen
            $datoAlmacen = Destino::find($almacen);

            //Creamos el objeto para la consulta.
            $consulta = new EtORM();
            $noDisponibles = $consulta->Ejecutar($procedimiento, array($categoria, $almacen));

            return Vista::crear($vista, array(
                "noDisponibles" => $noDisponibles,
                "almacen" => $datoAlmacen,
            ));
        } else {
            redirecciona()->to("/");
        }
    }

}