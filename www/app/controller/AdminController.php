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

class AdminController
{
    public function index()
    {
        if ($_SESSION["inicio"] == true) {
            $id = 1;
            $titulo = "Stock";
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'], $id));
            return Vista::crear('admin.indexCliente', array(
                "stocks" => $stock,
                "id" => $id,
                "leds" => true,
                "tituloPagina" => $titulo,
            ));
        } else {
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function general($id_almacen)
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

    public function almacen($id)
    {
        if ($_SESSION["inicio"] == true) {
            $titulo = "Re Utilizable";
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'], $id));
            return Vista::crear('admin.indexCliente', array(
                "stocks" => $stock,
                "id" => $id,
                "leds" => false,
                "tituloPagina" => $titulo,
            ));
        } else {
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function cliente()
    {
        if ($_SESSION["inicio"] == true) {
            $id = 1;
            $titulo = "";
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'], $id));
            return Vista::crear('admin.indexCliente2', array(
                "stocks" => $stock,
                "id" => $id,
                "tituloPagina" => $titulo,
            ));
        } else {
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function detalle($idAlmacen, $idProducto)
    {
        if ($_SESSION["inicio"] == true) {
            $titulo = "No disponible";
            $almacen = resgitroAlmacen($idAlmacen)->nombre;
            $deta = new libreria\ORM\EtORM();
            $detalle = $deta->ejecutar("sp_stock_no_disponible_por_producto", array($_SESSION['cliente'], $idAlmacen, $idProducto));
            return Vista::crear('admin.detalleProducto', array(
                "detalles" => $detalle,
                "idAlmacen" => $idAlmacen,
                "idProducto" => $idProducto,
                "tituloPagina" => $titulo,
                "almacen" => $almacen,
            ));
        } else {
            redirecciona()->to("/");
        }
        return redirecciona()->to("admin");
    }
}