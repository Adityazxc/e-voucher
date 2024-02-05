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

    // public function reedem_voucher()
    // {
    //     $id_user = $this->session->userdata('id_user');

    //     // Menggunakan data dari input dan id_user untuk melakukan pembaruan
    //     $data = array(
    //         'awbno_claim' => $this->input->post('resi'),
    //         'id_user' => $id_user            
    //     );

    //     $this->db->where('id', $this->input->post('id'));
    //     $this->db->update('customers', $data);
    //     return true;
    // }
    public function reedem_voucher()
    {
        $id_user = $this->session->userdata('id_user');

        // Menggunakan data dari input dan id_user untuk melakukan pembaruan
        // Memastikan bahwa id_user yang diambil dari sesi adalah nilai yang valid
        if ($id_user) {
            // Menggunakan data dari input dan id_user untuk melakukan pembaruan
            $data = array(
                'awbno_claim' => $this->input->post('resi'),
                'id_user' => $id_user
                //Tambahkan kolom lain yang perlu diperbarui jika ada
            );

            // Melakukan pembaruan pada tabel customers
            $this->db->where('id', $this->input->post('id'));
            $this->db->update('customers', $data);

            return true;
        } else {
            // Jika id_user tidak valid, mungkin perlu mengatasi atau memberikan pesan kesalahan
            return false;
        }
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