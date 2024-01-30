<?php

class Customer_model extends CI_Model {
    // public function getVoucherData() {
    //     $query = $this->db->get('customers'); // Sesuaikan dengan nama tabel Anda
    //     return $query->result();
    // }
    public function getVoucherData() {
        $query = $this->db->get('customers'); // Sesuaikan dengan nama tabel Anda
        return $query->result();
    }

    public function insert_customer($data){
        $this->db->insert('customers',$data);
        return TRUE;
    }
}
?>