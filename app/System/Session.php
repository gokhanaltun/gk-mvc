<?php
    namespace App\System;

    session_start();

    class Session{


        public static function add($session_name, $session_value){
            session_regenerate_id(true);
            $_SESSION[$session_name] = $session_value;
        }

        public static function addArray($session_name, $session_value){
            session_regenerate_id(true);
            for($i = 0; $i < count($session_name); $i++){
                $_SESSION[$session_name[$i]] = $session_value[$i];
            }
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
            if(isset($_SESSION[$session_name])){
                $data = $_SESSION[$session_name];
                self::delete($session_name);
                return $data;
            }
            else{
                return false;
            }
        }
    }

?>