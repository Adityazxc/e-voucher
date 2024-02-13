<?php

class Finance_model extends CI_Model
{

    // PCRF REGISTRATION
    var $customer_column_order = array(null, 'id', 'date', 'awb_no', 'customer_name', 'harga', 'email', 'no_hp', 'service', null); //set column field database for datatable orderable
    var $customer_column_search = array('id', 'date', 'awb_no', 'customer_name', 'harga', 'email', 'no_hp', 'service'); //set column field database for datatable searchable
    var $customer_order = array('id' => 'DESC'); // default order

   
    private function _getdatatables_finance()
    {
        $this->db->select('customers.id,customers.date,customers.awbno_claim,customers.customer_name,customers.harga,customers.email,customers.no_hp,customers.service,customers.voucher,
        customers.value_voucher,customers.expired_date,customers.status,customers.status_email,customers.otp,users.id_user,users.account_name,users.account_number');
        $this->db->from('customers');
        $this->db->join('users', 'customers.id_user = users.id_user', 'left'); // Melakukan join dengan tabel users

        if ($this->input->post('status') == 'status2') {
            $this->db->where('customers.status', 'Y');
        } else if ($this->input->post('status') == 'status3') {
            $this->db->where('customers.status', 'N');
        } else if ($this->input->post('status') == 'status4') {
            // Tidak perlu menambahkan kondisi khusus jika status4, biarkan kosong
        }

        // Memeriksa apakah dateFrom dan dateThru tidak kosong sebelum menambahkan kondisi WHERE

        $this->db->where('DATE(customers.date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(customers.date) <=', $this->input->post('dateThru'));


        $i = 0;
        foreach ($this->customer_column_search as $item) { // loop column
            if (@$_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->customer_column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->customer_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $customer_order = $this->order;
            $this->db->order_by(key($customer_order), $customer_order[key($customer_order)]);
        }
    }


    function getdatatables_finance()
    {
        $this->_getdatatables_finance();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
}
?>