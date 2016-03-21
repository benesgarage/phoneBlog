<?php

include_once __DIR__.'/../third_party/WURFL/MyWurfl.php';
/**
 * This class will control models and views related to user data.
 *
 * Class User_Auth
 */
Class User_Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->library('encrypt');                                           //Use encryption tools for passwords.

        $this->load->helper('form');                                                 //Aid in the manipulation of forms.

        $this->load->helper('url');                                                    //Aid in the manipulation of URL.

        $this->load->library('form_validation');                                                       //Validate forms.

        $this->load->library('session');                                             //Gain access to session variables.

        $this->load->model('user_auth/login_database');             //Load the model that our controller will reference.

        $this->output->set_template('default');                                         //Visual template for our views.
    }

    /**
     *
     * This function will display the log in page via multiple views.
     *
     * @param null $data
     */
    public function index($data = NULL)
    {

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('user_auth/login_form', $data);                                         //Our login form view.
        $this->load->view('templates/footer');
    }

    /**
     *
     * This function will display the log in page via multiple views.
     *
     */
    public function user_registration_show()
    {

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('user_auth/registration_form');                                      //Our register form view.
        $this->load->view('templates/footer');
    }

    /**
     *
     * This function will run when our registration form submits.
     *
     */
public function new_user_registration()
    {


        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('email_value', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == FALSE) {               //If the form validation fails, show the form again.
            $this->load->view('templates/header');
            $this->load->view('user_auth/registration_form');
            $this->load->view('templates/footer');
        } else {                                                                     //Otherwise collect the user input,
            $default_role = 3;
            $options=[
                'cost' => 12,
                'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)
            ];
            $hash = password_hash($this->input->post('password'), PASSWORD_BCRYPT,$options); //Hash password.
            $data = array(
                'user_name' => $this->input->post('username'),
                'user_email' => $this->input->post('email_value'),
                'user_password' => $hash,
                'id_role' => $default_role
            );
            $result = $this->login_database->registration_insert($data);               //and input the data into the db.
            if ($result == TRUE) {                       //If successful, show success message and go to the login form.
                $data['message_display'] = 'Registered Successfully!';
                $this->load->view('templates/header');
                $this->load->view('user_auth/login_form', $data);
                $this->load->view('templates/footer');
            } else {                      //Otherwise, assuming there is a user with the same name, we reject the input.
                $data['message_display'] = 'User already exists!';                  //We inform the user of its failure.
                $this->load->view('user_auth/registration_form', $data);
            }
        }
    }

    /**
     *
     * This function will run  when our login form submits.
     *
     */
    public function user_login_process()
    {

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == FALSE) {                                        //If form vaildation fails.
            if (isset($_SESSION['logged_in'])) {       //First we verify the user isn't already logged in, in that case,
                $this->load->view('user_auth/admin_page');                                 //we send him to his profile.
            } else {                                                                  //Otherwise show login form again.

                /*VIEWS LOADED*/

                $this->load->view('templates/header');
                $this->load->view('user_auth/login_form');
                $this->load->view('templates/footer');
            }
        } else {                                      //If form validation succeeds, we gather user input from the form.
            $user_data =
                $this->login_database->read_user_information($this->input->post('username'));  //Get apparent user data.


            if (
            password_verify(
                $this->input->post('password'),
                $user_data[0]->user_password
            )) {                                                             //If the password matches, fetch user data.

                $session_data = array(
                    'username' => $user_data[0]->user_name,
                    'email' => $user_data[0]->user_email,
                    'id_role' => $user_data[0]->id_role
                );

                $_SESSION['logged_in'] = $session_data;
                redirect('/posts/', 'refresh');                                         //Redirect success page to home.
            } else {                                 //If our query is unsuccessful, show login form with error message.
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('user_auth/login_form', $data);
            }
        }
    }

    /**
     *
     * This function will show the users profile.
     *
     */
    public function admin_page(){

        /*VIEWS LOADED*/

        $this->load->view("templates/header");
        $this->load->view("user_auth/admin_page");
        $this->load->view("templates/footer");
    }

    /**
     * This function will run when the user logs out, showing a confirmation.
     */
    public function logout() {

        unset($_SESSION['logged_in']);
        $data['message_display'] = 'Logged out';

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('user_auth/login_form', $data);
        $this->load->view('templates/footer');
    }
}