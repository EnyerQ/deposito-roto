<?php

/**
 * Created by Charly.
 */

use \vista\Vista;
use App\model\User;
use libreria\ORM\EtORM;

class AuthController
{
    public function index()
    {
        return Vista::crear("auth.login");
    }

    /*public function error(){
        if(Session::has("estado")){
            echo Session::get("estado");
        }
    }*/

    public function ingresar()
    {
        if (val_csrf()) {
            $usu = encriptar(input("usuario"));
            $password = encriptar(input("password"));
            $cliente = input("cliente");
            $objOrm = new EtORM();
            $data = $objOrm->Ejecutar("sp_login_user", array($usu, $password));

            //Verificamos que el usuario exista y coincida la contraseña.
            if (count($data) > 0) {
                $_SESSION['id'] = $data[0]["id"];
                $_SESSION['usuario'] = $data[0]["usuario"];
                $_SESSION['email'] = $data[0]["email"];
                $_SESSION['nombre'] = $data[0]["nombre"];
                $_SESSION['deposito'] = $data[0]["id_deposito"];
                $_SESSION['cliente'] = $cliente;
                $_SESSION['inicio'] = true;

                //Recuperamos el nombre del cliente sobre el que nos logueamos.
                $nombre_client = new EtORM();
                $name_client = $nombre_client->ejecutar("sp_nombre_cliente", array($cliente));
                if (count($name_client) > 0) {

                    $_SESSION['razon_social'] = $name_client[0]["razon_social"];
                }
                //Recuperamos el nombre del depósito por defecto para el usuario.
                $nombre_depo = new EtORM();
                $name_depo = $nombre_depo->ejecutar("sp_nombre_deposito", array($_SESSION['deposito']));
                if (count($name_depo) > 0) {

                    $_SESSION['nombre_deposito'] = $name_depo[0]["nombre"];
                }


                //Validamos si el usuario tiene permisos para este cliente.
                $client = new EtORM();
                $validar_cliente = $client->Ejecutar("sp_verificar_permiso_cliente", array($data[0]["id"], $cliente));

                if (count($validar_cliente) > 0) {
                    $privis = new \libreria\ORM\EtORM();
                    $privi = $privis->ejecutar("sp_lista_privilegio");
                    foreach ($privi as $pri) {
                        $ver_privi = new \libreria\ORM\EtORM();
                        $verifica = $ver_privi->ejecutar("sp_verificar_privilegio", array($data[0]["id"], $pri["id"]));
                        if (count($verifica) > 0) {
                            $_SESSION[$pri["nombre"]] = true;
                        } else {
                            $_SESSION[$pri["nombre"]] = false;
                        }
                    }
                    redirecciona()->to("admin");
                } else {
                    redirecciona()->to("login")->withMessage(array(
                        "estado" => "false",
                        "mensaje" => "No cuenta con permisos para este cliente "
                    ));
                }
            } else {
                redirecciona()->to("login")->withMessage(array(
                    "estado" => "false",
                    "mensaje" => "Usuario o pasword incorrecto"
                ));
            }
        } else {
            echo "El formulario de ingreso caduco su vigencia. Por favor vuelva a intentarlo....";
        }
    }

    public function salir()
    {
        session_destroy();
        return redirecciona()->to("/");
    }
    //Cambio de password desde el perfil de usuario para el acceso a la APP.
    public function cambiarPassword()
    {
        $password = encriptar(input("pass1"));
        $usu = $_SESSION['usuario'];
        $objOrm = new EtORM();
        $data = $objOrm->Ejecutar("sp_login_user", array($usu, $password));

        if (count($data) > 0) {
            if (input('pass2') == input('pass3')) {
                $usuario = User::find($_SESSION['id']);
                $usuario->pass = encriptar(input('pass2'));
                $usuario->guardar();
                redirecciona()->to("/usuario/perfil")->withMessage(array(
                    "estado" => "false",
                    "alert" => "success",
                    "tipo" => "¡CORRECTO!",
                    "mensaje" => "¡La contraseña se cambió correctamente!"
                ));
            } else {
                redirecciona()->to("/usuario/perfil")->withMessage(array(
                    "estado" => "false",
                    "alert" => "info",
                    "tipo" => "¡ADVERTENCIA!",
                    "mensaje" => "¡La nueva contraseña no es igual en ambas casillas!"
                ));
            }
        } else {
            redirecciona()->to("/usuario/perfil")->withMessage(array(
                "estado" => "false",
                "alert" => "danger",
                "tipo" => "¡ERROR!",
                "mensaje" => "¡La contraseña actual no es la correcta!"
            ));
        }
    }
    //Cambio del nombre de usuario desde el perfil para el acceso a la APP.
    public function cambiarUser()
    {
        $password = encriptar(input("user1"));
        $usu = $_SESSION['usuario'];
        $objOrm = new EtORM();
        $data = $objOrm->Ejecutar("sp_login_user", array($usu, $password));

        if (count($data) > 0) {
            if (input('user2') == input('user3')) {
                $usuario = User::find($_SESSION['id']);
                $usuario->usuario = encriptar(input('user2'));
                $usuario->usuariod = input('user2');
                $usuario->guardar();
                redirecciona()->to("/usuario/perfil")->withMessage(array(
                    "estado" => "false",
                    "alert" => "success",
                    "tipo" => "¡CORRECTO!",
                    "mensaje" => "¡El nombre de usuario se cambió correctamente!"
                ));
            } else {
                redirecciona()->to("/usuario/perfil")->withMessage(array(
                    "estado" => "false",
                    "alert" => "info",
                    "tipo" => "¡ADVERTENCIA!",
                    "mensaje" => "¡No coincide el nuevo nombre de usuario en ambas casillas!"
                ));
            }
        } else {
            redirecciona()->to("/usuario/perfil")->withMessage(array(
                "estado" => "false",
                "alert" => "danger",
                "tipo" => "¡ERROR!",
                "mensaje" => "¡La contraseña no es la correcta!"
            ));
        }
    }
}