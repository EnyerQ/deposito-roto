<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 13/09/2015
 * Time: 2:11 AM
 */
use vista\Vista;
use App\model\User;
use App\model\Permiso;

class UsuarioController {

    public function index(){//llama a la vista de lista de usuarios
        if($_SESSION["inicio"] == true){
            $usuarios = User::all();
            return Vista::crear("admin.usuario.listado",array(
                "usuarios"=>$usuarios
            ));
        }else{
            return redirecciona()->to("/");
        }
    }

    public function nuevo(){//llama a la vista de agregar usaurio
        if($_SESSION["inicio"] == true){
            return Vista::crear("admin.usuario.crear");
        }else{
            return redirecciona()->to("/");
        }

    }

    public function agregar(){//función para actualizar un usuario
        try{
            $user = new User();
            if(input('usuario_id')){//Si se envia un id, el usuario sera actualizado.
                $user = User::find(input('usuario_id'));
            }
            $user->email = input("email");
            $user->usuario = crypt(input("usuario"),'$2a$07$usesomesillystringforsalt$');
            $user->usuariod = input("usuario");
            if(input('password')){//Si se envia un nuevo password sera actualizado, en caso contrario no
                $user->pass = crypt(input("password"),'$2a$07$usesomesillystringforsalt$');
            }
            $user->nombre = input("nombre");
            $user->id_deposito = input('deposito');
            $user->guardar();

            //Recuperamos id de usuario por medio del campo usuario.
            $recuperar = new \libreria\ORM\EtORM();
            $id_usuario = $recuperar->ejecutar("sp_recuperar_id",array($user->usuario));

            //Habilitamos o desabilitamos los privilegios de usuario.
            $eliminar_privilegios = new \libreria\ORM\EtORM();
            $eliminar_privilegios->ejecutar("sp_eliminar_privilegio",array($id_usuario[0]["id"]));

            $lista_privilegios = new \libreria\ORM\EtORM();
            $lista_permisos = $lista_privilegios->ejecutar("sp_lista_privilegio");

            foreach($lista_permisos as $lpermisos){
                if (input($lpermisos["nombre"])){

                    $permisos = new \libreria\ORM\EtORM();
                    $permisos->ejecutar("sp_insertar_privilegio",array($id_usuario[0]["id"],input($lpermisos["nombre"])));

                }
            }
            //Habilitamos o desabilitamos permisos para los distintos clientes.
            $eliminar_clientes = new \libreria\ORM\EtORM();
            $eliminar_clientes->ejecutar("sp_eliminar_permiso_cliente",array($id_usuario[0]["id"]));

            $lista_clientes = new \libreria\ORM\EtORM();
            $lista_cliente = $lista_clientes->ejecutar("sp_lista_cliente");

            foreach($lista_cliente as $lcliente){
                if (input($lcliente["razon_social"])){

                    $clientes = new \libreria\ORM\EtORM();
                    $clientes->ejecutar("sp_insertar_permiso_cliente",array($id_usuario[0]["id"],input($lcliente["razon_social"])));

                }
            }

            //Habilitamos o desabilitamos permisos para los distintos depositos.
            $eliminar_depositos = new \libreria\ORM\EtORM();
            $eliminar_depositos->ejecutar("sp_eliminar_permiso_deposito",array($id_usuario[0]["id"]));

            $lista_depositos = new \libreria\ORM\EtORM();
            $lista_deposito = $lista_depositos->ejecutar("sp_lista_deposito");

            foreach($lista_deposito as $ldeposito){
                if (input($ldeposito["nombre"])){

                    $ins_depositos = new \libreria\ORM\EtORM();
                    $ins_depositos->ejecutar("sp_insertar_permiso_deposito",
                    array($id_usuario[0]["id"],input($ldeposito["nombre"])));

                }
            }


            redirecciona()->to("usuario");
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
        $usuario = User::find($id);
        if(count($usuario)){
            if($_SESSION["inicio"] == true){
                return Vista::crear('admin.usuario.crear',array(
                    "usuario"=>$usuario,
                ));
            }
        }
        return redirecciona()->to("usuario");
    }

    public function eliminar($id){
        $usuario = User::find($id);
        if(count($usuario)){
            $usuario->eliminar();
            return redirecciona()->to("usuario");
        }
        return redirecciona()->to("usuario");
    }

    public function perfil(){
        $usuario = User::find($_SESSION['id']);
        if(count($usuario)){
            if($_SESSION["inicio"] == true){
                return Vista::crear('admin.usuario.perfil',array(
                    "usuario"=>$usuario,
                ));
            }
        }
    }

}
