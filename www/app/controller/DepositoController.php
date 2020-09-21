<?php

/**
 * User: c_mat
 * Date: 18/07/2016
 * Time: 2:53 PM
 */

use vista\Vista;
use App\model\Deposito;

class DepositoController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $deposito = Deposito::all();
            return Vista::crear("admin.deposito.index", array(
                "depositos" => $deposito,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.deposito.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $deposito = new Deposito();
            if(input('deposito_id')){//Si se envia un id, el cliente sera actualizado.
                $deposito = Deposito::find(input('deposito_id'));
            }
            $deposito->nombre = input("nombre");
            $deposito->descripcion = input("descripcion");;
            $deposito->guardar();

            redirecciona()->to("deposito/index");
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
        $deposito = Deposito::find($id);
        if(count($deposito)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.deposito.crear', array(
                    "deposito" => $deposito,
                ));
            }
        }
        return redirecciona()->to("deposito/index");
    }

    public function eliminar($id){
        $deposito = Deposito::find($id);
        if(count($deposito)){
            $deposito->eliminar();
            return redirecciona()->to("deposito/index");
        }
        return redirecciona()->to("deposito/index");
    }
    //Función que nos permite cambiar el deposito en el que estamos.
    //Recibiendo el id del deposito al que queremos acceder.
    public function cambiar($id){
        $_SESSION['deposito'] = $id;
        //Recuperamos el nombre del depósito al que queremos acceder.
        $nombre_depo = new \libreria\ORM\EtORM();
        $name_depo = $nombre_depo->ejecutar("sp_nombre_deposito",array($_SESSION['deposito']));
        if(count($name_depo) > 0){

            $_SESSION['nombre_deposito'] = $name_depo[0]["nombre"];

        }
        return redirecciona()->to("admin");
    }
}
