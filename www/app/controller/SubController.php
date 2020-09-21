<?php

/**
 * User: c_mat
 * Date: 19/07/2016
 * Time: 10:26 AM
 */

use vista\Vista;
use App\model\Sub;

class SubController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $est = new libreria\ORM\EtORM();
            $estado = $est->ejecutar("sp_estado_movimiento",array($_SESSION['cliente']));
            return Vista::crear("admin.sub.index", array(
                "estados" =>$estado,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.sub.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $estado = new Sub();
            if(input('estado_id')) {//Si se envia un id, el usuario sera actualizado.
                $estado = Sub::find(input('estado_id'));
            }
            $estado->nombre = input("nombre");
            $estado->descripcion = input('descripcion');
            $estado->id_cliente = $_SESSION["cliente"];
            $estado->movil = input("movil");
            $estado->guardar();

            redirecciona()->to("sub/index");
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * Metodo para editar usuarios.
     * @param $id id del usuario a editar
     * @return redireccionar
     */
    public function editar($id){
        $estado = Sub::find($id);
        if(count($estado)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.sub.crear', array(
                    "estado" => $estado,
                ));
            }
        }
        return redirecciona()->to("sub/index");
    }

    public function eliminar($id){
        $estado = Sub::find($id);
        if(count($estado)){
            $estado->eliminar();
            return redirecciona()->to("sub/index");
        }
        return redirecciona()->to("sub/index");
    }
}