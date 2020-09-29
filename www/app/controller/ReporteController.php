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
            $inicio = new DateTime(date('Y-m-d'));
            $inicio->modify('+1 month');
            $final = date('Y-m-d');
            # Retornamos la vista solicitada.
            return Vista::crear('vue.reporteMovimiento', array(
                "inicio"=>$inicio,
                "final"=>$final
            ));
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
            $estados = $obj->ejecutar('sp_lista_estado', array(1));

            $data = array(
                "depositos" => $depositos,
                "categorias" => $categorias,
                "estados" => $estados,
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

            $inicio = (isset($variable_post['fecha_inicio'])) ? $variable_post['fecha_inicio'] : '';
            $fin = (isset($variable_post['fecha_fin'])) ? $variable_post['fecha_fin'] : '';
            $deposito = (isset($variable_post['id_deposito'])) ? $variable_post['id_deposito'] : '';
            $categoria = (isset($variable_post['id_categoria'])) ? $variable_post['id_categoria'] : '';
            $progreso = (isset($variable_post['id_progreso'])) ? $variable_post['id_progreso'] : '';
            $estado = (isset($variable_post['id_estado'])) ? $variable_post['id_estado'] : '';
            /*
            print_r($variable_post);
            die();
             */
            # Creamos el objeto para la consulta a la base de datos.
            $obj = new libreria\ORM\EtORM();
            # Ejecutamos procedimiento almacenado en la base de datos.
            $movimientos = $obj->ejecutar('sp_reporte_movimiento_2', array(
                $inicio,
                $fin,
                $deposito,
                '',
                $categoria,
                $progreso,
                $estado,
            ));

            $data = $movimientos;

            #Devolvemos en formato json los resultados.
            echo json_encode($data);
        } else {
            # Volvemos al login
            return redirecciona()->to("/");
        }
    }

    public function testVue()
    {
        return Vista::crear('vue.testVue');
    }

}
