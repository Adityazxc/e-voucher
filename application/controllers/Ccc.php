<?php

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Ccc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->session->set_userdata('pages', 'ccc_role');
    }

    public function index()
    {
        
        $data['title']          = 'Voucher Data';
        $data['page_name']      = 'voucher';
        $data['voucher_data']   = $this->Customer_model->getVoucherData();
        $this->load->view('index', $data);
    }

    public function dashboard()
    {
        $data['title']          = 'Dashboar';
        $data['page_name']      = 'dashboard_ccc';
        $data['voucher_data']   = $this->Customer_model->getVoucherData();
        $this->load->view('index', $data);
    }

    public function add_data()
    {
        $data['title']          = 'Dashboar';
        $data['page_name']      = 'voucher_test';
        $data['voucher_data']   = $this->Customer_model->getVoucherData();
        $this->load->view('index', $data);
    }

    // public function aaaa()
    // {
    //     $customer = $this->db->get('customers');

    //     foreach($customer->result() as $row){
    //         // $data[id]   =    $row->id;
    //         $data['date']   =    $row->date;
    //         $data['awb_no']   =    $row->awb_no;
    //         $data['id_customer']   =    $row->id_customer;
    //         $data['customer_name']   =    $row->customer_name;
    //         $data['qty']   =    $row->qty;
    //         $data['weight']   =    $row->weight;
    //         $data['harga']   =    $row->harga;
    //         $data['email']   =    $row->email;
    //         $data['no_hp']   =    $row->no_hp;
    //         $data['service']   =    $row->service;

    //         echo "<pre>";
    //         echo print_r($data);
    //         echo "</pre>";

    //         $this->db->insert('customers', $data);
    //     }
    // }

    public function add() {
     
        // Memvalidasi formulir
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('age', 'Usia', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            // Jika validasi gagal, tampilkan formulir lagi dengan pesan error
            $this->load->view('ccc_role/add_customer');
        } else {
            // Jika validasi berhasil, tambahkan data ke database
            $data = array(
                'nama' => $this->input->post('nama'),
                'age'  => $this->input->post('age')
            );

            $this->db->insert('testing', $data); // Ganti 'nama_tabel' dengan nama tabel Anda

            // Redirect atau tampilkan pesan sukses, sesuai kebutuhan
            redirect('customer/list'); // Ganti 'customer/list' dengan URL yang sesuai
        }
    }

    public function add_customer_modal() {
        // Load the add_customer_modal view
        $this->load->view('add_customer_modal');
    }
    

    // Validasi form
  
    // $customer_data = array(
    //     'customerName' => $this->input->post('customerName'),
    //     'id_customer' => $this->input->post('id_customer'),
    //     'awb_no' => $this->input->post('awb_no'),
    //     'email' => $this->input->post('email'),
    //     'no_tlp' => $this->input->post('no_tlp'),
    //     'ongkir' => $this->input->post('ongkir'),
    //     'qty' => $this->input->post('qty'),
    //     'weight' => $this->input->post('weight'),
    //     'service' => $this->input->post('service'),
    // );
    public function add_data_customers(){
        $customer_data = array(
            'customerName' => 'Nama Pelanggan',
            'id_customer' => 'ID Customer',
            'awb_no' => '123456789',
            'email' => 'example@email.com',
            'no_tlp' => '1234567890',
            'ongkir' => '10000',
            'qty' => '2',
            'weight' => '5',
            'service' => 'CTC',
            'date' => date('Y-m-d H:i:s')
        );

        $this->Customer_model->insert_customer($customer_data);
        $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert"> Data Berhasil ditambahkan <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        redirect(base_url('ccc_role/add_data'));

    }

    public function add_customer_ajax(){
    // Validasi form
        $this->form_validation->set_rules('customerName', 'Name Pengirim', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        // ... (tambahkan validasi sesuai kebutuhan)

        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, kirim respons error
            $response = array('status' => 'error', 'message' => validation_errors());
            echo json_encode($response);
        } else {
            // Jika validasi sukses, ambil data dari form
            $data = array(
                'customerName' => $this->input->post('customerName'),
                'email' => $this->input->post('email'),
                // ... (tambahkan field lain sesuai kebutuhan)
                'created_at' => date('Y-m-d H:i:s'), // Tambahkan timestamp
            );

            // Panggil model untuk menyimpan data ke dalam database
            $this->Customer_model->add_customer($data);

            // Kirim respons sukses
            $response = array('status' => 'success', 'message' => 'Customer added successfully.');
            echo json_encode($response);
        }
    }

    public function getdatatables_customer(){
        $list = $this->ccc_model->getdatatables_customer();
        $data = array();
        $no   = '0';
        foreach ($list as $item) {
            $no++;
            $detail = '';
            $row = array();
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->date . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->date . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->date . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->date . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->date . '</small>';
            $data[] = $row;
        }
        $output = array(
            "data"            => $data,
        );
        echo json_encode($output);
    }

}