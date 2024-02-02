<?php

defined('BASEPATH') or exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\IOFactory;

class Ccc extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->library('session');
        $this->session->set_userdata('pages', 'ccc_role');
        $this->load->helper('url');
    }


    public function index()
    {
        $data['title'] = 'Voucher Data';
        $data['page_name'] = 'dashboard_ccc';
        $data['role'] = 'CCC';
        $data['voucher_data'] = $this->Customer_model->getVoucherData();
        $this->load->view('dashboard', $data);
    }



    public function importData()
    {
        $this->load->library('upload');
        $this->upload->initialize(
            array(
                'upload_path' => './uploads/', // Sesuaikan dengan path yang sesuai
                'allowed_types' => 'xlsx|xls|csv', // Sesuaikan dengan jenis file yang diizinkan
            )
        );

        if ($this->upload->do_upload('excel_file')) {
            $data = $this->upload->data();
            $file_path = $data['full_path'];

            // Menggunakan library PhpSpreadsheet
            $spreadsheet = IOFactory::load($file_path);
            // null vallue, calculateformulas, format data, returCellRef
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

            // Membuang baris pertama (header)
            unset($sheetData[1]);

            // Proses data dari $sheetData sesuai kebutuhan
            foreach ($sheetData as $row) {

                $data = array(
                    'awb_no' => $row['C'],
                    'id_customer' => $row['D'],
                    'customer_name' => $row['E'],
                    'qty' => $row['F'],
                    'weight' => $row['G'],
                    'harga' => $row['H'],
                    'email' => $row['I'],
                    'no_hp' => $row['J'],
                    'service' => $row['K']
                );


                $voucher_code = $this->generateVoucherCode();
                $data['voucher'] = $voucher_code;
                $data['date'] = date('Y-m-d H:i:s');
                $data['expired_date'] = date('Y-m-d', strtotime('+30 days'));
                $voucher_value = $row['H'];
                $data['value_voucher'] = $voucher_value;
                $data['status'] = 'N'; // Default status
                // Simpan data ke database atau lakukan proses lain sesuai kebutuhan
                $this->Customer_model->tambah($data);

                // echo "<pre>";
                // echo print_r($data);
                // echo "</pre>";
            }

            $this->session->set_flashdata('success_message', 'File berhasil diunggah dan data berhasil ditambahkan.');
            // Tampilkan pesan sukses atau redirect ke halaman lain
            redirect('ccc/view_add_data');
        } else {
            // Tangani kesalahan upload file
            $error = $this->upload->display_errors();
            echo $error;
        }
    }



    private function generateVoucherCode()
    {
        $length = 16;
        $characters = '23456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz';
        $voucher_code = '';

        // loop untuk menghasilkan 16 karakter uniq
        for ($i = 0; $i < $length; $i++) {

            // pilih karakter acak
            $voucher_code .= $characters[rand(0, strlen($characters) - 1)];
        }

        // validasi agar tidak ada karakter mirip
        while ($this->hasSimilarCharacters($voucher_code)) {
            $voucher_code = $this->generateVoucherCode();
        }
        ;

        return $voucher_code;
    }

    // Fungsi untuk validasi karakter agar tidak ada karakter yang mirip
    private function hasSimilarCharacters($voucher_code)
    {
        // Tambahkan logika validasi karakter yang mirip sesuai kebutuhan
        // Contoh: Jika tidak boleh ada karakter yang mirip, tambahkan validasi di sini

        return false; // Ganti dengan logika validasi sesuai kebutuhan
    }


    public function view_add_data()
    {
        $dateFrom = $this->input->get('dateFrom');
        $dateThru = $this->input->get('dateThru');

        // Pass the dateFrom and dateThru to the model to fetch filtered data
        
        $data['title'] = 'Add Data';
        $data['page_name'] = 'add_data';
        $data['role'] = 'CCC';        
        $data['voucher_data']= $this->Customer_model->getVoucherData($dateFrom, $dateThru);
        $this->load->view('dashboard', $data);

    }

    public function add_data()
    {
        // Jika data berhasil ditambahkan, set pesan sukses ke dalam flashdata
        $this->session->set_flashdata('success_message', 'Data berhasil ditambahkan.');

        $customer_data = array(
            'customer_name' => $this->input->post('customerName'),
            'awb_no' => $this->input->post('awb_no'),
            'email' => $this->input->post('email'),
            'no_hp' => $this->input->post('no_tlp'),
            'harga' => $this->input->post('ongkir'),
            'service' => $this->input->post('service'),
        );
        // Tambahkan tanggal ke dalam array
        $customer_data['date'] = date('Y-m-d H:i:s');
        $this->Customer_model->tambah($customer_data);
        $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert">Data Berhasil ditambahkan <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span><button><div> ');
        redirect(site_url('ccc/view_add_data'), 'refresh');
    }

    public function add_customer_modal()
    {
        // Load the add_customer_modal view
        $this->load->view('add_customer_modal');
    }



    public function getdatatables_customer()
    {
        $list = $this->ccc_model->getdatatables_customer();

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
            $row[] = '<small style="font-size:12px">' . $item->customer_name . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->email . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->no_hp . '</small>';
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

        $customers_status1 = $this->db->get('customers')->num_rows();

        $this->db->where('status', 'Y');
        $customers_status2 = $this->db->get('customers')->num_rows();

        $this->db->where('status', 'N');
        $customers_status3 = $this->db->get('customers')->num_rows();

        $customers_status4 = $this->db->get('customers')->num_rows();


        echo json_encode([
            'sum_status1' => $customers_status1,
            'sum_status2' => $customers_status2,
            'sum_status3' => $customers_status3,
            'sum_status4' => $customers_status4,
        ]);
    }


}