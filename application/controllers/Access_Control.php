<?php

include_once __DIR__.'/../third_party/WURFL/MyWurfl.php';

class Access_Control extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        $this->load->helper('url');

        $this->load->model('user_auth/login_database');

        $this->load->model('permission_database');
    }

    public function index()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : 2;
        if($user_role != 2){
            $perms = array();
            $perm_names = array();

            $role_perms = $this->permission_database->read_role_perms($_SESSION['logged_in']['id_role']);

            foreach ($role_perms as $role_perms_entry){
                $perms[$role_perms_entry["id_permission"]] = $role_perms_entry["value"];
            }
            $user_perms = $this->permission_database->read_user_perms($_SESSION['logged_in']['username']);
            foreach ($user_perms as $user_perms_entry){
                $perms[$user_perms_entry["id_permission"]] = $user_perms_entry["value"];
            }
            $perm_names_array = $this->permission_database->read_perms();
            foreach ($perm_names_array as $perm_name){
                $perm_names[$perm_name["id_permission"]] = $perm_name["permission_name"];
            }
            $role_name = $this->permission_database->read_roles($user_role);

            $data = array(
                'perm_names'=> $perm_names,
                'perms' => $perms,
                'role_name' => $role_name[0]["role_name"]

                );

            $this->load->view('database/header');
            $this->load->view('database/index', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }
}