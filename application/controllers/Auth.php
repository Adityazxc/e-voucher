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

            if($user->role =="CCC"){
                $redirect_page="ccc";
            }else if($user->role == "Marketing"){
                $redirect_page= "marketing";
            }else if($user->role == "Agen"){
                $redirect_page= "agen";
            }else if($user->role == "Finance"){
                $redirect_page= "finance";
            }else{
                redirect("auth");
            }

            $data = array(
                'user_id' => $user->account_number,
                'username' => $user->account_name,
                'logged_in' => TRUE,
                'role' => $user->role
            );
            var_dump($data);
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

        $output = '';
        $output .= 'TEST EMAIL';
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
        $this->email->to('adityaads623@gmail.com');
        $this->email->subject('TEST EMAIL');
        $this->email->message($output);
        $this->email->send();
    }
}

?>