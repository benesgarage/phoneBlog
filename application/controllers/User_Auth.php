<?php

include_once __DIR__.'/../third_party/WURFL/MyWurfl.php';   //We make our WURFL Class available to our pages.
Class User_Auth extends CI_Controller       //This class will control models and views related to user data.
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('encrypt');        //Use encryption tools for passwords.

        $this->load->helper('form');        //Aid in the manipulation of forms.

        $this->load->helper('url');     //Aid in the manipulation of URL.

        $this->load->library('form_validation');        //Validate forms.

        $this->load->library('session');        //Gain access to session variables.

        $this->load->model('user_auth/login_database');     //Load the model that our controller will reference.

        $this->output->set_template('default');     //Visual template for our views.
    }

    public function index()                      //This function will display the log in page via multiple views.
    {

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('user_auth/login_form');                //Our login form view.
        $this->load->view('templates/footer');
    }

    public function user_registration_show()         //This function will display the log in page via multiple views.
    {

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('user_auth/registration_form');                                //Our register form view.
        $this->load->view('templates/footer');
    }

public function new_user_registration()                          //This function will run when our regist. form submits.
    {


        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email_value', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {           //If the form validation fails, show the form again.
            $this->load->view('templates/header');
            $this->load->view('user_auth/registration_form');
            $this->load->view('templates/footer');
        } else {                                                                //Otherwise collect the user input,
            $default_role = 3;
            $salt = mcrypt_create_iv(                           //Create random salt
                mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC),
                MCRYPT_DEV_URANDOM);
            $hash = sha1($salt.$this->input->post('password')); //Prepend salt to password and hash all.
            $data = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('email_value'),
                'user_password' => $hash,
                'id_role' => $default_role,
                'salt' => $salt
            );
            $result = $this->login_database->registration_insert($data);             //and input the data into the db.
            if ($result == TRUE) {                      //If successful, show success message and go to the login form.
                $data['message_display'] = 'Registered Successfully!';
                $this->load->view('templates/header');
                $this->load->view('user_auth/login_form', $data);
                $this->load->view('templates/footer');
            } else {                    //Otherwise, assuming there is a user with the same name, we reject the input.
                $data['message_display'] = 'User already exists!';                  //We inform the user of its failure.
                $this->load->view('user_auth/registration_form', $data);
            }
        }
    }

    public function user_login_process()
    {      //This function will run  when our login form submits.

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {   //If form vaildation fails.
            if (isset($_SESSION['logged_in'])) {      //First we verify the user isn't already logged in, in that case,
                $this->load->view('user_auth/admin_page'); //we send him to his profile.
            } else {                                          //Otherwise show login form again.

                /*VIEWS LOADED*/

                $this->load->view('templates/header');
                $this->load->view('user_auth/login_form');
                $this->load->view('templates/footer');
            }
        } else {                                    //If form validation succeeds, we gather user input from the form.
            $user_data =
                $this->login_database->read_user_information($this->input->post('username')); //Get apparent user data.

            $password =                                        //Replicate users hash and compare with db.
                sha1($user_data[0]->salt . $this->input->post('password'));
            if ($user_data[0]->user_password === $password) {  //If the query is successful, we retrieve the userdata.

                $session_data = array(
                    'username' => $user_data[0]->user_name,
                    'email' => $user_data[0]->user_email,
                    'id_role' => $user_data[0]->id_role
                );

                $_SESSION['logged_in'] = $session_data;
                redirect('/posts/', 'refresh');         //Redirect success page to home.
            } else {    //If our query is unsuccessful, show login form with error message.
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('user_auth/login_form', $data);
            }
        }
    }

    public function admin_page(){       //This function will show the users profile.

        /*VIEWS LOADED*/

        $this->load->view("templates/header");
        $this->load->view("user_auth/admin_page");
        $this->load->view("templates/footer");
    }

    public function logout() {      //This function will run when the user logs out, showing a confirmation.

        unset($_SESSION['logged_in']);
        $data['message_display'] = 'Logged out';

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('user_auth/login_form', $data);
        $this->load->view('templates/footer');
    }
}