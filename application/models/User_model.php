<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_model extends CI_Model{
    public function get_user_details($id){
        $query= $this->db->get_where('users',array('id_user'=>$id));

        return $query->row();
    }
    public function reset_password_model($id, $password){
        $newPassword=md5($password);
        $data=array('password'=>$newPassword);
        $this->db->where('id_user',$id);
        $this->db->update('users',$data);        

        return $this->db->affected_rows()>0;
    }

    function add_user_model($user_data){
        $this->db->insert('users',$user_data);        

        return $this->db->affected_rows() > 0;
    }
}