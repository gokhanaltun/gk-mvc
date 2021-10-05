<?php
    namespace GKTemplate\Controllers;

    use GKTemplate\System\TemplateRenderer;
    use GKTemplate\Validators\FormValidator;


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