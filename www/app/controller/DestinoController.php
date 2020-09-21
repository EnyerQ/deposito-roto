<?php

/**
 * User: c_mat
 * Date: 19/07/2016
 * Time: 10:26 AM
 */

use vista\Vista;
use App\model\Destino;

class DestinoController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $desti = new libreria\ORM\EtORM();
            $destino = $desti->ejecutar("sp_lista_destino",array($_SESSION['cliente']));
            return Vista::crear("admin.destino.index", array(
                "destinos" =>$destino,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar destino
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.destino.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $destino = new Destino();
            if(input('destino_id')) {//Si se envia un id, el usuario sera actualizado.
                $destino = Destino::find(input('destino_id'));
            }
            $destino->nombre = input("nombre");
            $destino->descripcion = input('descripcion');
            $destino->id_cliente = $_SESSION["cliente"];
            $destino->tipo = "cliente";
            $destino->id_tipo_cliente = input("tipo");
            $destino->zona = input("zona");
            $destino->guardar();

            redirecciona()->to("destino/index");
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
        $destino = Destino::find($id);
        if(count($destino)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.destino.crear', array(
                    "destino" => $destino,
                ));
            }
        }
        return redirecciona()->to("destino/index");
    }

    public function eliminar($id){
        $destino = Destino::find($id);
        if(count($destino)){
            $destino->eliminar();
            return redirecciona()->to("destino/index");
        }
        return redirecciona()->to("destino/index");
    }
}
