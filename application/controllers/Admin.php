<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model');
        $this->load->model('User_model');
        $this->session->set_userdata('pages', 'admin_role');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in') &&( $this->session->userdata('role') == 'Admin'|| $this->session->userdata('role') == 'Kacab')){
            $data['title'] = 'Dashboard Admin';
            $data['page_name'] = 'dashboard_admin';
            if ( $this->session->userdata('role') == 'Admin'){
                $data['role'] = 'Admin';
            }else{
                $data['role'] = 'Kacab';
            }
            $this->load->view('dashboard', $data);
        } else {
            redirect('auth');
        }

    }
    public function user_log()
    {
        if ($this->session->userdata('logged_in') &&( $this->session->userdata('role') == 'Admin'|| $this->session->userdata('role') == 'Kacab')){
            $data['title'] = 'Dashboard Admin';
            $data['page_name'] = 'user_log';
            if ( $this->session->userdata('role') == 'Admin'){
                $data['role'] = 'Admin';
            }else{
                $data['role'] = 'Kacab';
            }
            $this->load->view('dashboard', $data);
        } else {
            redirect('auth');
        }

    }

    public function detailUsers()
    {        
        $encodedId = $this->input->get('idUser');     
        $decodedId = base64_decode($encodedId);
        $data['title'] = 'Dashboard Admin';
        $data['page_name'] = 'detail_users';
        $data['role'] = 'Admin';        
        $userData = $this->User_model->get_user_details($decodedId);
        $data['userData'] = $userData;
        $this->load->view('dashboard', $data);
    }

    public function view_users_logs()
    {
        $list = $this->Admin_model->getdatatables_user();                    

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {

            $no++;
            $row = array();
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->account_name . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->role . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->ip_address . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->os . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->browser . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->login_time . '</small>';                                
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_user(),
            "recordsFiltered" => $this->Admin_model->count_filtered_user(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function view_users()
    {
        $list = $this->Admin_model->getdatatables_customer();

        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item) {

            $no++;
            $row = array();
            $row[] = '<small style="font-size:12px">' . $no . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->account_name . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->agent_area . '</small>';
            $row[] = '<small style="font-size:12px">' . $item->role . '</small>';
            $row[] = '<a href="#" onclick="detailUsers(' . $item->id_user . ')">' . $item->account_number . '</a>';

            if ($item->status_account == 1) {
                $status = 'Online';
                $row[] = '<small class="badge badge-boxed badge-soft-warning text-success" style="font-size:12px;">' . $status . '</small>';
            } else {
                $status = 'Offline';
                $row[] = '<small style="font-size:12px">' . $status . '</small>';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => @$_POST['draw'],
            "recordsTotal" => $this->Admin_model->count_all_customer(),
            "recordsFiltered" => $this->Admin_model->count_filtered_customer(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function reset_password()
    {
        $customerId = $this->input->post('customerId');
        $newPassword = $this->input->post('new_password');
        var_dump($newPassword);
        var_dump($customerId);
        if ($this->User_model->reset_password_model($customerId, $newPassword)) {
            echo "Email berhasil diperbarui!";
        } else {
            echo "Gagal memperbarui email.";
        }

        redirect("admin");
    }

    public function add_user(){        
        $user_data = array(
            'account_name' => $this->input->post('accountName'),
            'agent_area' => $this->input->post('agentArea'),
            'account_number' => $this->input->post('accountId'),
            'role' => $this->input->post('role'),                                    
        );              
        $user_data['password']=md5("123456");
        $user_data["agent_status"] ="Y";
        $user_data["status_account"] =0;
        $add_user=$this->User_model->add_user_model($user_data);
        // var_dump($user_data);
        $this->session->set_flashdata('notif', '<div class="alert alert-success" role="alert">Data Berhasil ditambahkan <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span><button><div> ');
        if ($add_user) {
            $this->session->set_flashdata('success', 'User berhasil ditambahkan');
            redirect(site_url('admin'), 'refresh');
        } else {
            // Proses selanjutnya jika voucher tidak berhasil diredeem
            $this->session->set_flashdata('error', 'User gagal ditambahkan');
            redirect(site_url('admin'), 'refresh');
        }
        


    }
}
