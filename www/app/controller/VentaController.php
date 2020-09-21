<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 25/09/2015
 * Time: 12:25 AM
 */
use App\model\Venta;
use \libreria\ORM\EtORM;
class VentaController {



    public function index(){

        $venta = new Venta();
        $venta->cliente="Cesar Alan";
        $venta->fecha = date("Y-m-d");
        $venta->guardar();

    }

    public function buscar(){
        $cliente = $_REQUEST["cliente"];
        $ventasdecesar = Venta::where("cliente",$cliente);

        foreach($ventasdecesar as $venta){
            echo $venta->id." - ".$venta->cliente." - ".$venta->fecha."<br>";
        }
    }

    public function busqueda(){
        $id = $_REQUEST["id"];
        $venta = Venta::find(12);

        $venta->cliente="Ana Maria";
        $venta->guardar();
    }

    public function listado(){
        $ventas = Venta::all();

        foreach($ventas as $venta){
            echo $venta->id." - ".$venta->cliente." - ".$venta->fecha."<br>";
        }

    }

    public function eliminar(){

        $venta = Venta::find(15);
        if(count($venta)){
            if($venta->eliminar()){
                echo "eliminado correctamente";
            }else{
                echo "no se pudo eliminar";
            }
        }

    }

    public function registrar(){

        $et = new EtORM();
        $et->Ejecutar("newVenta",array("Milagros"));
        echo "guardado correctamente";
    }

    public function listar(){
        $et = new EtORM();
        $ventas = $et->Ejecutar("listar");
        foreach($ventas as $venta){
            echo $venta[1]."<br>";
        }
    }

}