<?php

/**
 * User: c_mat
 * Date: 19/07/2016
 * Time: 10:26 AM
 */

use vista\Vista;
use App\model\Estado;

class EstadoController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $est = new libreria\ORM\EtORM();
            $estado = $est->ejecutar("sp_lista_estado",array($_SESSION['cliente']));
            return Vista::crear("admin.estado.index", array(
                "estados" =>$estado,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.estado.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $estado = new Estado();
            if(input('estado_id')) {//Si se envia un id, el usuario sera actualizado.
                $estado = Estado::find(input('estado_id'));
            }
            $estado->nombre = input("nombre");
            $estado->descripcion = input('descripcion');
            $estado->id_cliente = $_SESSION["cliente"];
            $estado->tipo = "estado";
            $estado->stock = input('stock');
            $estado->guardar();

            redirecciona()->to("estado/index");
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
        $estado = Estado::find($id);
        if(count($estado)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.estado.crear', array(
                    "estado" => $estado,
                ));
            }
        }
        return redirecciona()->to("estado/index");
    }

    public function eliminar($id){
        $estado = Estado::find($id);
        if(count($estado)){
            $estado->eliminar();
            return redirecciona()->to("estado/index");
        }
        return redirecciona()->to("estado/index");
    }
}