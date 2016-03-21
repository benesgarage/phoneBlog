<?php

include_once __DIR__.'/../third_party/WURFL/MyWurfl.php';      //We make our WURFL Class available to our pages.
class Posts extends CI_Controller{              //This class will control models and views related to posts.

    public function __construct()
    {
        parent::__construct();

        $this->load->model('post_model');   //Load the model that our controller will reference.

        $this->load->helper('url_helper');  //Aid in the manipulation of URL.

        $this->load->library('session');    //Gain access to session variables.

        $this->output->set_template('default'); //Visual template for our views.
    }

    public function index(){    //This function will obtain all posts and display them via the views.

        /*DATA GATHERING*/

        $data['post'] = $this->post_model->get_post();  //Acquire all posts
        $data['user'] = $this->post_model->get_user();  //Acquire all users

        /*VIEWS LOADED*/

        $this->load->view('templates/header');
        $this->load->view('posts/index', $data);    //Uses data gathered and displays all posts and related users.
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL){     //Shows requested posts.

        /*DATA GATHERING*/

        $data['post_item'] = $this->post_model->get_post($slug);    //Call to get method in Post_model
        $data['title'] = $data['post_item']['title'];

        if (empty($data['post_item']))      //If the post doesn't exist show 404.
        {
            show_404();
        }

        /*VIEWS LOADED*/

        $this->load->view('templates/header', $data);
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()        //This function will control the display and execution of a post form.
    {
        $this->load->helper('form');        //Enable the use of functions that assist in working with forums.
        $this->load->library('form_validation');        //Enable form validation

        $data['title'] = 'Create a post';

        $this->form_validation->set_rules('title', 'Title', 'required');    //Form input conditions.
        $this->form_validation->set_rules('body', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)    //If the user hasnt executed form validation, display form.
        {
            $this->load->view('templates/header', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');

        }
        else        //Otherwise run the necessary code to insert their post to the db.
        {
            $this->post_model->set_post();  //Run the method in Post_model that will insert our post.

            /*VIEWS LOADED*/

            $this->load->view('templates/header');
            $this->load->view('posts/success');     //Show the success page.
            $this->load->view('templates/footer');
        }
    }

    public function hide($slug = NULL){         //This method will modify a posts visibility to hide in the db.
        $this->post_model->hide_post($slug);    //Run the method that modifies the entry in the db.
        $this->index();                         //Return to the index page executing the index() method.
    }

    public function show($slug = NULL){         //This method will modify a posts visibility to show in the db.
        $this->post_model->show_post($slug);    //Run the method that modifies the entry in the db.
        $this->index();                         //Return to the index page executing the index() method.
    }
}