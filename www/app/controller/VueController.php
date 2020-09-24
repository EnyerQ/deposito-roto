<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 13/09/2015
 * Time: 1:34 AM
 */
use App\model\User;
use \vista\Vista;

class VueController
{

    public function index()
    {
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
        $usuarios = $obj->ejecutar('sp_listar_usuarios');

        #Devolvemos en formato json los resultados.
        echo json_encode($usuarios);
    }

    # Definimos el méto para mostrar un formulario de reporte de movimientos.
    public function reporteMovimiento()
    {
        # Aqui verificamos que tengamos una sessión comenzada.
        if ($_SESSION["inicio"] == true) {
            # Retornamos la vista solicitada.
            return Vista::crear('vue.reporteMovimiento');
        } else {
            # Volvemos al login
            return redirecciona()->to("/");
        }
    }

    # Definimos el método de listar movimientos
    public function listarMovimientos()
    {
        # Aqui verificamos que tengamos una sessión comenzada.
        if ($_SESSION["inicio"] == true) {
            # Retornamos la vista solicitada.
            # Creamos el objeto para la consulta a la base de datos.
            $obj = new libreria\ORM\EtORM();
            # Ejecutamos procedimiento almacenado en la base de datos.
            $usuarios = $obj->ejecutar('sp_listar_usuatios');

            # Volvemos al login
            $data = array(
                "estado" => "error",
                "mensaje" => "Su sessión a expirado, por favor vuelva a ingresar",
                "datos" => $usuarios
            );
        } else {
            # Volvemos al login
            $data = array(
                "estado" => "error",
                "mensaje" => "Su sessión a expirado, por favor vuelva a ingresar",
                "datos" => []
            );
        }
        # retronamos la data solicitada o el mensaje
        print json_encode($data);
    }

}
