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
        if ($this->session->userdata('logged_in') && $this->session->userdata('role') == 'Agen') {
            $data['title'] = 'Voucher Data';
            $data['page_name'] = 'dashboard_agen';
            $data['role'] = 'Agen';
            $data['voucher_data'] = $this->Customer_model->getVoucherData();
            $this->load->view('dashboard', $data);
            $id_user = $this->session->userdata('id_user');
            // echo "ID User: " . $id_user;
        } else {
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

    // Agen.php (controller)
    public function reedem_voucher()
    {
        $otp = '';
        $reedem_voucher = $this->customer_model->reedem_voucher();

        if ($this->input->post('gunakan_btn')) {
            $otp = $this->customer_model->generate_otp($this->input->post('id'));
        }

        if ($reedem_voucher == true) {
            // Proses selanjutnya setelah voucher berhasil diredeem
            $this->session->set_flashdata('success', 'Voucher berhasil diredeem');
            redirect(base_url('agen/search_customer'));
        } else {
            // Proses selanjutnya jika voucher tidak berhasil diredeem
            $this->session->set_flashdata('error', 'Gagal redeem voucher');
            redirect(base_url('agen/search_customer'));
        }
    }

    // Customer_model.php
    public function validate_otp($id, $otp_input)
    {
        // Ambil OTP dari database
        $this->db->select('otp');
        $this->db->where('id', $id);
        $query = $this->db->get('customers');
        $result = $query->row();

        // Validasi OTP
        return ($result && $result->otp == $otp_input);
    }

    // public function reedem_voucher()
    // {                     
    //     $reedem_voucher = $this->customer_model->reedem_voucher();
    //     if($reedem_voucher == true){            
    //         $this->session->set_flashdata('success', 'Data berhasil disimpan');    
    //         redirect(base_url('agen/search_customer'));
    //     }else {
    //         $this->session->set_flashdata('error', 'Gagal redeem voucher');
    //         redirect(base_url('agen/search_customer'));
    //     }
    // }


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
    public function getdatatables_customer()
    {
        // echo $this->input->post('dateFrom');
        $list = $this->ccc_model->getdatatables_agen();

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            if ($item->status == 'N') {
                $status = 'Belum Dipakai';
            } else {
                $status = 'Telah dipakai';
            }
            $no++;
            $row = array();
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            // $row[] = '<input type="hidden" name="id[]" value="' . $no . '"><input type="checkbox" name="id_customer[]" value="' . @$item->id . '" class="form-check-input ml-2 data-check" id="id_customer">';
            $row[] = '<small style="font-size:12px">' . $item->customer_name . '</small>';        
            $row[] = '<small style="font-size:12px">' . $item->harga . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->awb_no . '</small>';
            $row[] = '<small style="font-size:12px">' . $status . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->service . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->voucher . '</small>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->ccc_model->count_all_customer(),
            "recordsFiltered" => $this->ccc_model->count_filtered_customer(),
            "data" => $data,
        );
        // output to json format
        echo json_encode($output);
    }

    public function summary_customer()
    {
        $id_user = $this->session->userdata('id_user');

        $this->db->select('COUNT(id) as sum_status2, SUM(harga) as sum_status5');
        $this->db->where('id_user', $id_user);
        $this->db->where('status', 'Y');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $this->db->group_by('id_user');
        $customers_data = $this->db->get('customers')->row();

        echo json_encode([
            'sum_status2' => $customers_data->sum_status2,
            'sum_status5' => $customers_data->sum_status5,
        ]);
    }


}