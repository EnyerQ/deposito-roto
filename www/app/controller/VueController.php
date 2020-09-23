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
        #Aqui tenemos el código para dar soporte a las peticiones de axios, cuando este tiene parametros.
        $_POST = json_decode(file_get_contents("php://input"), true);

        # Creamos el objeto para la consulta a la base de datos.
        $obj = new libreria\ORM\EtORM();
        # Ejecutamos procedimiento almacenado en la base de datos.
        $usuarios = $obj->ejecutar('sp_listar_usuatios');

        #Devolvemos en formato json los resultados.
        echo json_encode($usuarios);
    }

}
