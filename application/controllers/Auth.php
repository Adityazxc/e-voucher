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
        if ($this->session->userdata('logged_in')) {
            redirect('ccc');
        }
        $this->load->view('index');
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        // $username = "CC";
        // $password = "CCC";

        if ($username == "CCC" && $password == "CCC") {
            $data = array(
                'username' => $username,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($data);

            redirect('ccc');
        }
        if ($username == "Marketing" && $password == "Marketing") {
            $data = array(
                'username' => $username,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($data);

            redirect('marketing');
        } if ($username == "Agen" && $password == "Agen") {
            $data = array(
                'username' => $username,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($data);

            redirect('agen');
        }if ($username == "Finance" && $password == "Finance") {
            $data = array(
                'username' => $username,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($data);

            redirect('finance');
        }else {
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