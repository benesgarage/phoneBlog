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

    public function get_user($id_user = FALSE){

        if ($id_user === FALSE){

            $query = $this->db->get('user');
            return $query->result_array();
        }

        $query = $this->db->get_where('user',array('id_user' => $id_user));
        return $query->row_array();
    }

    public function set_post(){

        $this->load->helper('url');
        if (isset($_SESSION['logged_in'])){
            $query = $this->db->get_where('user', array('user_name' => $_SESSION['logged_in']['username']));
            if ($query->num_rows() > 0){
                $query_data = $query->row_array();
                $user = $query_data['id_user'];
            }
            else{

            }
        }else {
            $user = 2;
        }
        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $current_date = date('Y-m-d H:i:s', time());

        $data = array(
            'title' => $this->input->post('title'),
            'body' => $this->input->post('body'),
            'slug' => $slug,
            'datetime' => $current_date,
            'id_user' => $user
        );

        return $this->db->insert('post', $data);
    }
}