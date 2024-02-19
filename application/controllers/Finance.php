<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Finance extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Finance_model');
        $this->session->set_userdata('pages', 'finance_role');
    }

    public function index()
    {
        $user_role = $this->session->userdata('role');
        if ($this->session->userdata('logged_in') && ($user_role == 'Finance' || $user_role == 'Admin')) {                
            $data['title'] = 'Dashboard Finance';
            $data['page_name'] = 'dashboard_finance';
            if ($user_role == 'Finance') {
                $data['role'] = 'Finance';
            } else {
                $data['role'] = 'Admin';
            } 
            $data['voucher_data'] = $this->Customer_model->getVoucherData();
            $this->load->view('dashboard', $data);
        } else {
            redirect('auth');
        }
    }
    public function getdatatables_customer()
    {
        // echo $this->input->post('dateFrom');
        $list = $this->Finance_model->getdatatables_finance();

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            
            $no++;
            $row = array();
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->date . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->voucher . '</small>';            
            $row[] = '<small style="font-size:12px">' . $item->awbno_claim . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->harga . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->account_number . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->account_name . '</small>';            
            $row[] = '<small style="font-size:12px">' . $item->customer_name . '</small>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->Finance_model->count_all_customer(),
            "recordsFiltered" => $this->Finance_model->count_filtered_customer(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }
    public function summary_customer()
    {
        // Counting all records
        $this->db->where('type','customer');
        $this->db->where('DATE(customers.date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(customers.date) <=', $this->input->post('dateThru'));
        $customers_status1 = $this->db->count_all_results('customers');

        // Counting records with status 'Y'
        $this->db->where('status', 'Y');
        $this->db->where('type','customer');
        $this->db->where('DATE(customers.date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(customers.date) <=', $this->input->post('dateThru'));
        $customers_status2 = $this->db->count_all_results('customers');

        // Counting records with status 'N'
        $this->db->where('status', 'N');
        $this->db->where('type','customer');
        $this->db->where('DATE(customers.date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(customers.date) <=', $this->input->post('dateThru'));
        $customers_status3 = $this->db->count_all_results('customers');

        // Counting records with status 'N' and expired date <= dateThru
        $this->db->where('status', 'N');
        $this->db->where('type','customer');
        $this->db->where('DATE(customers.date) >=', $this->input->post('dateFrom'));
        $this->db->where('expired_date <=', $this->input->post('dateThru'));
        $customers_status4 = $this->db->count_all_results('customers');

        // Summing up the 'harga' for records with status 'Y'
        $this->db->select('SUM(harga) as totalharga');
        $this->db->where('status', 'Y');
        $this->db->where('type','customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $customers_status5 = $this->db->get('customers')->row();

        echo json_encode([
            'sum_status1' => $customers_status1,
            'sum_status2' => $customers_status2,
            'sum_status3' => $customers_status3,
            'sum_status4' => $customers_status4,
            'sum_status5' => $customers_status5->totalharga,
        ]);
    }



    public function session()
    {
        $session_data = $this->session->all_userdata();

        echo '<pre>';
        print_r($session_data);
    }

    public function test()
    {
        $data['email'] = $this->input->post('email');

        echo "<pre>";
        echo print_r($data);
        echo "</pre>";
    }




}