<?php

/**
 * User: c_mat
 * Date: 18/07/2016
 * Time: 2:53 PM
 */

use vista\Vista;
use App\model\Privilegio;

class PrivilegioController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $privilegio = Privilegio::all();
            return Vista::crear("admin.privilegio.index", array(
                "privilegios" => $privilegio,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.privilegio.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $privilegio = new Privilegio();
            if(input('privilegio_id')){//Si se envia un id, el cliente sera actualizado.
                $privilegio = Privilegio::find(input('privilegio_id'));
            }
            $privilegio->nombre = input("nombre");
            $privilegio->descripcion = input("descripcion");;
            $privilegio->guardar();

            redirecciona()->to("privilegio/index");
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
        $privilegio = Privilegio::find($id);
        if(count($privilegio)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.privilegio.crear', array(
                    "privilegio" => $privilegio,
                ));
            }
        }
        return redirecciona()->to("privilegio/index");
    }

    public function eliminar($id){
        $privilegio = Privilegio::find($id);
        if(count($privilegio)){
            $privilegio->eliminar();
            return redirecciona()->to("privilegio/index");
        }
        return redirecciona()->to("privilegio/index");
    }
}