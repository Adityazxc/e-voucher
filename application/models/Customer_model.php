<?php

class Customer_model extends CI_Model
{
    public function getVoucherData($dateFrom = null, $dateThru = null)
    {

        $this->db->order_by('date', 'DESC');
        if ($dateFrom) {
            $this->db->where('date >=', $dateFrom);
        }
        if ($dateThru) {
            $this->db->where('date <=', $dateThru);
        }
        $query = $this->db->get('customers');
        return $query->result();
    }

    public function getImportData()
    {
        $this->db->order_by('date', 'DESC');
        $today = date('Y-m-d');
        $this->db->where('DATE(date)', $today);
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
    public function getCustomerById($id)
    {
        $this->db->select('*');
        $this->db->from('customers');
        $this->db->where('id', $id);
        $query = $this->db->get();

        return $query->row(); // Mengembalikan satu baris hasil sebagai objek
    }
    // public function reedem_voucher()
    // {
    //     $id_user = $this->session->userdata('id_user');
    //     // Menggunakan data dari input dan id_user untuk melakukan pembaruan
    //     $otp = $this->generate_otp($this->input->post('id'));
    //     $data = array(
    //         'awbno_claim' => $this->input->post('resi'),
    //         'id_user' => $id_user,
    //     );

    //     $this->db->where('id', $this->input->post('id'));
    //     $this->db->update('customers', $data);

    //     // Periksa apakah pembaruan berhasil
    //     return $this->db->affected_rows() > 0;
    //     // return true;
    // }

    public function redeemVoucher($customerId)
    {
        // Your logic to redeem the voucher and update the status to 'Y'
        // You may need to adjust this based on your database structure and requirements

        $data = array(
            'status' => 'Y',  // Update the status to 'Y'
            // Add other fields if needed
        );

        $this->db->where('id', $customerId);
        $this->db->update('customers', $data);

        // Check if the update was successful
        return $this->db->affected_rows() > 0;
    }

    public function generate_otp($id)
    {
        $otp_length = 6;
        $otp = "";

        for ($i = 0; $i < $otp_length; $i++) {
            $otp .= rand(0, 9);
        }

        $data = array('otp' => $otp);
        $this->db->where('id', $id);
        $this->db->update('customers', $data);

        return $otp;
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