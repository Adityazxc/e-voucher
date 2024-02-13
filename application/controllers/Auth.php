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
            } else if ($user->password == "e10adc3949ba59abbe56e057f20f883e") {
                $redirect_page = "Agen/reset_password_view";
            }else if ($user->role == "Marketing") {
                $redirect_page = "marketing";
            } else if ($user->role == "Agen") {
                $redirect_page = "agen";
            } else if ($user->role == "Finance") {
                $redirect_page = "finance";
            }else if ($user->role == "CS") {
                $redirect_page = "cs";
            }
             else {
                redirect("auth");
            }

            $data_user = array(
                'id_user' => $user->id_user,
                'username' => $user->account_name,
                'logged_in' => TRUE,
                'role' => $user->role,
                'password'=>$user->password
            );
            $this->session->set_userdata($data_user);
            redirect($redirect_page);

        } else {
            redirect('auth');
        }

    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }


}

?>