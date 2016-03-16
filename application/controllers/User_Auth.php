<?php
Class User_Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper('form');

        $this->load->helper('url');

        $this->load->library('form_validation');

        $this->load->library('session');

        $this->load->model('user_auth/login_database');

        $this->output->set_template('default');
    }

    public function index()
    {
        $this->load->view('templates/header');
        $this->load->view('user_auth/login_form');
        $this->load->view('templates/footer');
    }

    public function user_registration_show()
    {
        $this->load->view('user_auth/registration_form');
    }

    public function new_user_registration()
    {


        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email_value', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user_auth/registration_form');
        } else {
            $default_role = 3;
            $data = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('email_value'),
                'user_password' => $this->input->post('password'),
                'id_role' => $default_role
            );
            $result = $this->login_database->registration_insert($data);
            if ($result == TRUE) {
                $data['message_display'] = 'Registered Successfully!';
                $this->load->view('user_auth/login_form', $data);
            } else {
                $data['message_display'] = 'User already exists!';
                $this->load->view('user_auth/registration_form', $data);
            }
        }
    }

    public function user_login_process() {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            if(isset($_SESSION['logged_in'])){
                $this->load->view('user_auth/admin_page');
            }else{
                $this->load->view('user_auth/login_form');
            }
        } else {
            $data = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $result = $this->login_database->login($data);
            if ($result == TRUE) {

                $username = $this->input->post('username');
                $result = $this->login_database->read_user_information($username);
                if ($result != false) {
                    $session_data = array(
                        'username' => $result[0]->user_name,
                        'email' => $result[0]->user_email,
                    );

                    $_SESSION['logged_in'] = $session_data;
                    /**$this->load->view('user_auth/admin_page');*/
                    redirect('/posts/', 'refresh');
                }
            } else {
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('user_auth/login_form', $data);
            }
        }
    }

    public function logout() {


        unset($_SESSION['logged_in']);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('user_auth/login_form', $data);
    }
}