<?php

/**
 * User: c_mat
 * Date: 18/07/2016
 * Time: 2:15 PM
 */
use vista\Vista;
use App\model\Categoria;

class CategoriaController
{
    public function index(){
        if($_SESSION["inicio"] == true) {
            $titulo = "Categorias";
            $categoria = Categoria::where("id_cliente",$_SESSION["cliente"]);
            return Vista::crear("admin.categoria.index", array(
                "categorias" => $categoria,
                "tituloPagina"=>$titulo,
            ));
        }else{
            return redirecciona()->to("/");
        }
    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true) {
            $titulo = "";
            return Vista::crear("admin.categoria.crear",array(
              "tituloPagina"=>$titulo,
            ));
        }else{
            return redirecciona()->to("/");
        }
    }

    public function agregar(){//función para actualizar un usuario
        try{
            $categoria = new Categoria();
            if(input('categoria_id')) {//Si se envia un id, el usuario sera actualizado.
                $categoria = Categoria::find(input('categoria_id'));
            }
            $categoria->codigo = input("codigo");
            $categoria->nombre = input("nombre");
            $categoria->descripcion = input('descripcion');
            $categoria->id_cliente = $_SESSION["cliente"];
            $categoria->seriable = input("seriable");
            $categoria->minimo = input("minimo");
            $categoria->medio = input("medio");
            $categoria->guardar();

            redirecciona()->to("categoria/index");
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
        $categoria = Categoria::find($id);
        if(count($categoria)){
            if($_SESSION["inicio"] == true){
                $titulo = "";
                return Vista::crear('admin.categoria.crear',array(
                    "categoria"=>$categoria,
                    "tituloPagina"=>$titulo,
                ));
            }
        }
        return redirecciona()->to("categoria/index");
    }

    public function eliminar($id){
        $categoria = Categoria::find($id);
        if(count($categoria)){
            $categoria->eliminar();
            return redirecciona()->to("categoria/index");
        }
        return redirecciona()->to("categoria/index");
    }

    public  function categoriaLista(){
        $cate = new libreria\ORM\EtORM();
        $categorias = $cate->ejecutar("sp_lista_categoria",array($_SESSION['cliente']));
        echo json_encode($categorias);

    }
}
