<?php

class Access_Control extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('db_array');

        $this->load->model('user_auth/login_database');
    }

    public function index()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : anonymous;
        if($user_role != anonymous){

            $role_perms =
                $this->login_database->read_db($_SESSION['logged_in']['id_role'],'role_has_permission','id_role');
            $perms = singular_array_transform($role_perms,"id_permission","value");

            $user_perms =
                $this->login_database->read_db($_SESSION['logged_in']['uid'],'user_has_permission','id_user');
            $perms = $perms + singular_array_transform($user_perms,"id_permission","value");

            $perm_names_array = $this->login_database->read_db(FALSE,'permission');
            $perm_names = singular_array_transform($perm_names_array,"id_permission","permission_name");

            $data = array(
                'perm_names'=> $perm_names,
                'perms' => $perms,
                );

            $this->load->view('database/header');
            $this->load->view('database/index', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }

    public function users()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : anonymous;
        if($user_role != anonymous){

            $user_array = $this->login_database->read_db(FALSE,'user');
            $user_names = singular_array_transform($user_array,"id_user","user_name");

            $data = array(
                'user_names' => $user_names
            );

            $this->load->view('database/header');
            $this->load->view('database/users', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }

    public function roles()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : anonymous;
        if($user_role != anonymous){

            $role_array = $this->login_database->read_db(FALSE,'role');
            $role_names = singular_array_transform($role_array,"id_role","role_name");

            $data = array(
                'role_names' => $role_names
            );

            $this->load->view('database/header');
            $this->load->view('database/roles', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }

    public function permissions()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : anonymous;
        if($user_role != anonymous){

            $perm_array = $this->login_database->read_db(FALSE,'permission');
            $perm_names = singular_array_transform($perm_array,"id_permission","permission_name");

            $data = array(
                'perm_names' => $perm_names
            );

            $this->load->view('database/header');
            $this->load->view('database/permissions', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }
}