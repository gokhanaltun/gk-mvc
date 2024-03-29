<?php 
    namespace App\System;

    class TemplateRenderer{

        private string $view;
        private string $viewPath;
        private string $cachePath;
        private array $sections = [];

        public function __construct(){}

        public function render_template(string $view, array $data = []){
            extract($data);

            $this->viewPath = VIEW_BASE . $view . TEMPLATE_PREFIX . '.php';
            $this->cachePath = CACHE_BASE . md5($view) . CACHE_PREFIX . '.php';

            if(file_exists($this->viewPath)){
                $this->view = file_get_contents($this->viewPath);
            }else{
                trigger_error('<b>(' . $this->viewPath . ')</b> Dosya Bulunamadı...! ', E_USER_ERROR);
                exit();
            }

            return require $this->process();
        }

        private function process(){
            $this->parseInclude();
            $this->parseSection();
            $this->parseYield();
            $this->parseVariables();
            $this->parseIfBlocks();
            $this->parseForeach();
            $this->parseCsrf();
            $this->parsePhp();

            $this->updateCache();
            return $this->cachePath;
        }

        /**
         * Performs parse for the following directive
         * @include 'sample.blade.php'
         */
        private function parseInclude(){
            $pattern = '/@include\s?[\'\"](.*)[\'\"]/';

            while(preg_match($pattern, $this->view)){
                $this->view = preg_replace_callback($pattern, function($params){
                    $includeFile = LAYOUT_BASE . $params[1] . TEMPLATE_PREFIX . '.php';

                    if(!file_exists($includeFile)){
                        trigger_error('<b>(' . $includeFile . ')</b> Dosya Bulunamadı...! ', E_USER_ERROR);
                        exit();
                    }

                    return file_get_contents($includeFile);
                }, $this->view);

            }
        }

        /**
         * Performs parse for the following directive
         * @section('yield_name)
         * <p>Section Content</p>
         * @endsection
         */
        private function parseSection(){

            $pattern = '/@section\([\'\"](.*?)[\'\"]\)(.*?)@endsection/s';
            $this->view = preg_replace_callback($pattern, function($params){
                $this->sections[$params[1]] = $params[2];
                return '';
            }, $this->view);

        }

        /**
         * Performs parse for the following directive
         * @yield 'yield_name'
         */
        private function parseYield(){
            $pattern = '/@yield\([\'\"](.*)[\'\"]\)/';
            $this->view = preg_replace_callback($pattern, function($params){
                if(isset($this->sections[$params[1]])){
                    return $this->sections[$params[1]];
                }else{
                    return '';
                }
            }, $this->view);
        }

        /**
         * Performs parse for the following directive
         * {{ $data }}
         */
        private function parseVariables(){
            $pattern = '/{{(.*?)}}+/';
            $this->view = preg_replace_callback($pattern, function($params){
                return '<?=' . trim($params[1]) . '?>';
            }, $this->view);
        }

        /**
         * Performs parse for the following directive
         * @if (condition) 
         * <p>Content</p>
         * @elif (condition)
         * <p>Content</p>
         * @else
         * <p>Content</p>
         * @endif
         */
        private function parseIfBlocks(){
            $this->view = preg_replace('/@(else|)if\((.*?)\)/', '<?php $1if ($2): ?>', $this->view);
            $this->view = preg_replace('/@else/', '<?php else: ?>', $this->view);
            $this->view = preg_replace('/@endif/', '<?php endif; ?>', $this->view);
        }

        /**
         * Performs parse for the following directive
         * @foreach (condition)
         * <p>Section Content</p>
         * @endforeach
         */
        private function parseForeach(){
            $pattern = '/@foreach\s?\((.*)\)/';
            $this->view = preg_replace_callback($pattern, function($params){
                return '<?php foreach (' . $params[1] . '): ?>';
            }, $this->view);

            $this->view = preg_replace('/@endforeach/', '<?php endforeach; ?>', $this->view);
        }

        /**
         * Performs parse for the following directive
         * @csrf
         */
        private function parseCsrf(){
            $pattern = '/@csrf/';
            $this->view = preg_replace_callback($pattern, function($params){
                $csrf_token = md5(time());
                Session::add('csrfToken', $csrf_token);
                return '<input type="hidden" name="csrf" value="' . $csrf_token . '">';
            }, $this->view);

        }

        /**
         * Performs parse for the following directive
         * @php
         * Some PHP Code Here
         * @endphp
         */
        private function parsePhp(){
            $this->view = preg_replace('/@php/', '<?php', $this->view);
            $this->view = preg_replace('/@endphp/', '?>', $this->view);
        }

        private function updateCache(){
            file_put_contents($this->cachePath, $this->view);
        }

    }


 ?>

