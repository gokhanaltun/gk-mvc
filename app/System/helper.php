<?php 

    use App\System\Session;
    
    function redirect($route){
        header('Location: ' . pagePath($route));
        exit();
    }

    function back($name = null, $value = null){
        if($name != null && $value != null){
            Session::add($name, $value);
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    function session_get_once($name){
        return Session::get_once($name);
    }

    function resourcePath(){
        $sourcePath = "app/Resources";
        if(isset($_GET['requestUri'])){
            $requestUri = explode('/', $_GET['requestUri']);
            $sourcePrefix = "";
            if($requestUri > 1){
                for($i = 0; $i < count($requestUri) - 1; $i++){
                    $sourcePrefix = $sourcePrefix . "../";
                }
    
                return $sourcePrefix . $sourcePath;
            }else{
                return $sourcePath;
            }
        }else{
            return $sourcePath;
        }
    }

    function pagePath($page){
        $pagePath = "";
        if($page != "/"){
            $pagePath = $page;
        }
        if(isset($_GET['requestUri'])){
            $requestUri = explode('/', $_GET['requestUri']);
            $prefix = "";
            for($i = 0; $i < count($requestUri); $i++){
                $prefix = $prefix . ".";
            }
            return $prefix . "/" . $pagePath;
        }else{
            return $pagePath;
        }
    }
?>