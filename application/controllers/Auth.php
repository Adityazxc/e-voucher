<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

    }

    public function index()
    {

        $this->load->view('index');
    }

    public function a()
    {

        echo '<pre>';
        var_dump($_SESSION);
        echo '</pre>';
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $this->db->where('account_number', $username);
        $this->db->where('password', md5($password));

        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            $user = $query->row();

            if ($user->role == "CCC") {
                $redirect_page = "ccc";
            } else if ($user->role == "Marketing") {
                $redirect_page = "marketing";
            } else if ($user->role == "Agen") {
                $redirect_page = "agen";
            } else if ($user->role == "Finance") {
                $redirect_page = "finance";
            } else {
                redirect("auth");
            }

            $data = array(
                'user_id' => $user->id_user,
                'username' => $user->account_name,
                'logged_in' => TRUE,
                'role' => $user->role,
            );
            $this->session->set_userdata($data);
            redirect($redirect_page);

        } else {
            redirect('auth');
        }

    }

    // if ($username == "CCC" && $password == "CCC") {
    //     $data = array(
    //         'username' => $username,
    //         'logged_in' => TRUE,
    //         'pages' => 'ccc_role',
    //     );
    //     $this->session->set_userdata($data);
    //     redirect('ccc');            
    // }else if ($username == "Marketing" && $password == "Marketing") {
    //     $data = array(
    //         'username' => $username,
    //         'logged_in' => TRUE,
    //         'pages' => 'marketing_role',
    //     );
    //     $this->session->set_userdata($data);

    //     redirect('marketing');
    // } else if ($username == "Agen" && $password == "Agen") {
    //     $data = array(
    //         'username' => $username,
    //         'logged_in' => TRUE,
    //         'pages' => 'agen_role',
    //     );
    //     $this->session->set_userdata($data);

    //     redirect('agen');
    // }else if ($username == "Finance" && $password == "Finance") {
    //     $data = array(
    //         'username' => $username,
    //         'logged_in' => TRUE,
    //         'pages' => 'finance',
    //     );
    //     $this->session->set_userdata($data);

    //     redirect('finance');
    // }else {
    //     redirect('auth');

    // }





    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    public function email()
    {
        $output = ' <!DOCTYPE html>
        <html lang="id">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Promosi Voucher</title>
            <style>
                .content, .header,.footer {                  
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                    text-align: center;
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
        </head>
        
        <body>
            <div class="container">               
        
                <div class="content">
                    <h2>Halo Lukman Nugraha</h2>
                    <p class="promo-text">Anda mendapatkan E-voucher ongkir sebesar 10.000 yang bisa gunakan dengan ketentuan</p>
                </div>
                <ul>
                    <li>Berlaku hingga 5 Maret 2024</li>
                    <li>Hanya bisa digunakan 1 kali transaksi</li>
                    <li>Tidak ada pengembalian uang jika voucher melebihi harga ongkir</li>
                </ul>
        
                <div class="footer">
                    <p>Segera gunakan E-Voucher dengan kode adfkkafdjafierala di seluruh Agen Bandung Raya<br>Tim Promosi Voucher</p>
                </div>
            </div>
        </body>
        
        </html>
        ';
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

        $this->email->from('bdo.itproject@jne.co.id', 'VOUCHER');
        $this->email->to('lukman.nugraha@jne.co.id');
        $this->email->subject('Promotion');
        $this->email->message($output);
        // $this->email->send();
        if ($this->email->send()) {
            echo 'Email berhasil dikirim';
        } else {
            echo 'Email gagal dikirim';
            echo $this->email->print_debugger(); // Jika terjadi kesalahan, tampilkan pesan debug
        }

    }

    //     public function kirimEmail()
// {
//     $this->load->library('email'); // Load library email

    //     $config['protocol'] = 'smtp'; // Protokol pengiriman email
//     $config['smtp_host'] = 'localhost'; // Alamat server SMTP Anda
//     $config['smtp_user'] = 'adityaads623@gmail.com'; // Email pengirim
//     $config['smtp_pass'] = 'Duatujuhjuni2001'; // Password email pengirim
//     $config['smtp_port'] = 587; // Port server SMTP Anda

    //     $this->email->initialize($config);

    //     $this->email->from('adityaads623@gmail.com', 'Voucher'); // Email dan nama pengirim
//     $this->email->to('iqipulla123@gmail.com'); // Email penerima
//     $this->email->subject('Contoh Email'); // Subjek email
//     $this->email->message('Isi email yang ingin Anda kirim.'); // Isi email

    //     if ($this->email->send()) {
//         echo 'Email berhasil dikirim';
//     } else {
//         echo 'Email gagal dikirim';
//         echo $this->email->print_debugger(); // Jika terjadi kesalahan, tampilkan pesan debug
//     }
// }

}

?>