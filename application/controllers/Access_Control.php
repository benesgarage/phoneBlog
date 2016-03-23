<?php

class Access_Control extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('db_array');

        $this->load->model('user_auth/login_database');

        $this->load->helper('form');

        $this->load->library('form_validation');

        $this->load->model('permission_database');
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

            $title = 'Select a user to manage:';

            $element = 'user_edit';

            $data = array(
                'object_title' => $title,
                'names' => $user_names,
                'element' => $element,
            );

            $this->load->view('database/header');
            $this->load->view('database/element', $data);
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

            $title = 'Select a role to manage:';

            $element = 'role_edit';

            $data = array(
                'object_title' => $title,
                'names' => $role_names,
                'element' => $element
            );

            $this->load->view('database/header');
            $this->load->view('database/element', $data);
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

            $title = 'Select a permission to manage:';

            $element = 'permission_edit';

            $data = array(
                'object_title' => $title,
                'names' => $perm_names,
                'element' => $element
            );

            $this->load->view('database/header');
            $this->load->view('database/element', $data);
            $this->load->view('database/footer');
        }else{
            redirect('/User_Auth/index');
        }
    }

    public function user_edit($slug = NULL)
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : anonymous;
        if($user_role != anonymous){

            $id_pos = strpos($slug, '_');
            $id_user = substr($slug, $id_pos + 1);
            $user_name = substr($slug, 0, $id_pos);

            if ($this->input->post('submit') == TRUE) {

                $form_data = $this->input->post();
                unset($form_data['submit']);

                if($this->permission_database->modify_user_role($id_user, $form_data['role']) == TRUE){
                    echo 'Role Modified!';
                }
                unset($form_data['role']);

                foreach($form_data as $perm_id => $value){
                    if($value == ''){
                        echo 'Nothing has changed.';
                    }
                    if($value == -1){
                        if($this->permission_database->delete_user_permissions($id_user, $perm_id) == TRUE){
                            echo ' Permission Deleted! ';
                        }
                        continue;
                    }
                    if($this->permission_database->modify_user_permissions($id_user, $perm_id, $value) == TRUE){
                        echo ' Permission Changed! ';
                    }
                }

                redirect('/access_control/user_edit/'.$slug);

            }else{

                $role_array = $this->login_database->read_db(FALSE, 'role');
                $role_names = singular_array_transform($role_array, "id_role", "role_name");

                $perm_array = $this->login_database->read_db(FALSE, 'permission');
                $perm_names = singular_array_transform($perm_array, "id_permission", "permission_name");

                $user_perms =
                    $this->login_database->read_db($id_user, 'user_has_permission', 'id_user');
                $perms = singular_array_transform($user_perms, "id_permission", "value");

                $managed_user_data =
                    $this->login_database->read_db($id_user,'user','id_user');

                $perm_functions = array(
                    1 => 'Enable',
                    0 => 'Disable',
                    -1 => 'Inherit'
                );

                $data = array(
                    'method' => 'user_edit',
                    'manage_message' => 'Managing: '.$user_name,
                    'perm_names' => $perm_names,
                    'role_names' => $role_names,
                    'perms' => $perms,
                    'slug' => $slug,
                    'functions' => $perm_functions,
                    'managed_user_data' => $managed_user_data[0]
                );

                $this->load->view('database/header');
                $this->load->view('database/user', $data);
                $this->load->view('database/footer');
            }
        }

    }

    public function role_edit($slug = NULL){

        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : anonymous;
        if($user_role != anonymous) {

            $id_pos = strpos($slug, '_');
            $id_role = substr($slug, $id_pos + 1);
            $role_name = substr($slug, 0, $id_pos);

            if($this->input->post('submit') == TRUE){

                $form_data = $this->input->post();
                unset($form_data['submit']);

                foreach($form_data as $perm_id => $value){
                    if($value == ''){
                        echo 'Nothing has changed.';
                    }
                    if($value == -1){
                        if($this->permission_database->delete_role_permissions($id_role, $perm_id) == TRUE){
                            echo ' Permission Deleted! ';
                        }
                        continue;
                    }
                    if($this->permission_database->modify_role_permissions($id_role, $perm_id, $value) == TRUE){
                        echo ' Permission Changed! ';
                    }
                }
                redirect('/access_control/role_edit/'.$slug);
            }else {

                $perm_array = $this->login_database->read_db(FALSE, 'permission');
                $perm_names = singular_array_transform($perm_array, "id_permission", "permission_name");

                $role_perms =
                    $this->login_database->read_db($id_role, 'role_has_permission', 'id_role');
                $perms = singular_array_transform($role_perms, "id_permission", "value");

                $perm_functions = array(
                    1 => 'Enable',
                    0 => 'Disable',
                    -1 => 'Inherit'
                );

                $data = array(
                    'method' => 'role_edit',
                    'manage_message' => 'Managing role: ' . $role_name,
                    'perm_names' => $perm_names,
                    'perms' => $perms,
                    'slug' => $slug,
                    'functions' => $perm_functions,
                );

                $this->load->view('database/header');
                $this->load->view('database/user', $data);
                $this->load->view('database/footer');
            }
        }
    }


}