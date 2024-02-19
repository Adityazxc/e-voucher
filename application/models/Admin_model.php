<?php

class Admin_model extends CI_Model
{
    var $customer_column_order = array(null, 'id_user', 'account_name', 'agent_area', 'role', 'account_number', 'status_account', null); //set column field database for datatable orderable
    var $customer_column_search = array('id_user', 'account_name', 'agent_area', 'role', 'account_number', 'status_account' ); //set column field database for datatable searchable
    var $customer_order = array('id' => 'DESC');

    private function _getdatatables_customer()
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('status_account', 'DESC');

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
            $column_order_index = $_POST['order']['0']['column'];
            if ($this->customer_column_order[$column_order_index] != null) {
                $this->db->order_by($this->customer_column_order[$column_order_index], $_POST['order']['0']['dir']);
            } else {
                $this->db->order_by('status_account', 'DESC');
            }
        } elseif (isset($this->order)) {
            $customer_order = $this->order;
            $this->db->order_by(key($customer_order), $customer_order[key($customer_order)]);
        } else {
            // Fallback order by status_account if no order is provided
            $this->db->order_by('status_account', 'DESC');
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

        $this->db->from('users');
        return $this->db->count_all_results();
    }




}

?>