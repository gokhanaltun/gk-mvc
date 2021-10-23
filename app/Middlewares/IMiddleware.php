<?php 
    namespace App\Middlewares;

    interface IMiddleware{
        public function handle($requestMethod);
    }

?>