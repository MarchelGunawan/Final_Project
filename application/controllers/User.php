<?php
class User extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('security');
    }

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

    public function table()
    {
        $data['user'] = $this->db->get('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "List Book";
        $data['table'] = $this->searchModel->listBook();
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/table', $data);
        $this->load->view('templates/footer', $data);
    }

    public function recommendation()
    {
        $data['user'] = $this->db->get('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Recommendation Book";

        //set the curl
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://127.0.0.1:8000/".$data['user']['id'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        //encode the API into array
        $data['response'] = json_decode($response, true);
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/recommendation', $data);
        $this->load->view('templates/footer', $data);
    }

    public function borrow_book($id='')
    {
        $data['user'] = $this->db->get('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = "Borrow Book";
        $this->form_validation->set_rules('days', 'Days', 'required|trim');
        if($this->form_validation->run() == false){
            $data['book'] = $this->searchModel->specific_book($id);
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/borrow_book', $data);
        }else{
            $userid = $this->input->post('userid');
            $bookid = $this->input->post('bookid');
            $days = $this->input->post('days');

            $data = array(
                "book_id" => $bookid,
                "user_id" => $userid,
                "borrow_date" => date("Y-m-d"),
                "due_date" => date('Y-m-d', (strtotime($days.' day', strtotime(Date("Y-m-d"))))),
            );

            $this->db->insert('borrow_records', $data);
            redirect("user/");
        }
    }
}
