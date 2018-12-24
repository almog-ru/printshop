<?php

class Cookie{
    public static function exists($name){
        return (isset($_COOKIE[$name]))? true:false;
    }

    public static function get ($name){
        return ($_COOKIE[$name]);
    }

    public static function put($name,$value,$expiry){
        if(setcookie($name,$value,$expiry+time(), '/')){
            return true;
        }
        return false;

    }


    public static function dalete($name){
        self::put($name, '', -1);

    }

}