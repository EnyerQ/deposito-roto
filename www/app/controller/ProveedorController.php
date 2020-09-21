<?php

/**
 * User: c_mat
 * Date: 19/07/2016
 * Time: 10:26 AM
 */

use vista\Vista;
use App\model\Proveedor;

class ProveedorController
{
    public function index(){

        if($_SESSION["inicio"] == true) {
            $pro = new libreria\ORM\EtORM();
            $proveedor = $pro->ejecutar("sp_lista_proveedor",array($_SESSION['cliente']));
            return Vista::crear("admin.proveedor.index", array(
                "proveedores" =>$proveedor,
            ));
        }else{
            return redirecciona()->to("/");
        }

    }

    public function todos(){
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_lista_proveedor",array($_SESSION['cliente']));
        echo json_encode($productos);
    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.proveedor.crear");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $estado = new Proveedor();
            if(input('proveedor_id')) {//Si se envia un id, el usuario sera actualizado.
                $estado = Proveedor::find(input('proveedor_id'));
            }
            $estado->nombre = input("nombre");
            $estado->descripcion = input('descripcion');
            $estado->id_cliente = $_SESSION["cliente"];
            $estado->tipo = "proveedor";
            $estado->zona = input("zona");
            $estado->guardar();

            redirecciona()->to("proveedor/index");
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
        $proveedor = Proveedor::find($id);
        if(count($proveedor)){
            if($_SESSION["inicio"] == true) {
                return Vista::crear('admin.proveedor.crear', array(
                    "proveedor" => $proveedor,
                ));
            }
        }
        return redirecciona()->to("proveedor/index");
    }

    public function eliminar($id){
        $proveedor = Proveedor::find($id);
        if(count($proveedor)){
            $proveedor->eliminar();
            return redirecciona()->to("proveedor/index");
        }
        return redirecciona()->to("proveedor/index");
    }
}