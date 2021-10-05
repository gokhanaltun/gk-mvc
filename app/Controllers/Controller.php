<?php
    namespace App\Controllers;

    use App\System\TemplateRenderer;
    use App\Validators\FormValidator;


    class Controller{

        protected $renderer;
        protected $formValidator;

        public function __construct()
        {
            $this->renderer = new TemplateRenderer();
            $this->formValidator = new FormValidator();
        }
    }


?>