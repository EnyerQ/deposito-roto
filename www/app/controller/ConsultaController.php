<?php

/**
 * User: c_mat
 * Date: 23/01/2017
 * Time: 3:03 PM
 */

use App\model\Producto;
use vista\Vista;
class ConsultaController
{
    public function index(){//Index de consulta movimientos por producto
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.consulta.index");
        }else{
            return redirecciona()->to("/");
        }
    }
    public function cambio(){//Respuesta de la consulta de los movimientos por producto
        if($_SESSION["inicio"] == true) {
                $consulta = new libreria\ORM\EtORM();
                if (input('deposito') != '' && input('categoria') != '' && input('estado') != '') {
                  $consultas = $consulta->ejecutar("sp_reporte_productos_deposito_categoria",array(
                    input("fecha_inicio"),
                    input("fecha_final"),
                    input("deposito"),
                    input("categoria"),
                    input("progreso"),
                    input("estado"),
                    input("tipo"),
                  ));
                  return Vista::crear("admin.consulta.movimiento", array(
                      "consultas" => $consultas,
                      "fecha_inicio" => input("fecha_inicio"),
                      "fecha_final" => input("fecha_final"),
                      "deposito" => input("deposito"),
                      "cate" => input("categoria"),
                      "progred" => input("progreso"),
                      "estado" => input("estado"),
                      "tipo" => input('tipo'),
                  ));
                }elseif(input('deposito') == '' && input('categoria') != '' && input('estado') != ''){
                  $consultas = $consulta->ejecutar("sp_reporte_productos_categoria",array(
                    input("fecha_inicio"),
                    input("fecha_final"),
                    input("categoria"),
                    input("progreso"),
                    input("estado"),
                    input("tipo"),
                  ));
                  return Vista::crear("admin.consulta.movimiento", array(
                      "consultas" => $consultas,
                      "fecha_inicio" => input("fecha_inicio"),
                      "fecha_final" => input("fecha_final"),
                      "deposito" => input("deposito"),
                      "cate" => input("categoria"),
                      "progred" => input("progreso"),
                      "estado" => input("estado"),
                      "tipo" => input('tipo'),
                  ));
                }elseif(input('deposito') != '' && input('categoria') == ''&& input('estado') != ''){
                  $consultas = $consulta->ejecutar("sp_reporte_productos_deposito",array(
                    input("fecha_inicio"),
                    input("fecha_final"),
                    input("deposito"),
                    input("progreso"),
                    input("estado"),
                    input("tipo"),
                  ));
                  return Vista::crear("admin.consulta.movimiento", array(
                      "consultas" => $consultas,
                      "fecha_inicio" => input("fecha_inicio"),
                      "fecha_final" => input("fecha_final"),
                      "deposito" => input("deposito"),
                      "cate" => input("categoria"),
                      "progred" => input("progreso"),
                      "estado" => input("estado"),
                      "tipo" => input('tipo'),
                  ));
                }elseif(input('deposito') == '' && input('categoria') == ''&& input('estado') != ''){
                  $consultas = $consulta->ejecutar("sp_reporte_productos",array(
                    input("fecha_inicio"),
                    input("fecha_final"),
                    input("progreso"),
                    input("estado"),
                    input("tipo"),
                  ));
                  return Vista::crear("admin.consulta.movimiento", array(
                      "consultas" => $consultas,
                      "fecha_inicio" => input("fecha_inicio"),
                      "fecha_final" => input("fecha_final"),
                      "deposito" => input("deposito"),
                      "cate" => input("categoria"),
                      "progred" => input("progreso"),
                      "estado" => input("estado"),
                      "tipo" => input('tipo'),
                  ));
                }elseif(input('deposito') != '' && input('categoria') == '' && input('estado') == ''){
                  $consultas = $consulta->ejecutar("sp_reporte_general_productos",array(
                    input("fecha_inicio"),
                    input("fecha_final"),
                    input("progreso"),
                    input("tipo"),
                    input("deposito"),
                  ));
                  return Vista::crear("admin.consulta.movimiento", array(
                      "consultas" => $consultas,
                      "fecha_inicio" => input("fecha_inicio"),
                      "fecha_final" => input("fecha_final"),
                      "deposito" => input("deposito"),
                      "cate" => input("categoria"),
                      "progred" => input("progreso"),
                      "estado" => input("estado"),
                      "tipo" => input("tipo"),
                  ));
                }


        }else{
            return redirecciona()->to("/");
        }
    }

    public function index_evo(){
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.consulta.index_evo");
        }else{
            return redirecciona()->to("/");
        }
    }

    //Compara las entradas y salidas de una categoria seleccionada.
    public function evolucion(){
        if($_SESSION["inicio"] == true) {
            $consulta = new libreria\ORM\EtORM();
            $consultas = $consulta->ejecutar("sp_evolucion_producto_mes",array(
                input("categoria"),
                input("deposito"),
                input("estado"),
                input("progreso"),
                $_SESSION["cliente"] ));
            return Vista::crear("admin.consulta.evolucion_producto", array(
                "consultas" => $consultas,
                "deposito" => input("deposito"),
                "cate" => input("categoria"),
                "progred" => input("progreso"),
                "estado" => input("estado"),
            ));

        }else{
            return redirecciona()->to("/");
        }
    }

    public function index_series(){
        if($_SESSION["inicio"] == true) {
            return Vista::crear("admin.consulta.index_series");
        }else{
            return redirecciona()->to("/");
        }
    }

    public function consulta_series(){
        if($_SESSION["inicio"] == true) {
            $consulta = new libreria\ORM\EtORM();
            if(input('categoria') != ""){
                $consultas = $consulta->Ejecutar("sp_buscar_series_almacenados",array(
                    input("deposito"),
                    input("estado"),
                    input("categoria")
                ));
            }else{
                $consultas = $consulta->ejecutar("sp_buscar_series_almacenados_generales",array(
                    input("deposito"),
                    input("estado")
                ));
            }
            return Vista::crear("admin.consulta.consulta_series", array(
                "consultas" => $consultas,
                "deposito" => input("deposito"),
                "cate" => input("categoria"),
                "estado" => input("estado"),
            ));

        }else{
            return redirecciona()->to("/");
        }
    }

    //Definimos el metodo para recuperar los modelos de una categoria.
    public function modelos(){
        //Recuperamos el ID de la categoria de productos.
        $idCategoria = input('idCategoria');
        //Recuperamos los modelos que pertenecen a la categoria.
        $modelos = Producto::where('id_categoria', $idCategoria);
        //Creamos la vista que vamos a retornar.
        return Vista::crear('movimiento.modelos', array(
            "modelos" => $modelos
        ));
    }
}
