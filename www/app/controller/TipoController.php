<?php

/**
 * User: c_mat
 * Date: 19/07/2016
 * Time: 10:26 AM
 */

use vista\Vista;
use App\model\Tipo;

class TipoController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $tipo = new libreria\ORM\EtORM();
            $tipo_cliente = $tipo->ejecutar("sp_lista_tipo_cliente",array($_SESSION['cliente']));
            return Vista::crear("admin.tipo.index", array(
                "tipos" =>$tipo_cliente,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.tipo.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $tipo = new Tipo();
            if(input('tipo_destino_id')) {//Si se envia un id, el usuario sera actualizado.
                $tipo = Tipo::find(input('tipo_destino_id'));
            }
            $tipo->nombre = input("nombre");
            $tipo->descripcion = input('descripcion');
            $tipo->id_cliente = $_SESSION["cliente"];
            $tipo->guardar();

            redirecciona()->to("tipo/index");
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
        $tipo = Tipo::find($id);
        if(count($tipo)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.tipo.crear', array(
                    "tipo" => $tipo,
                ));
            }
        }
        return redirecciona()->to("tipo/index");
    }

    public function eliminar($id){
        $tipo = Tipo::find($id);
        if(count($tipo)){
            $tipo->eliminar();
            return redirecciona()->to("tipo/index");
        }
        return redirecciona()->to("tipo/index");
    }
}