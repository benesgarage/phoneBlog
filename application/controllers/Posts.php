<?php

require_once __DIR__.'/../../assets/php/MyWurfl.php';
class Posts extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('post_model');
        $this->load->helper('url_helper');
        $this->load->library('session');
        $this->output->set_template('default');
    }

    public function index(){
        $data['post'] = $this->post_model->get_post();
        $data['user'] = $this->post_model->get_user();
        $data['title'] = 'Post archive';
        $this->load->view('templates/header', $data);
        $this->load->view('posts/index', $data);
        $this->load->view('templates/footer');
    }

    public function view($slug = NULL)
    {
        $data['post_item'] = $this->post_model->get_post($slug);

        if (empty($data['post_item']))
        {
            show_404();
        }

        $data['title'] = $data['post_item']['title'];

        $this->load->view('templates/header', $data);
        $this->load->view('posts/view', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');

        $data['title'] = 'Create a post';

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('body', 'Text', 'required');

        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('templates/header', $data);
            $this->load->view('posts/create');
            $this->load->view('templates/footer');

        }
        else
        {
            $this->post_model->set_post();
            $this->load->helper('url');
            $data = array(
                'slug' => url_title($this->input->post('title'), 'dash', TRUE)
            );
            $this->load->view('templates/header');
            $this->load->view('posts/success', $data);
            $this->load->view('templates/footer');
        }
    }

    public function success($slug = NULL){

    }
}