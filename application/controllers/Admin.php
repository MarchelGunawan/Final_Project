<?php 

class Admin extends CI_Controller
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $data['user'] = $this->db->get('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "dashboard";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer', $data);
    }
}
