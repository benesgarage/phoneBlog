<?php

/**
 * Model in charge of user login, registration and user info.
 *
 * Class Login_Database
 */
Class Login_Database extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    /**
     * This will be called in case of a new user registration.
     *
     * @param $data
     * @return bool
     */
    public function registration_insert($data)
    {

        $condition = "user_name =" . "'" . $data['user_name'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {         //We query the db for the username, if it doesn't exist, insert new user.

            $this->db->insert('user', $data);
            if ($this->db->affected_rows() > 0) {
                return true;                                                       //Verify the insertion has been made.
            }
        } else {
            return false;                                                             //Otherwise, reject the insertion.
        }
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
