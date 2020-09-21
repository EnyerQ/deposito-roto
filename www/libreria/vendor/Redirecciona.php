<?php

/**
 * Created by PhpStorm.
 *
 */
class Redirecciona
{
    //Función que direcciona hacia algún lugar
    //Parametro: $url - especifica la url a donde direcciona
    public static function to($url){
        self::redirect($url);
        return new Redirecciona();
    }

    //Función que redirecciona llevando mensajes en la variable de session
    //Parametro: $var - nombre de la variable.
    //Parametro: $value - Si el parametro $var no es un array este seria el valor.
    public static function withMessage($var,$value = null){
        if(is_null($value)){
            foreach ($var as $clave => $valor) {
                $_SESSION[$clave] = $valor;
            }
        }else{
            $_SESSION[$var] = $value;
        }
        return new Redirecciona();
    }

    private function redirect($ruta){
        $url = "";
        if(trim($_SERVER['PHP_SELF'],'/') == 'index.php'){
          $url = "/".$ruta;
        }else{
          $urlprin = str_replace("index.php","",$_SERVER["PHP_SELF"]);
          $url = '/'.trim($urlprin,'/').'/'.$ruta;
        }
        header("location:".$url);
    }

}
