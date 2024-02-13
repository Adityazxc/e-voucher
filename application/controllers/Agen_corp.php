<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Agen_corp extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model_corp');
        $this->load->model('Ccc_model_corp');
        $this->session->set_userdata('pages', 'agen_role_corp');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('role') == 'Agen') {
            $data['title'] = 'Voucher Data';
            $data['page_name'] = 'dashboard_agen';
            $data['role'] = 'Agen';
            $data['voucher_data'] = $this->Customer_model_corp->getVoucherData();
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
        $data['voucher_data'] = $this->Customer_model_corp->getVoucherData();

        // Memanggil view dan menyertakan data hasil pencarian
        $this->load->view('dashboard', $data);
    }

    public function search_customer()
    {
        $this->load->model('Customer_model');
        $keyword = $this->input->post('search_keyword');
        $search_result = $this->Customer_model->searchCustomer($keyword);
        $data['search_result'] = $search_result;
        $data['search_keyword'] = $keyword;
        $this->redeem($data);
    }
    public function otp($idCustomer)
    {
        $data['title'] = 'Redeem Voucher';
        $data['page_name'] = 'otp';
        $data['role'] = 'Agen';
        $data['voucher_data'] = $this->Customer_model_corp->getVoucherData();
        $data['customer_id'] = $idCustomer;
        echo '<pre>';
        print_r($data['customer_id']);
        echo '</pre>';
        $this->load->view('dashboard', $data);
    }

    // Agen.php (controller)
    public function redeem_voucher()
    {
        $idCustomer = $this->input->post('id');

        // Assuming you have a method redeemVoucher in your Customer_model
        $redeem_voucher = $this->Customer_model_corp->redeemVoucher($idCustomer);

        if ($redeem_voucher) {
            // Proses selanjutnya setelah voucher berhasil diredeem
            $this->session->set_flashdata('success', 'Voucher berhasil diredeem');
            redirect(base_url('agen/search_customer'));
        } else {
            // Proses selanjutnya jika voucher tidak berhasil diredeem
            $this->session->set_flashdata('error', 'Gagal redeem voucher');
            redirect(base_url('agen/search_customer'));
        }

    }



   

    public function validate_otp($id, $otp_input)
    {
        // $id = $this->input->post('id');
        // $otp_input = $this->input->post('otp_input');

        // Ambil OTP dari database
        $this->db->select('otp');
        $this->db->where('id', $id);
        $query = $this->db->get('customers');
        $result = $query->row();

        // Validasi OTP
        if ($result && $result->otp == $otp_input) {
            echo 'true'; // atau berikan respons lain sesuai kebutuhan Anda
        } else {
            echo 'false'; // atau berikan respons lain sesuai kebutuhan Anda
        }
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
    public function getdatatables_customer()
    {
        // echo $this->input->post('dateFrom');
        $list = $this->Ccc_model_corp->getdatatables_agen();

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
            "recordsTotal" => $this->Ccc_model_corp->count_all_customer(),
            "recordsFiltered" => $this->Ccc_model_corp->count_filtered_customer(),
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
        $this->db->where('type', 'corporate');
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