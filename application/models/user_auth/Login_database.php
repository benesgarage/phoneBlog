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
    /**
     * This will be called when we need to request user info from the db.
     *
     * The function can accept multiple parameters, type int and type string.
     * the method recognises strings as the username, and integers as user IDs.
     *
     * @param bool $user_id
     * @return bool
     */
    public function read_user_information($user_id = FALSE) {
        if(is_string($user_id)) {
            $condition = "user_name =" . "'" . $user_id . "'";
        }elseif(is_int($user_id)) {
            $condition = "id_user =" . "'" . $user_id . "'";
        }elseif($user_id === FALSE){
            $query = $this->db->get('user');
            return $query->result_array();
        }
            $this->db->select('*');
            $this->db->from('user');
            $this->db->where($condition);
            $this->db->limit(1);
            $query = $this->db->get();

        if ($query->num_rows() == 1) {                                            //On successful query return the data.
            return $query->result();
        } else {
            return false;                                                                      //Otherwise return false.
        }
    }

}
