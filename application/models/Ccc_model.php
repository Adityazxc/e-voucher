<?php

class Ccc_model extends CI_Model
{

    // PCRF REGISTRATION
    var $customer_column_order = array(null, 'id', 'date', 'awb_no', 'customer_name', 'harga', 'email', 'no_hp', 'service', null); //set column field database for datatable orderable
    var $customer_column_search = array('id', 'date', 'awb_no', 'customer_name', 'harga', 'email', 'no_hp', 'service'); //set column field database for datatable searchable
    var $customer_order = array('id' => 'DESC'); // default order



    private function _getdatatables_customer()
{
    $this->db->select('*');
    
    $status = $this->input->post('status');
    $dateFrom = $this->input->post('dateFrom');
    $dateThru = $this->input->post('dateThru');
    
    switch ($status) {
        case 'status2':
            $this->db->where('status', 'Y');
            break;
        case 'status3':
            $this->db->where('status', 'N');
            break;
        case 'emailDikirim':
            $this->db->where('status_email', 'Y');
            break;
        case 'belumDikirim':
            $this->db->where('status_email !=', 'Y');
            break;
        case 'hangus':
            $this->db->where('expired_date <', date('Y-m-d'))
                     ->where('DATE(date) >=', $dateFrom)
                     ->where('DATE(date) <=', $dateThru);
            break;
        case 'status4':
            // Handle status4 case if needed
            break;
    }
    
    $this->db->where('DATE(date) >=', $dateFrom)
             ->where('DATE(date) <=', $dateThru);
    
    $this->db->from('customers');
    
    $i = 0;
    
    if (@$_POST['search']['value']) {
        foreach ($this->customer_column_search as $item) {
            if ($i === 0) {
                $this->db->group_start()
                         ->like($item, $_POST['search']['value']);
            } else {
                $this->db->or_like($item, $_POST['search']['value']);
            }
            if (count($this->customer_column_search) - 1 == $i) {
                $this->db->group_end();
            }
            $i++;
        }
    }

    if (isset($_POST['order'])) {
        $this->db->order_by($this->customer_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
    } elseif (isset($this->order)) {
        $customer_order = $this->order;
        $this->db->order_by(key($customer_order), $customer_order[key($customer_order)]);
    }
}

    function getdatatables_customer()
    {
        $this->_getdatatables_customer();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_customer()
    {
        $this->_getdatatables_customer();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_customer()
    {
        $this->db->select('*');
        if ($this->input->post('status') == 'status2') {
            $this->db->where('status', 'Y');
        } else if ($this->input->post('status') == 'status3') {
            $this->db->where('status', 'N');
        } else if ($this->input->post('status') == 'status4') {
        }
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $this->db->from('customers');
        return $this->db->count_all_results();
    }
    

    function tambah($data)
    {
        $this->db->insert('customers', $data);
        return TRUE;
    }

    function summary_customer()
    {
        $this->db->select('SUM(CASE WHEN status = "status1" THEN harga ELSE 0 END) as sum_status1');
        $query = $this->db->get('customers');
        return $query->row();
    }


    private function _getdatatables_agen()
    {
        $id_user = $this->session->userdata('id_user');
        $this->db->select('*');
        if ($this->input->post('status') == 'status2') {
            $this->db->where('status', 'Y');
        } else if ($this->input->post('status') == 'status3') {
            $this->db->where('status', 'N');
        } else if ($this->input->post('status') == 'status4') {
        }
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $this->db->where('id_user', $id_user);



        $this->db->from('customers');
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

    function getdatatables_agen()
    {
        $this->_getdatatables_agen();
        if (@$_POST['length'] != -1)
            $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    private function _getdatatables_finance()
    {
        $this->db->select('customers.id,customers.date,customers.awbno_claim,customers.customer_name,customers.harga,customers.email,customers.no_hp,customers.service,customers.voucher,
        customers.value_voucher,customers.expired_date,customers.status,customers.status_email,customers.otp,users.id_user,users.account_name');
        $this->db->from('customers');
        $this->db->join('users', 'customers.id_user = users.id_user', 'left'); // Melakukan join dengan tabel users
        $dateFrom = $this->input->post('dateFrom');
        $dateThru = $this->input->post('dateThru');
        if ($this->input->post('status') == 'status2') {
            $this->db->where('customers.status', 'Y');
        } else if ($this->input->post('status') == 'status3') {
            $this->db->where('customers.status', 'N');
        } else if ($this->input->post('status') == 'hangus') {
            $this->db->where('expired_date <', date('Y-m-d'))
            ->where('DATE(customers.date) >=',$dateFrom)
            ->where('DATE(customers.date) <=',$dateThru);
        }else if ($this->input->post('status') == 'status4') {
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
    private function _getdatatables_marketing()
    {
        $this->db->select('*');
        $this->db->where('status_email','N');
        
        $status = $this->input->post('status');
        $dateFrom = $this->input->post('dateFrom');
        $dateThru = $this->input->post('dateThru');
        
        switch ($status) {
            case 'status2':
                $this->db->where('status', 'Y');
                break;
            case 'status3':
                $this->db->where('status', 'N');
                break;
            case 'emailDikirim':
                $this->db->where('status_email', 'Y');
                break;
            case 'belumDikirim':
                $this->db->where('status_email', null);
                break;
            case 'hangus':
                $this->db->where('expired_date <', date('Y-m-d'))
                         ->where('DATE(date) >=', $dateFrom)
                         ->where('DATE(date) <=', $dateThru);
                break;
            case 'status4':
                // Handle status4 case if needed
                break;
        }
        
        $this->db->where('DATE(date) >=', $dateFrom)
                 ->where('DATE(date) <=', $dateThru);
        
        $this->db->from('customers');
        
        $i = 0;
        
        if (@$_POST['search']['value']) {
            foreach ($this->customer_column_search as $item) {
                if ($i === 0) {
                    $this->db->group_start()
                             ->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->customer_column_search) - 1 == $i) {
                    $this->db->group_end();
                }
                $i++;
            }
        }
    
        if (isset($_POST['order'])) {
            $this->db->order_by($this->customer_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $customer_order = $this->order;
            $this->db->order_by(key($customer_order), $customer_order[key($customer_order)]);
        }
    }
    
        function getdatatables_marketing()
        {
            $this->_getdatatables_marketing();
            if (@$_POST['length'] != -1)
                $this->db->limit(@$_POST['length'], @$_POST['start']);
            $query = $this->db->get();
            return $query->result();
        }
    

       function updateEmail($customerId, $newEmail){
        $data=array(
            'email'=>$newEmail,
        );
        $this->db->where('id', $customerId);
        $this->db->update('customers', $data);

        return $this->db->affected_rows();
    }

   
}

?>