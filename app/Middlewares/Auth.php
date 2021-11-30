<?php 
    namespace App\Middlewares;

    use App\Middlewares\IMiddleware;
    
    class Auth implements IMiddleware{

        public function handle($requestMethod){
            echo 'Middleware is Working...';
            exit();
        }
    }

?>