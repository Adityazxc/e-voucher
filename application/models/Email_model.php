<?php

class Email_model extends CI_Model
{

    // PCRF REGISTRATION
    var $customer_column_order = array(null, 'id', 'date', 'awb_no', 'customer_name', 'harga', 'email', 'no_hp', 'service', null); //set column field database for datatable orderable
    var $customer_column_search = array('id', 'date', 'awb_no', 'customer_name', 'harga', 'email', 'no_hp', 'service'); //set column field database for datatable searchable
    var $customer_order = array('id' => 'DESC'); // default order

   
   
}
?>