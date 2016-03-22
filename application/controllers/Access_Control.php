<?php

include_once __DIR__.'/../third_party/WURFL/MyWurfl.php';

class Access_Control extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('db_array');

        $this->load->library('session');

        $this->load->helper('url');

        $this->load->model('user_auth/login_database');

        $this->load->model('permission_database');
    }

    public function index()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : Anonymous;
        if($user_role != Anonymous){

            $role_perms =
                $this->permission_database->read_db($_SESSION['logged_in']['id_role'],'role_has_permission','id_role');
            $perms = singular_array_transform($role_perms,"id_permission","value");

            $user_perms =
                $this->permission_database->read_db($_SESSION['logged_in']['uid'],'user_has_permission','id_user');
            $perms = $perms + singular_array_transform($user_perms,"id_permission","value");

            $perm_names_array = $this->permission_database->read_db(FALSE,'permission');
            $perm_names = singular_array_transform($perm_names_array,"id_permission","permission_name");

            $role_name = $this->permission_database->read_db($user_role,'role','id_role');



            $data = array(
                'perm_names'=> $perm_names,
                'perms' => $perms,
                'role_name' => $role_name[0]["role_name"],
                );

            $this->load->view('database/header');
            $this->load->view('database/index', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }

    public function users(){

    }
}