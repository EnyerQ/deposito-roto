<?php

/**
 * User: c_mat
 * Date: 18/07/2016
 * Time: 2:53 PM
 */

use vista\Vista;
use App\model\Cliente;

class ClienteController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $cliente = Cliente::all();
            return Vista::crear("admin.cliente.index", array(
                "clientes" => $cliente,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.cliente.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $cliente = new Cliente();
            if(input('cliente_id')){//Si se envia un id, el cliente sera actualizado.
                $cliente = Cliente::find(input('cliente_id'));
            }
            $cliente->razon_social = input("razon_social");
            $cliente->descripcion = input("descripcion");;
            $cliente->guardar();

            redirecciona()->to("cliente/index");
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
        $cliente = Cliente::find($id);
        if(count($cliente)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.cliente.crear', array(
                    "cliente" => $cliente,
                ));
            }
        }
        return redirecciona()->to("cliente/index");
    }

    public function eliminar($id){
        $cliente = Cliente::find($id);
        if(count($cliente)){
            $cliente->eliminar();
            return redirecciona()->to("cliente/index");

        }
        return redirecciona()->to("cliente/index");
    }
}