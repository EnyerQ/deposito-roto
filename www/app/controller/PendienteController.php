<?php

/**
 * Created by PhpStorm.
 * User: c_mat
 * Date: 26/10/2016
 * Time: 9:56 AM
 */
class PendienteController
{
    public function index(){
        if($_SESSION['inicio']==true AND $_SESSION['OPERADOR']==true) {
            $mov = new libreria\ORM\EtORM();
            $movimiento = $mov->ejecutar("sp_movimiento_pendiente", array($_SESSION['cliente']));
            return \vista\Vista::crear("admin.pendiente.index", array(
                "movimientos"=>$movimiento,
            ));
        }else{
            redirecciona()->to("/");
        }
    }
}