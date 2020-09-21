<?php

/**
 * Clase
 */
class Session
{
    //permite validar si existe una session
    public static  function has($variable_session){
        if(isset($_SESSION[$variable_session])){
            return true;
        }else {
            return false;
        }
    }

    public static  function get($variable_session){
        try{
            $mensaje = $_SESSION[$variable_session];
            unset($_SESSION[$variable_session]);
            return $mensaje;
        }catch (Exception $ex){}
    }
}