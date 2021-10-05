<?php 
    namespace App\Middlewares;

    use App\Middlewares\IMiddleware;
    
    class Auth implements IMiddleware{

        public function handle(){
            echo 'Middleware is Working...';
            exit();
        }
    }

?>