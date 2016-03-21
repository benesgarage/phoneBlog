<?php

Class Permission_database extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }

    public function read_user_perms($id_user){
        if($id_user != FALSE) {
            $condition = "id_user =" . "'" . $id_user . "'";
        }elseif($id_user === FALSE){
            $query = $this->db->get('user');
            return $query->result_array();
        }
        $this->db->select('*');
        $this->db->from('user_has_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result_array();
    }
}