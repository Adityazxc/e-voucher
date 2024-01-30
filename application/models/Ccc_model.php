<?php

class Ccc_model extends CI_Model {

    // PCRF REGISTRATION
    var $customer_column_order = array(null, 'id', 'date', 'awb_no', 'id_customer', 'customer_name', 'qty', 'weight', 'harga', 'email', 'no_hp', 'service', null); //set column field database for datatable orderable
    var $customer_column_search = array('id', 'date', 'awb_no', 'id_customer', 'customer_name', 'qty', 'weight', 'harga', 'email', 'no_hp', 'service'); //set column field database for datatable searchable
    var $customer_order = array('id' => 'DESC'); // default order

    private function _getdatatables_customer()
    {
        $this->db->select('*');
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
        $this->db->from('customers');
        return $this->db->count_all_results();
    }
}
?>