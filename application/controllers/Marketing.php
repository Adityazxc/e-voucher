<?php
use PHPStan\PhpDocParser\Ast\PhpDoc\TypeAliasImportTagValueNode;

defined('BASEPATH') or exit('No direct script access allowed');
// require APPPATH . 'third_party/PHPExcel/PHPExcel.php';

class Marketing extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
        $this->load->model('Marketing_model');
        $this->session->set_userdata('pages', 'marketing_role');
        $this->load->library('session');
        $this->load->helper('url');
        // $this->load->library('email');
        $this->load->library('encryption');

    }

    public function index()
    {
        if ($this->session->userdata('logged_in') && $this->session->userdata('role') == 'Marketing') {
            $data['title'] = 'Dashboard Marketing';
            $data['page_name'] = 'dashboard_marketing';
            $data['role'] = 'Marketing';
            $data['voucher_data'] = $this->Customer_model->getVoucherData();
            $this->load->view('dashboard', $data);
        } else {
            redirect('auth');
        }
    }
    public function send_email()
    {
        if ($this->session->userdata('role') == "Marketing") {
            $data['title'] = 'Dashboard Marketing';
            $data['page_name'] = 'send_email';
            $data['role'] = 'Marketing';
            $data['voucher_data'] = $this->Customer_model->getVoucherData();
            $this->load->view('dashboard', $data);
        } else {
            echo "404";
        }
    }
    public function edit_send_email()
    {
        $customerId = $this->input->get('customerId');
        $data['title'] = 'Dashboard Marketing';
        $data['page_name'] = 'edit_email';
        $data['role'] = 'Marketing';
        $data['customerId'] = $customerId;
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




    public function getdatatables_customer()
    {
        // echo $this->input->post('dateFrom');
        $list = $this->Marketing_model->getdatatables_marketing();

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            if ($item->status == 'N') {
                $status = 'Belum Dipakai';
            } else {
                $status = 'Telah dipakai';
            }
            if ($item->status_email == 'Y') {
                $status_email = 'Sudah terkirim';
            } elseif ($item->status_email == 'N') {
                $status_email = 'Belum terkirim';
            }
            $no++;
            $row = array();

            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            // $row[] = '<small style="font-size:12px">' . $no . '</small>';
            // $row[] = '<input type="hidden" name="id[]" value="' . $no . '"><input type="checkbox" name="id_customer[]" value="' . @$item->id . '" class="form-check-input ml-2 data-check" id="id_customer">';
            $row[] = '<small style="font-size:12px">' . $item->customer_name . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->email . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->no_hp . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->harga . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->awb_no . '</small>';
            $row[] = '<small style="font-size:12px">' . $status . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->service . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->voucher . '</small>';
            $row[] = '<small style="font-size:12px">' . $status_email . '</small>';
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

        $this->db->where('status_email', 'Y');
        $this->db->where('type', 'customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $total_email_dikirim = $this->db->get('customers')->num_rows();

        $this->db->where('status_email', 'N');
        $this->db->where('type', 'customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $total_belum_dikirim = $this->db->get('customers')->num_rows();

        $this->db->where('status', 'N');
        $this->db->where('type', 'customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $customers_status3 = $this->db->get('customers')->num_rows();

        $this->db->where('expired_date <', date('Y-m-d'));
        $this->db->where('type', 'customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $total_hangus = $this->db->get('customers')->num_rows();

        $this->db->where('status', 'N');
        $this->db->where('type', 'customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('expired_date <=', $this->input->post('dateThru'));
        $customers_status4 = $this->db->get('customers')->num_rows();
        // echo print_r($this->db->last_query());


        $this->db->select('SUM(harga) as totalharga');
        $this->db->where('status', 'Y');
        $this->db->where('type', 'customer');
        $this->db->where('DATE(date) >=', $this->input->post('dateFrom'));
        $this->db->where('DATE(date) <=', $this->input->post('dateThru'));
        $customers_status5 = $this->db->get('customers')->row();

        echo json_encode([
            'sum_email_dikirim' => $total_email_dikirim,
            'sum_belum_dikirim' => $total_belum_dikirim,
            'sum_hangus' => $total_hangus,
            // 'sum_status1' => $customers_status1,
            // 'sum_status2' => $customers_status2,
            'sum_status3' => $customers_status3,
            'sum_status4' => $customers_status4,
            'sum_status5' => $customers_status5->totalharga,
        ]);
    }

    public function getdatatables_send_email()
    {
        $list = $this->ccc_model->getdatatables_marketing();

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {
            if ($item->status == 'N') {
                $status = 'Belum Dipakai';
            } else {
                $status = 'Telah dipakai';
            }
            if ($item->status_email == 'N') {
                $status_email = 'Belum dikirim';
            } elseif ($item->status_email == 'Y') {
                $status_email = 'Sudah terkirim';
            }
            $no++;
            $row = array();
            if ($item->email !== null) {
                $row[] = '<input type="hidden" name="id[]" value="' . $no . '"><input type="checkbox" name="id_customer[]" value="' . @$item->id . '" class="form-check-input ml-2 data-check" id="id_customer">';
            } else {
                $row[] = '<small style="font-size:12px"></small>';
            }
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->customer_name . '</small>';
            if ($item->email == null) {
                $row[] = '<button type="button" class="btn btn-sm btn-info" onclick="editEmail(' .$item->id  . ', \'' . $item->email . '\')">Edit</button>';
                
                // $row[] = '<a href="#ModalEditEmail" class="btn btn-sm btn-info" data-toggle="modal" data-id="' . $item->id . '" data-placement="top" data-toggle="tooltip" data-placement="top" title="Edit">Edit</a>';
            } else {
                $row[] = '<small style="font-size:12px">' . $item->email . '</small>';
            }
            $row[] = '<small style="font-size:12px">' . $item->no_hp . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->harga . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->awb_no . '</small>';
            $row[] = '<small style="font-size:12px">' . $status . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->service . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->voucher . '</small>';
            $row[] = '<small style="font-size:12px">' . $status_email . '</small>';
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->ccc_model->count_all_customer(),
            "recordsFiltered" => $this->ccc_model->count_filtered_customer(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function send_emails()
    {
        $selectedEmails = $this->input->post('selectedEmails');
        $customerName = $this->input->post('customerName'); // Get the customer's name
        $voucherInfo = $this->input->post('voucherInfo');

        if (!empty($selectedEmails)) {
            foreach ($selectedEmails as $email) {
                if (!empty($email)) {
                    $this->kirim_email($email, $customerName, $voucherInfo);
                    $this->db->where('email', $email);
                    $this->db->update('customers', array('status_email' => 'Y'));
                }
            }
            echo 'Email berhasil dikirim';
        } else {
            echo 'Tidak ada email yang dipilih atau email null.';
        }
    }
    public function update_email()
    {
        // $this->load->Ccc_model('update_email_model');
        $customerId = $this->input->post('customerId');
        $newEmail = $this->input->post('newEmail');

        // var_dump($customerId);
        // var_dump($newEmail);
        if ($this->Marketing_model->update_email_model($customerId, $newEmail)) {
            echo "Email berhasil diperbarui!";
        } else {
            echo "Gagal memperbarui email.";
        }

        redirect("marketing/send_email");
        
    }





    public function getdatatables_email_null()
    {
        $list = $this->ccc_model->getdatatables_email_null();
        $data = array();
        $no = @$_POST['start'];

        foreach ($list as $item) {
            // Add your logic for each row if needed
            $no++;
            $row = array();
            $row[] = '<input type="checkbox" name="id_customer[]" value="' . @$item->id . '" class="form-check-input ml-2 data-check" id="id_customer">';
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            // Add other columns based on your table structure
            $data[] = $row;
        }

        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->ccc_model->getdatatables_email_null_count(),
            "recordsFiltered" => $this->ccc_model->getdatatables_email_null_count(),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function kirim_email($recipientEmail, $nama, $voucherCode,$harga)
    {
        $output = '<!DOCTYPE html>
        <html lang="id">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Promosi Voucher</title>
        
        <body>
            <div class="container">
                <style>
                    .content,            
                    .footer {                        
                        margin: 0;
                        padding: 0;
                        text-align: center;
                    }
                    .ketentuan,.header {                
                        margin: 0;
                        padding: 0;
                        
                    }
        
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                        background-color: #ffffff;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
        
                    .header img {
                        width: 100%;
                        max-width: 300px;
                        height: auto;
                        margin-bottom: 20px;
                    }
        
                    .promo-text {
                        color: #333;
                        font-size: 18px;
                        line-height: 1.6;
                        margin-bottom: 20px;
                    }
        
                    .cta-button {
                        display: inline-block;
                        background-color: #3498db;
                        color: #fff;
                        text-decoration: none;
                        padding: 10px 20px;
                        font-size: 16px;
                        border-radius: 5px;
                    }
                </style>
        
                <div class="content">
                <h2>Halo ' . htmlspecialchars($nama) . '</h2>
                    <p class="promo-text">Selamat Anda mendapatkan E-Voucher Ongkir sebesar '. htmlspecialchars($harga) .' dari Program "GARANSI
                        ONGKIR KEMBALI" JNE Cabang Utama Bandung. </p>
                </div>
                <div class="ketentuan">
                    <ol>
                        <li>E-Voucher Ongkir berlaku hingga 5 Maret 2024</li>                        
                        <li>E-Voucher Ongkir hanya bisa digunakan untuk 1 (satu) kali transaksi</li>
                        <li>Tidak ada Pengembalian Uang jika E-Voucher melebihi Harga Ongkos Kirim</li>
                        <li>Jika pada saat melakukan Transaksi Pengiriman Total Ongkos Kirim melebihi dari nilai E-Voucher maka
                            customer Wajib menambah Ongkos Kirim sesuai dengan kekurangannya.</li>
                        <li>Penggunaan E-Voucher Ongkir tidak dapat digabung dengan program/promo lainnya.</li>
                    </ol>
                </div>
        
                <div class="footer">
                    <p>
                    an kode <b style="font-size: larger;background-color: yellow;">' . htmlspecialchars($voucherCode) . '</b> di seluruh Sales Counter JNE Kantor Cabang Utama Bandung.</p>
        
                    Tim Promotion E-Voucher JNE Bandung
                </div>
            </div>
        </body>
        
        </html>
        ';
        // $output = '

        // ';
        // $output .= 'Testing Email';

        $conn = [
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.office365.com',
            'smtp_user' => 'bdo.itproject@jne.co.id',
            'smtp_pass' => 'D3stroy3r',
            'smtp_port' => '587',
            'smtp_crypto' => 'tls',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n",
            'crlf' => "\r\n"
        ];

        $this->load->library('email', $conn);

        // $this->email->to('lukman.nugraha@jne.co.id');
        // $this->email->to('vidyana.rosalina@jne.co.id');
        // $this->email->to('enzo.edogawa15@gmail.com');
        // $this->email->to('iqipulla123@gmail.com');
        $this->email->from('bdo.itproject@jne.co.id', 'JNE BANDUNG');
        $this->email->to($recipientEmail);
        $this->email->subject('Selamat Anda mendapatkan E-Voucher Ongkir dari JNE Bandung');
        $this->email->message($output);
        if ($this->email->send()) {
            echo 'Email berhasil dikirim';
        } else {
            echo 'Email gagal dikirim';
            echo $this->email->print_debugger(); // Jika terjadi kesalahan, tampilkan pesan debug
        }

    }

   

    public function test_checkbox()
    {
        for ($i = 0; $i < count($this->input->post('id_customer')); $i++) {
            $customer_id = $this->input->post('id_customer')[$i];

            $customers = $this->db->get_where('customers', ['id' => $this->input->post('id_customer')[$i]]);

            $data['email'] = $customers->row()->email;
            //manggil yg function email
            $this->db->where('id', $this->input->post('id_customer')[$i]);
            $this->db->update('customers', ['status_email' => 'Y']);
            $harga=$customers->row()->harga;
            $harga_voucher=$this->format_rupiah($harga);
            $this->kirim_email($customers->row()->email, $customers->row()->customer_name, $customers->row()->voucher, $harga_voucher);
            // $this->kirim_email($customers->row()->email, $customers->row()->customer_name, $customers->row()->voucher);

        }
        redirect('marketing/send_email');
    }
 
    function format_rupiah($harga) {
        return 'Rp ' . number_format($harga, 0, ',', '.');
    }
    
   
    
}

