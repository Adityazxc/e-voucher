<?php
use PHPStan\PhpDocParser\Ast\PhpDoc\TypeAliasImportTagValueNode;

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Marketing_corp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model_corp');
        $this->load->model('Marketing_model_corp');
        $this->load->model('Ccc_model_corp');
        $this->session->set_userdata('pages', 'marketing_role_corp');
        $this->load->library('session');
        $this->load->helper('url');
        // $this->load->library('email');
    }

    public function index()
    {

        $user_role = $this->session->userdata('role');
        if ($this->session->userdata('logged_in') && ($user_role == 'Marketing' || $user_role == 'Admin')) {        
            $data['title'] = 'Dashboard Marketing';
            $data['page_name'] = 'dashboard_marketing';
            if ($user_role == 'Marketing') {
                $data['role'] = 'Marketing';
            } else {
                $data['role'] = 'Admin';
            } 
            $data['voucher_data'] = $this->Customer_model_corp->getVoucherData();
            $this->load->view('dashboard', $data);
        } else {
            redirect('auth');
        }
    }
        
}

