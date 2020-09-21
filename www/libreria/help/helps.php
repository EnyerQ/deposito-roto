<?php
/**
 * Created by PhpStorm.
 * User: tactika
 * Date: 17/09/2015
 * Time: 6:51 PM
 */

function includeModels(){
    $directorio = opendir(MODELS);
    while($archivo = readdir($directorio)){
        if(!is_dir($archivo)){
            require_once MODELS.$archivo;
        }
    }
}
/*
 * Esta función nos va ayudar a retorna asset
 * - $asset : nombre del archivo a esta dentro de asset.
 */

function asset ($asset){
    //Recuperamos la URL principal para navegar.
    $urlprin = trim(str_replace("index.php","",$_SERVER["PHP_SELF"]),"/");
    //Comprobamos si tiene caracteres. Para verificar si el acceso es
    //Por nombre de HOST o IP
    if(strlen($urlprin)){
      echo "/".$urlprin."/assets/".$asset;
    }else{
      echo $urlprin."/assets/".$asset;
    }
}

/*
 * Función que nos permite cargar rutas dinamicamente.
 *  $ruta : ruta hacia donde se va a ir.
 */

function url($rute){
    if(trim($_SERVER['PHP_SELF'],'/') == 'index.php'){
      echo "/".$rute;
    }else{
      $urlprin = str_replace("index.php","",$_SERVER["PHP_SELF"]);
      echo "/".trim($urlprin,"/")."/".$rute;
    }

}
//Funcion de redireccionamiento
function redireccionar($ruta){
    $urlprin = str_replace("index.php","",$_SERVER["PHP_SELF"]);
    header("location:/".trim($urlprin,"/")."/".trim($ruta,"/"));
}

/*
 * funcion para crear token de validación
 */
session_start();
function csrf_token(){
    if(isset($_SESSION["csrf_token"])){
        unset($_SESSION["csrf_token"]);
    }
    $csrf_token = md5(uniqid(mt_rand(), true));
    $_SESSION["csrf_token"] = $csrf_token;
    echo $csrf_token;
}

/*
 * validar el token creado con la función anterios
 */

function val_csrf(){
    if($_REQUEST["_token"] == $_SESSION["csrf_token"]){
        return true;
    }else {
        return false;
    }
}
/*
 * función que permite recuperar un input
 */
function input($name){
    $re = new \Library\help\Request();
    return $re->input($name);
}

/*
 * Funcion que nos permite retornar json a partir de un array
 * */
function json_response($data)
{
    header('Content-Type: application/json');
    if (is_array($data)) {
        $array = array();
        foreach ($data as $d) {
            array_push($array, $d->getColumnas());
        }
        return json_encode($array);
    } else {
        return json_encode($data->getColumnas());
    }
}

/*
 * Funcion que nos permite retornar json a partir de un array
 * */
function jsonsp_response($data)
{
    header('Content-Type: application/json');
    if (is_array($data)) {
        $array = array();
        foreach ($data as $d) {
            array_push($array, $d[getColumnas()]);
        }
        return json_encode($array);
    } else {
        return json_encode($data[getColumnas()]);
    }
}

/*
 * función que nos permite encriptar un string
 */

function encriptar($string){
    return crypt($string,'$2a$07$usesomesillystringforsalt$');
}

/*
 * redireccionar
 */

function redirecciona(){
    return new Redirecciona();
}

//devuelve el mes en texto

function nombremes($mes){
    setlocale(LC_TIME, 'spanish');
    $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000));
    return $nombre;
}

//Recuperamos el registro de un almacén

function resgitroAlmacen($id){
  //Creamos el obejeto almacen para recuperar el registro.
  $almacen = App\model\Destino::find($id);
  if (!empty($almacen)) {
    return $almacen;
  }else{
    return 'ERROR';
  }
}
