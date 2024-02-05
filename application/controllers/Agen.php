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
    }

    public function index()
    {
        if($this->session->userdata('logged_in')&&$this->session->userdata('role')=='Agen'){
        $data['title'] = 'Voucher Data';
        $data['page_name'] = 'dashboard_agen';
        $data['role']      = 'Agen';
        $data['voucher_data'] = $this->Customer_model->getVoucherData();
        $this->load->view('dashboard', $data);
        }else{
            redirect('auth');
        }
    }
    public function redeem($data = array())
    {
        $data['title'] = 'Redeem Voucher';
        $data['page_name'] = 'redeem_voucher';
        $data['role'] = 'Agen';
        $data['voucher_data'] = $this->Customer_model->getVoucherData();
    
        // Memanggil view dan menyertakan data hasil pencarian
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
    
    public function reedem_voucher()
    {
        $reedem_voucher = $this->customer_model->reedem_voucher();
        if($reedem_voucher == true){
            
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
            redirect(base_url('agen/search_customer'));
        }
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