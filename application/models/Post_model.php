<?php
class Post_model extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_post($slug = FALSE){

        if ($slug === FALSE){

            $query = $this->db->get('post');
            return $query->result_array();
        }

        $query = $this->db->get_where('post',array('slug' => $slug));
        return $query->row_array();
    }

    public function set_post(){

        $this->load->helper('url');

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $current_date = date('Y-m-d H:i:s', time());

        $data = array(
            'title' => $this->input->post('title'),
            'body' => $this->input->post('body'),
            'slug' => $slug,
            'datetime' => $current_date
        );

        return $this->db->insert('post', $data);
    }
}