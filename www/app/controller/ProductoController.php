<?php

/**
 * Created by PhpStorm.
 */
use vista\Vista;
use App\model\Producto;

class ProductoController
{

    public function index()
    {
        if ($_SESSION["inicio"] == true) {
            $prod = new libreria\ORM\EtORM();
            $productos = $prod->ejecutar("sp_lista_producto", array($_SESSION['cliente']));
            return Vista::crear("admin.producto.index", array(
                "productos" => $productos,
            ));
        } else {
            return redirecciona()->to("/");
        }
    }

    public function todos()
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_lista_producto", array($_SESSION['cliente']));
        echo json_encode($productos);
    }

    public function nuevo()
    { //llama a la vista de agregar usaurio
        if ($_SESSION["inicio"] == true) {
            return Vista::crear("admin.producto.crear");
        } else {
            return redirecciona()->to("/");
        }
    }

    public function agregar()
    { //función para actualizar un usuario
        try {
            $producto = new Producto();
            if (input('producto_id')) { //Si se envia un id, el usuario sera actualizado.
                $producto = Producto::find(input('producto_id'));
            }
            $producto->codigo = input("codigo");
            $producto->modelo = input("modelo");
            $producto->descripcion = input('descripcion');
            $producto->id_categoria = input('categoria');
            $producto->id_marca = input('marca');
            $producto->id_cliente = $_SESSION["cliente"];
            $producto->guardar();

            redirecciona()->to("producto/index");
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Metodo para editar usuarios.
     * @param $id id del usuario a editar
     * @return redireccionar
     */
    public function editar($id)
    {
        $producto = Producto::find($id);
        if (count($producto)) {
            if ($_SESSION["inicio"] == true) {
                return Vista::crear('admin.producto.crear', array(
                    "producto" => $producto,
                ));
            }
        }
        return redirecciona()->to("producto/index");
    }

    public function eliminar($id)
    {
        $producto = Producto::find($id);
        if (count($producto)) {
            $producto->eliminar();
            return redirecciona()->to("producto/index");
        }
        return redirecciona()->to("producto/index");
    }

    //enviamos un JSON con los modelos según la categoria enviada

    public function filtrado($categoria)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_lista_producto_categoria", array($categoria, $_SESSION['cliente']));
        echo json_encode($productos);
    }

    //Función que devuelve un JSON de los detalles de los movimiento.

    public function detalle($id_movimiento)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_recuperar_detalle", array($id_movimiento));
        echo json_encode($productos);
    }

    //Función que devuelve un JSON de los detalles de los movimientos pero sin id.

    public function detalle_id($id_movimiento)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_recuperar_detalle_sin_id", array($id_movimiento));
        echo json_encode($productos);
    }

    //Recuperamos en un JSON el listado de numero de series afectados a un determinado movimiento.
    public function serie($id_movimiento)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_detalle_serie", array($id_movimiento));
        echo json_encode($productos);
    }
    //Recuperamos todos los productos de un almacen o estado en particular
    public function cerrar($id_destino)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_detalle_cerrar", array($_SESSION["cliente"], $_SESSION['deposito'], $id_destino));
        echo json_encode($productos);
    }
    //Recuperamos en un JSON el listado de numero de series afectados a un determinado movimiento.
    public function cerrarserie($id_destino)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_serie_cerrar", array($id_destino));
        echo json_encode($productos);
    }

    //Recuperamos los productos y cantidades que tenemos en un almacen determinado.

    public function almacenados($id_almacen, $id_deposito)
    {
        $prod = new libreria\ORM\EtORM();
        $productos = $prod->ejecutar("sp_listar_productos_disponibles", array($_SESSION['cliente'], $id_deposito, $id_almacen));
        echo json_encode($productos);
    }
}