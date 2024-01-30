<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Agen extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->session->set_userdata('pages', 'agen_role');
        $this->session->set_userdata('nama', 'DAYI');
    }

    public function index()
    {

        $data['title'] = 'Voucher Data';
        $data['page_name'] = 'dashboard_agen';
        $data['voucher_data'] = $this->Customer_model->getVoucherData();
        $this->load->view('index', $data);
    }

    public function session()
    {
        $session_data = $this->session->all_userdata();

        echo '<pre>';
        print_r($session_data);
    }

    public function test(){
        $data['email'] = $this->input->post('email');

        echo "<pre>";
        echo print_r($data);
        echo "</pre>";
    }


    

}