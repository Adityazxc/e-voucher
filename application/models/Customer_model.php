<?php

class Customer_model extends CI_Model
{   
    public function getVoucherData($dateFrom=null, $dateThru=null)
    {
        $this->db->order_by('date', 'DESC');
        if($dateFrom){
            $this->db->where('date >=', $dateFrom);
        }
        if($dateThru){
            $this->db->where('date <=', $dateThru);
        }
        $query = $this->db->get('customers'); 
        return $query->result();        
    }

    public function tambah($data)
    {
        try {
            $this->db->insert('customers', $data);
            return TRUE;
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return FALSE;
        }
    }

    public function searchCustomer($keyword)
    {
    
        $this->db->where('voucher', $keyword); 
        $query = $this->db->get('customers');

        if ($query->num_rows() > 0) {
            $this->db->where('voucher', $keyword);
            $this->db->update('customers', ['status' => 'Y']);
            $result = $query->result();
        } else {
            $result = false;
        }
        
        return $result;
    }

    public function reedem_voucher()
    {
        $this->db->where('id', $this->input->post('id'));
        $this->db->update('customers', ['awbno_claim' => $this->input->post('resi')]);

        return true;
    }

    public function getUsedVoucher()
    {
        $this->db->where('status', 'Y');
        $query = $this->db->get('customers');
        return $query->result();
    }
    public function getNotUsedVoucher()
    {
        $this->db->where('status', 'N');
        $query = $this->db->get('customers');
        return $query->result();
    }

    public function getUsedVoucherCount()
    {
        // Assuming your 'customers' table has a column named 'status'
        $this->db->where('status', 'Y');
        return $this->db->count_all_results('customers');
    }
    public function getSendVoucherCount()
    {                
        return $this->db->count_all_results('customers');
    }
    public function getNotUsedVoucherCount()
    {                
        $this->db->where('status', 'N');
        return $this->db->count_all_results('customers');
    }

}
?>