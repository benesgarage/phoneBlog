<?php

Class Permission_database extends CI_Model{
    public function __construct()
    {
        $this->load->database();
    }

    public function modify_user_role($id_user = FALSE, $id_role = FALSE)
    {
        if($id_role != FALSE and $id_user != FALSE){
            $data = array(
                'id_role' => $id_role
            );
            $condition = "id_user =" . "'" . $id_user . "'";
            $this->db->where($condition);
            $this->db->update('user',$data);
            if($this->db->affected_rows() == 1){
                return TRUE;
            }
            return FALSE;
        }
        return FALSE;
    }

    public function modify_user_permissions($id_user = FALSE, $id_permission = FALSE , $value = NULL)
    {
        if($id_user != FALSE and $id_permission != FALSE and $value != NULL){

            $sql = 'INSERT INTO user_has_permission (id_userperm, id_user, id_permission, value)
                VALUES ( \' \', '.$id_user.', '.$id_permission.', '.$value.')
                ON DUPLICATE KEY UPDATE
                value='.$value;

            $query = $this->db->query($sql);
                return $query;
        }
        return FALSE;
    }

    public function delete_user_permissions($id_user = FALSE, $id_permission = FALSE)
    {
        if($id_user != FALSE and $id_permission != FALSE)
        {
            $condition = "id_user =" . "'" . $id_user . "' and id_permission =" . "'" . $id_permission . "'";
            $this->db->where($condition);
            if($this->db->delete('user_has_permission')){
                return TRUE;
            }
        }return FALSE;
    }
}