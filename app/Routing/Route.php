<?php 
    namespace App\Routing;

    class Route{

        protected $currentRequestUri;
        protected $currentRequestMethod;
        protected static $routes = [];


        public function __construct()
        {
            $dirname = dirname($_SERVER['SCRIPT_NAME']);
            $basename = basename($_SERVER['SCRIPT_NAME']);
            $this->currentRequestUri = str_replace([$dirname, $basename], '', $_SERVER['REQUEST_URI']);
            $this->currentRequestMethod = $_SERVER['REQUEST_METHOD'];
            $this->route();
        }

        public static function get($path, $module, $middlewares = []){
            self::$routes[] = ['GET', $path, $module, $middlewares];
        }

        public static function post($path, $module, $middlewares = []){
            self::$routes[] = ['POST', $path, $module, $middlewares];
        }

        private function route(){

            foreach(self::$routes as $route){
                list($requestMethod, $path, $module, $middlewares) = $route;
                $path = str_replace(array_keys(URL_PATTERNS), array_values(URL_PATTERNS), $path);
                
                $pattern = '@^' . $path . '\/?$@';
                $requestMethodCheck = $requestMethod == $this->currentRequestMethod;
                $pathCheck = preg_match($pattern, $this->currentRequestUri, $params);
                
                if($requestMethodCheck && $pathCheck){
                    array_shift($params);
                    
                    if(!empty($middlewares)){
                        foreach($middlewares as $middleware){
                            $middlewareClass = 'App\\Middlewares\\' . $middleware;
                            $middlewareClass = new $middlewareClass;
                            call_user_func_array([$middlewareClass, 'handle'], [$this->currentRequestMethod]);
                        }
                    }

                    if(is_callable($module)){
                        return call_user_func_array($module, $params);
                    }

                    $module = explode('@', $module);
                    list($controller, $controllerMethod) = $module;
                    $controllerFile = CONTROLLER_BASE . $controller . 'Controller.php';
                    
                    if(file_exists($controllerFile)){
                        require $controllerFile;

                        $class = explode('/', $controller);
                        $class = 'App\\Controllers\\' . end($class) . 'Controller';
                        $class = new $class;

                        return call_user_func_array([$class, $controllerMethod], $params);
                    }
                    else{
                        trigger_error('<b>(' . $controllerFile . ')</b> Dosya Bulunamadı...! ', E_USER_ERROR);
                        exit();
                    }
                    
                }
            } 

            echo 'Sayfa Bulunamadı';
        }

    }

?>