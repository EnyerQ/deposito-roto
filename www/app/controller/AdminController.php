<?php

/**
 * Created by PhpStorm.
 * User: c_mat
 * Date: 24/06/2016
 * Time: 19:23
 */
use vista\Vista;
class AdminController
{
    public function index(){
        if($_SESSION["inicio"] == true){
            $id = 1;
            $titulo = "Stock";
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'],$id));
            return Vista::crear('admin.indexCliente',array(
                "stocks"=>$stock,
                "id"=>$id,
                "leds"=>true,
                "tituloPagina"=>$titulo,
            ));
        }else{
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function almacen($id){
        if($_SESSION["inicio"] == true){
            $titulo = "Re Utilizable";
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'],$id));
            return Vista::crear('admin.indexCliente',array(
                "stocks"=>$stock,
                "id"=>$id,
                "leds"=>false,
                "tituloPagina"=>$titulo,
            ));
        }else{
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }



    public function cliente(){
        if($_SESSION["inicio"] == true){
            $id = 1;
            $titulo = "";
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'],$id));
            return Vista::crear('admin.indexCliente2',array(
                "stocks"=>$stock,
                "id"=>$id,
                "tituloPagina"=>$titulo,
            ));
        }else{
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function detalle($idAlmacen,$idProducto){
            if($_SESSION["inicio"] == true){
                $titulo = "No disponible";
                $almacen = resgitroAlmacen($idAlmacen)->nombre;
                $deta = new libreria\ORM\EtORM();
                $detalle = $deta->ejecutar("sp_stock_no_disponible_por_producto", array($_SESSION['cliente'],$idAlmacen,$idProducto));
                return Vista::crear('admin.detalleProducto',array(
                    "detalles"=>$detalle,
                    "idAlmacen"=>$idAlmacen,
                    "idProducto"=>$idProducto,
                    "tituloPagina"=>$titulo,
                    "almacen"=>$almacen,
                ));
            }else{
                redirecciona()->to("/");
            }
        return redirecciona()->to("admin");
    }
}
