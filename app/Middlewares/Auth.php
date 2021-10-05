<?php 
    namespace GKTemplate\Middlewares;

    use GKTemplate\Middlewares\IMiddleware;
    
    class Auth implements IMiddleware{

        public function handle(){
            echo 'Middleware is Working...';
            exit();
        }
    }

?>