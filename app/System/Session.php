<?php
    namespace App\System;

    session_start();

    class Session{


        public static function add($session_name, $session_value){
            $_SESSION[$session_name] = $session_value;
        }

        public static function delete($session_name){
            unset($_SESSION[$session_name]);
        }

        public static function deleteAll(){
            unset($_SESSION);
        }

        public static function check($session_name){
            if(isset($_SESSION[$session_name])){
                return true;
            }else{
                return false;
            }
        }

        public static function get($session_name){
            return $_SESSION[$session_name];
        }

        public static function get_once($session_name){
            $data = $_SESSION[$session_name];
            self::delete($session_name);
            return $data;
        }
    }

?>