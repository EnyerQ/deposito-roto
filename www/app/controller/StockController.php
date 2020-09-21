<?php

/**
 * Created by PhpStorm.
 * User: c_mat
 * Date: 24/06/2016
 * Time: 19:23
 */
use vista\Vista;
class StockController
{
    public function index(){
        if($_SESSION["inicio"] == true){
            return vista::crear("admin.index");
        }else{
            return redirecciona()->to("/");
        }
        //return vista::crear("admin.index");
    }

    public function calcular($id){
        if($_SESSION["inicio"] == true){
            $st = new libreria\ORM\EtORM();
            $stock = $st->ejecutar("sp_stock_por_estado", array($_SESSION['cliente'],$id));
            return Vista::crear('admin.stock.ver',array(
                "stocks"=>$stock,
                "id"=>$id,
            ));
        }else{
            redirecciona()->to("/");
        }
        return redirecciona()->to("admin");
    }
    //Genera un JSON detallando una categoria determinada por modelos.
    public function modelos($estado,$categoria){
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_stock_por_modelo",array($_SESSION['cliente'],$estado,$categoria));
        echo json_encode($productos);
    }

    public function nodisponible(){
        $asig = new libreria\ORM\EtORM();
        $noDisponibles = $asig->ejecutar("sp_stock_no_disponible", array($_SESSION['cliente'],1));
        echo json_encode($noDisponibles);
    }
}