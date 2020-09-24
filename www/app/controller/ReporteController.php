<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 13/09/2015
 * Time: 1:34 AM
 */
use \vista\Vista;

class ReporteController
{

    public function index()
    {
        return Vista::crear("auth/login");
    }

    # Definimos el método para la vista principal del reporte de movimientos
    public function cambio()
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

    # Definimos el metodo para recuperar los selectores de reportes
    public function selectores()
    {
        # Aqui verificamos que tengamos una sessión comenzada.
        if ($_SESSION["inicio"] == true) {
            #Aqui tenemos el código para dar soporte a las peticiones de axios, cuando este tiene parametros.
            $_POST = json_decode(file_get_contents("php://input"), true);

            # Creamos el objeto para la consulta a la base de datos.
            $obj = new libreria\ORM\EtORM();
            # Ejecutamos procedimiento almacenado en la base de datos.
            $depositos = $obj->ejecutar('sp_lista_deposito');
            $categorias = $obj->ejecutar('sp_lista_categoria', array(1));
            $estados = $obj->ejecutar('sp_lista_estado',array(1));

            $data = array(
                "depositos"=>$depositos,
                "categorias"=>$categorias,
                "estados"=>$estados,
            );

            #Devolvemos en formato json los resultados.
            echo json_encode($data);
        } else {
            # Volvemos al login
            return redirecciona()->to("/");
        }
    }

    # Definimos el metodo para recuperar los selectores de reportes
    public function registros()
    {
        # Aqui verificamos que tengamos una sessión comenzada.
        if ($_SESSION["inicio"] == true) {
            #Aqui tenemos el código para dar soporte a las peticiones de axios, cuando este tiene parametros.
            $variable_post = json_decode(file_get_contents("php://input"), true);

            var_dump($variable_post['fecha_inicio']);
            die();

            $inicio = (isset($variable_post['fecha_inicio'])) ? $_POST['fecha_inicio'] : '';

            # Creamos el objeto para la consulta a la base de datos.
            $obj = new libreria\ORM\EtORM();
            # Ejecutamos procedimiento almacenado en la base de datos.
            $movimientos = $obj->ejecutar('sp_reporte_movimiento_2',array(
                '2020-01-01',
                '2020-02-01',
                '',
                '',
                '',
                '',
                '',
            ));

            $data = $movimientos;

            #Devolvemos en formato json los resultados.
            echo json_encode($data);
        } else {
            # Volvemos al login
            return redirecciona()->to("/");
        }
    }

}
