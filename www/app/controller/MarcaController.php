<?php

/**
 * User: c_mat
 * Date: 19/07/2016
 * Time: 10:26 AM
 */

use vista\Vista;
use App\model\Marca;

class MarcaController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $marca = Marca::where("id_cliente",$_SESSION["cliente"]);
            return Vista::crear("admin.marca.index", array(
                "marcas" => $marca,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.marca.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $marca = new Marca();
            if(input('marca_id')) {//Si se envia un id, el usuario sera actualizado.
                $marca = marca::find(input('marca_id'));
            }
            $marca->nombre = input("nombre");
            $marca->descripcion = input('descripcion');
            $marca->id_cliente = $_SESSION["cliente"];
            $marca->guardar();

            redirecciona()->to("marca/index");
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
        $marca = Marca::find($id);
        if(count($marca)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.marca.crear', array(
                    "marca" => $marca,
                ));
            }
        }
        return redirecciona()->to("marca/index");
    }

    public function eliminar($id){
        $marca = Marca::find($id);
        if(count($marca)){
            $marca->eliminar();
            return redirecciona()->to("marca/index");
        }
        return redirecciona()->to("marca/index");
    }
}