<?php
class Auth extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

    public function login()
    {
        $data['title'] = "Library System Login";
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        if($this->form_validation->run() == false){
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        }else{
            $this->verification();
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('image');
        $this->session->sess_destroy();
        redirect('auth/login');
    }

    private function verification(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if(!empty($user)){
            if($user['is_active'] == 1){
                if(password_verify($password, $user['password'])){
                    $data = array(
                        'email' => $user['email'],
                        'role_id' => $user['role_id'],
                        'id' => $user['id'],
                        'username' => $user['username'],
                        'image' => $user['image'],
                    );
                    $this->session->set_userdata($data);
                    if($user['role_id'] == 1){
                        redirect('user');
                    }else{
                        redirect('admin');
                    }
                }else{
                    redirect('auth/login');
                }
            }else{
                redirect('auth/login');
            }
        }else{
            redirect('auth/login');
        }
    }
    
    public function register()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|matches[repeatpassword]', ['matches' => 'Password not match!']);
        $this->form_validation->set_rules('repeatpassword', 'Repeat Password', 'required|trim|matches[password]');
        if($this->form_validation->run() == false){
            $data['title'] = "Library System SignUp";
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/register');
            $this->load->view('templates/auth_footer');
        }else{
            $username = $this->input->post('username', true);
            $email = $this->input->post('email', true);
            $password = $this->input->post('password');

            $data = array(
                "username" => $username,
                "email" => $email,
                "password" => password_hash($password, PASSWORD_DEFAULT),
                "role_id" => 1,
                "image" => "default.png",
                "is_active" => 1,
            );

            $this->db->insert('user', $data);
            redirect('auth/login');
        }
    }
}
