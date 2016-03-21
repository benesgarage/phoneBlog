<?php

include_once __DIR__.'/../third_party/WURFL/MyWurfl.php';

class Access_Control extends CI_Controller{

    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');

        $this->load->helper('url');

        $this->load->model('user_auth/login_database');
    }

    public function index()
    {
        $user_role = isset($_SESSION['logged_in']) ? $_SESSION['logged_in']['id_role'] : -1;
        if($user_role == 1){
            $data =
                $this->login_database->read_user_information(
                    $_SESSION['logged_in']['username']);

            $this->load->view('database/header');
            $this->load->view('database/index', $data);
            $this->load->view('database/footer');
        }elseif($user_role == -1){
            redirect('/User_Auth/index');
        }else{
            redirect('/posts');
        }
    }
}