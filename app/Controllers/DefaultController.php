<?php 
    namespace GKTemplate\Controllers;

    use GKTemplate\Controllers\Controller;
    use GKTemplate\Models\User;

    class DefaultController extends Controller{

        public function __construct()
        {
            parent::__construct();

        }

        public function index(){
            $users = User::all();
            $this->renderer->render_template('default', ['users'=>$users]);
        }

    }

?>