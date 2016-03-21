<?php
class Post_model extends CI_Model{              //Model in charge of posts.
    public function __construct()

    {
        $this->load->database();
    }

    public function get_post($slug = FALSE){    //This will be called when we want to retrieve one or all posts.

        if ($slug === FALSE){       //If the slug parameter defaults to false, we return all posts.

            $query = $this->db->get('post');
            return $query->result_array();
        }
        /*Otherwise, we use the data provided by the parameter and find the one post referenced in the db*/

        $id_pos = strpos($slug, '_');   //Our post ID is prefixed by a "_" in the slug
        $id_post = substr($slug, $id_pos+1);    //We acquire the substring pertaining to the post ID
        $slug = substr($slug,0,$id_pos);    //And we acquire the original slug, which corresponds to the post title.
        $query = $this->db->get_where('post',array('slug' => $slug, 'id_post' => $id_post));    //Do the query.
        return $query->row_array();     //Return the query.
    }

    public function get_user($id_user = FALSE){     //This will be called when we want to retrieve one or all users.

        if ($id_user === FALSE){        //If the user ID defaults to false return all users.

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
                die('No record of logged user within the database.');
            }
        }else {
            $user = 1;
        }

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $current_date = date('Y-m-d H:i:s', time());

        $data = array(
            'title' => $this->input->post('title'),
            'body' => $this->input->post('body'),
            'slug' => $slug,
            'datetime' => $current_date,
            'id_user' => $user,
            'device' => $_SESSION['brand_name']." ".$_SESSION['model_name']
        );

        return $this->db->insert('post', $data);
    }

    public function hide_post($slug = NULL){
        if($slug == NULL){
            die('Unknown post');
        }else{
            $id_pos = strpos($slug, '_');
            $id_post = substr($slug, $id_pos+1);
            $slug = substr($slug,0,$id_pos);
            $this->db->query('UPDATE post SET hide=\'1\' WHERE id_post='.$id_post.';');
        }
    }

    public function show_post($slug = NULL){
        if($slug == NULL){
            die('Unknown post');
        }else{
            $id_pos = strpos($slug, '_');
            $id_post = substr($slug, $id_pos+1);
            $slug = substr($slug,0,$id_pos);
            $this->db->query('UPDATE post SET hide=\'0\' WHERE id_post='.$id_post.';');
        }
    }
}