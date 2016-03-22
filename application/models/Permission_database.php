<?php

Class Permission_database extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }


    public function read_db($id = FALSE, $table, $id_reference = NULL, $column = '*'){

        if($id != FALSE) {

            $condition = $id_reference." =" . "'" . $id . "'";
            $this->db->select($column);
            $this->db->from($table);
            $this->db->where($condition);
            $query = $this->db->get();
            return $query->result_array();

        }elseif($id === FALSE){

            $query = $this->db->get($table);
            return $query->result_array();
        }
    }
}