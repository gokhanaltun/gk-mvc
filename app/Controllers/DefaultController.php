<?php 
    namespace App\Controllers;

    use App\Controllers\Controller;
    use App\Models\User;

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