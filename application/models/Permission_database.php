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
            $query = $this->db->get('user_has_permission');
            return $query->result_array();
        }
        $this->db->select('*');
        $this->db->from('user_has_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_role_perms($id_role){
        if($id_role != FALSE) {
            $condition = "id_role =" . "'" . $id_role . "'";
        }elseif($id_role === FALSE){
            $query = $this->db->get('role_has_permission');
            return $query->result_array();
        }
        $this->db->select('*');
        $this->db->from('role_has_permission');
        $this->db->where($condition);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function read_perms($id_permission = FALSE){
        $this->db->select('*');
        $this->db->from('permission');
        if($id_permission != FALSE) {
            $this->db->where("id_permission =" . "'" . $id_permission . "'");
        }
        $query = $this->db->get();
            return $query->result_array();
    }

    public function read_roles($id_role = FALSE){
        $this->db->select('*');
        $this->db->from('role');
        if($id_role != FALSE) {
            $this->db->where("id_role =" . "'" . $id_role . "'");
            $query = $this->db->get();
            return $query->result_array();
        }
        $query = $this->db->get();
        return $query->result_array();
    }
}