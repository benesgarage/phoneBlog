<?php

Class Login_Database extends CI_Model                       //Model in charge of user login, registration and user info.
{
    public function __construct()
    {
        $this->load->database();
    }


    public function registration_insert($data)  //This will be called incase of a new user registration.
    {

        $condition = "user_name =" . "'" . $data['user_name'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {      //We query the db for the username, if it doesnt exist, insert new user.

            $this->db->insert('user', $data);
            if ($this->db->affected_rows() > 0) {
                return true;                //Verify the insertion has been made.
            }
        } else {
            return false;                   //Otherwise, reject the insertion.
        }
    }

    public function login($data) {          //This will be called when there is a login request.

        $condition = "user_name =" . "'" . $data['username'] .
            "' AND " . "user_password =" . "'" . $data['password'] . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();          //Get the users info, using his username and password as the conditional.

        if ($query->num_rows() == 1) {      //If the query returns exactly one row, the login is successful.
            return true;
        } else {
            return false;                   //Otherwise reject the login attempt.
        }
    }

    public function read_user_information($username) {  //Will be called when we need to request user info from the db.

        $condition = "user_name =" . "'" . $username . "'";
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where($condition);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {      //On successful query return the data.
            return $query->result();
        } else {
            return false;                   //Otherwise return false.
        }
    }

}
