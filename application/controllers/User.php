<?php
class User extends CI_Controller
{
    public function index()
    {
        $data['user'] = $this->db->get('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "dashboard";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer', $data);
    }
}
