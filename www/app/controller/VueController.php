<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 13/09/2015
 * Time: 1:34 AM
 */
use \vista\Vista;
use App\model\User;

class VueController {

    public function index(){
        return Vista::crear("vue.index");
    }

    # Definimos el método para revivir las peticiones de axios
    public function listar()
    {
        #Aqui tenemos el código para dar soporte a las peticiones.
        $_POST = json_decode(file_get_contents("php://input"), true);

        $obj = new libreria\ORM\EtORM();
        $usuarios = $obj->ejecutar('sp_listar_usuatios');

        echo json_encode($usuarios);
    }

}
