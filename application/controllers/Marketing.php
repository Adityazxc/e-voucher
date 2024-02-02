<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Marketing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->session->set_userdata('pages', 'marketing_role');        
    }

    public function index()
    {

        $data['title'] = 'Dashboard Marketing';
        $data['page_name'] = 'dashboard_marketing';
        $data['role']      = 'Marketing';
        $data['voucher_data'] = $this->Customer_model->getVoucherData();
        $this->load->view('dashboard', $data);
    }
    public function send_email()
    {

        $data['title'] = 'Dashboard Marketing';
        $data['page_name'] = 'send_email';
        $data['role']      = 'Marketing';
        $data['voucher_data'] = $this->Customer_model->getVoucherData();
        $this->load->view('dashboard', $data);
    }
    
    public function search_customer()
    {
        $this->load->model('Customer_model');
    
        // Mendapatkan kata kunci pencarian dari formulir atau input pengguna
        $keyword = $this->input->post('search_keyword');
    
        // Memanggil metode searchCustomer dari model
        $search_result = $this->Customer_model->searchCustomer($keyword);
    
        // Menyimpan hasil pencarian ke dalam data yang akan dikirim ke view
        $data['search_result'] = $search_result;
    
        // Menyimpan kata kunci pencarian untuk ditampilkan kembali di form
        $data['search_keyword'] = $keyword;
    
        // Memanggil fungsi redeem() dan menyertakan data hasil pencarian
        $this->redeem($data);
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